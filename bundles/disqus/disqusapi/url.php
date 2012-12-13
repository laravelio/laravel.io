<?php
define('USER_AGENT', 'disqus-php/'.DISQUS_API_VERSION);
define('SOCKET_TIMEOUT', 10);

function dsq_get_query_string($postdata) {
    $postdata_str = '';

    if($postdata) {
        foreach($postdata as $key=>$value) {
            if (!is_array($value)) {
                $postdata_str .= urlencode($key) . '=' . urlencode($value) . '&';
            } else {
                // if the item is an array, expands it so that the 'allows multiple' API option can work
                foreach($value as $multipleValue) {
                    $postdata_str .= urlencode($key) . '=' . urlencode($multipleValue) . '&';
                }
            }
        }
    }

    return $postdata_str;
}


function dsq_get_post_content($boundary, $postdata, $file_name, $file_field) {
    if(empty($file_name) || empty($file_field)) {
        return dsq_get_query_string($postdata);
    }

    $content = array();
    $content[] = '--' . $boundary;
    foreach($postdata as $key=>$value) {
        $content[] = 'Content-Disposition: form-data; name="' . $key . '"' . "\r\n\r\n" . $value;
        $content[] = '--' . $boundary;
    }
    $content[] = 'Content-Disposition: form-data; name="' . $file_field . '"; filename="' . $file_name . '"';
    // HACK: We only need to handle text/plain files right now.
    $content[] = "Content-Type: text/plain\r\n";
    $content[] = file_get_contents($file_name);
    $content[] = '--' . $boundary . '--';
    $content = implode("\r\n", $content);
    return $content;
}


function dsq_get_http_headers_for_request($boundary, $content, $file_name, $file_field) {
    $headers = array();
    $headers[] = 'User-Agent: ' . USER_AGENT;
    $headers[] = 'Connection: close';
    if($content) {
        $headers[] = 'Content-Length: ' . strlen($content);
        if($file_name && $file_field) {
            $headers[] = 'Content-Type: multipart/form-data; boundary=' . $boundary;
        } else {
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        }
    }
    return implode("\r\n", $headers);
}


function _dsq_curl_urlopen($url, $postdata, &$response, $file_name, $file_field) {
    $c = curl_init($url);
    $postdata_str = dsq_get_query_string($postdata);

    $c_options = array(
        CURLOPT_USERAGENT        => USER_AGENT,
        CURLOPT_RETURNTRANSFER    => true,
        CURLOPT_POST            => ($postdata_str ? 1 : 0),
        CURLOPT_HTTPHEADER        => array('Expect:'),
        CURLOPT_TIMEOUT         => SOCKET_TIMEOUT
    );
    if($postdata) {
        $c_options[CURLOPT_POSTFIELDS] = $postdata_str;
    }
    if($file_name && $file_field) {
        $postdata[$file_field] = '@' . $file_name;
        $c_options[CURLOPT_POSTFIELDS] = $postdata;
        $c_options[CURLOPT_RETURNTRANSFER] = 1;
    }
    curl_setopt_array($c, $c_options);

    $response['data'] = curl_exec($c);
    $response['code'] = curl_getinfo($c, CURLINFO_HTTP_CODE);
}


function _dsq_fsockopen_urlopen($url, $postdata, &$response, $file_name, $file_field) {
    $buf = '';
    $req = '';
    $length = 0;
    $boundary = '----------' . md5(time());
    $postdata_str = dsq_get_post_content($boundary, $postdata, $file_name, $file_field);
    $url_pieces = parse_url($url);

    // Set default port for supported schemes if none is provided.
    if(!isset($url_pieces['port'])) {
        switch($url_pieces['scheme']) {
            case 'http':
                $url_pieces['port'] = 80;
                break;
            case 'https':
                $url_pieces['port'] = 443;
                $url_pieces['host'] = 'ssl://' . $url_pieces['host'];
                break;
        }
    }

    // Set default path if trailing slash is not provided.
    if(!isset($url_pieces['path'])) { $url_pieces['path'] = '/'; }

    // Determine if we need to include the port in the Host header or not.
    if(($url_pieces['port'] == 80  && $url_pieces['scheme'] == 'http') ||
        ($url_pieces['port'] == 443 && $url_pieces['scheme'] == 'https')) {
        $host = $url_pieces['host'];
    } else {
        $host = $url_pieces['host'] . ':' . $url_pieces['port'];
    }

    $fp = @fsockopen($url_pieces['host'], $url_pieces['port'], $errno, $errstr, SOCKET_TIMEOUT);
    if(!$fp) { return false; }

    $path = $url_pieces['path'];
    if ($url_pieces['query']) $path .= '?'.$url_pieces['query'];

    $req .= ($postdata_str ? 'POST' : 'GET') . ' ' . $path . " HTTP/1.1\r\n";
    $req .= 'Host: ' . $host . "\r\n";
    $req .=  dsq_get_http_headers_for_request($boundary, $postdata_str, $file_name, $file_field);
    if($postdata_str) {
        $req .= "\r\n\r\n" . $postdata_str;
    }
    $req .= "\r\n\r\n";

    fwrite($fp, $req);
    while(!feof($fp)) {
        $buf .= fgets($fp, 4096);
    }

    // Parse headers from the response buffers.
    list($headers, $response['data']) = explode("\r\n\r\n", $buf, 2);

    // Get status code from headers.
    $headers = explode("\r\n", $headers);
    list($unused, $response['code'], $unused) = explode(' ', $headers[0], 3);
    $headers = array_slice($headers, 1);

    // Convert headers into associative array.
    foreach($headers as $unused=>$header) {
        $header = explode(':', $header);
        $header[0] = trim($header[0]);
        $header[1] = trim($header[1]);
        $headers[strtolower($header[0])] = strtolower($header[1]);
    }

    // If transfer-coding is set to chunked, we need to join the message body
    // together.
    if(isset($headers['transfer-encoding']) && 'chunked' == $headers['transfer-encoding']) {
        $chunk_data = $response['data'];
        $joined_data = '';
        while(true) {
            // Strip length from body.
            list($chunk_length, $chunk_data) = explode("\r\n", $chunk_data, 2);
            $chunk_length = hexdec($chunk_length);
            if(!$chunk_length || !strlen($chunk_data)) { break; }

            $joined_data .= substr($chunk_data, 0, $chunk_length);
            $chunk_data = substr($chunk_data, $chunk_length + 1);
            $length += $chunk_length;
        }
        $response['data'] = $joined_data;
    } else {
        $length = $headers['content-length'];
    }
}


function _dsq_fopen_urlopen($url, $postdata, &$response, $file_name, $file_field) {
    $params = array();
    if($file_name && $file_field) {
        $boundary = '----------' . md5(time());
        $content = dsq_get_post_content($boundary, $postdata, $file_name, $file_field);
        $header = dsq_get_http_headers_for_request($boundary, $content, $file_name, $file_field);

        $params = array('http' => array(
            'method'    => 'POST',
            'header'    => $header,
            'content'    => $content,
            'timeout'    => SOCKET_TIMEOUT
        ));
    } else {
        if($postdata) {
            $params = array('http' => array(
                'method'    => 'POST',
                'header'    => 'Content-Type: application/x-www-form-urlencoded',
                'content'    => dsq_get_query_string($postdata),
                'timeout'    => SOCKET_TIMEOUT
            ));
        }
    }
    

    ini_set('user_agent', USER_AGENT);
    $ctx = stream_context_create($params);
    $fp = fopen($url, 'rb', false, $ctx);
    if(!$fp) {
        return false;
    }

    // Get status code from headers.
    list($unused, $response['code'], $unused) = explode(' ', $http_response_header[0], 3);
    $headers = array_slice($http_response_header, 1);

    // Convert headers into associative array.
    foreach($headers as $unused=>$header) {
        $header = explode(':', $header);
        $header[0] = trim($header[0]);
        $header[1] = trim($header[1]);
        $headers[strtolower($header[0])] = strtolower($header[1]);
    }

    $response['data'] = stream_get_contents($fp);
}


/**
 * Wrapper to provide a single interface for making an HTTP request.
 *
 * Attempts to use cURL or fsockopen(), whichever is available
 * first.
 *
 * @param    string    $url        URL to make request to.
 * @param    array    $postdata    (optional) If postdata is provided, the request
 *                                method is POST with the key/value pairs as
 *                                the data.
 * @param    array    $file        (optional) Should provide associative array
 *                                with two keys: name and field.  Name should
 *                                be the name of the file and field is the name
 *                                of the field to POST.
 */
function dsq_urlopen($url, $postdata=false, $file=false) {
    $response = array(
        'data' => '',
        'code' => 0
    );

    if($file) {
        extract($file, EXTR_PREFIX_ALL, 'file');
    }
    if(empty($file_name) || empty($file_field)) {
        $file_name = false;
        $file_field = false;
    }

    // Try curl, fsockopen, fopen + stream (PHP5 only), exec wget
    if(function_exists('curl_init')) {
     if (!function_exists('curl_setopt_array')) {
         function curl_setopt_array(&$ch, $curl_options)
         {
             foreach ($curl_options as $option => $value) {
                 if (!curl_setopt($ch, $option, $value)) {
                     return false;
                 } 
             }
             return true;
         }
     }
     _dsq_curl_urlopen($url, $postdata, $response, $file_name, $file_field);
    // } else if(ini_get('allow_url_fopen') && function_exists('stream_get_contents')) {
    //     _dsq_fopen_urlopen($url, $postdata, $response, $file_name, $file_field);
    } else {
        // TODO: Find the failure condition for fsockopen() (sockets?)
        _dsq_fsockopen_urlopen($url, $postdata, $response, $file_name, $file_field);
    }

    // returns array with keys data and code (from headers)

    return $response;
}

function dsq_url_method() {
    if(function_exists('curl_init')) {
        return 'curl';
    } else if(ini_get('allow_url_fopen') && function_exists('stream_get_contents')) {
        return 'fopen';
    } else {
        return 'fsockopen';
    }
}
?>
