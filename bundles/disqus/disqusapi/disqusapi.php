<?php
/**
 * Implementation of the Disqus API.
 *
 * http://disqus.com/api/
 *
 * @author		DISQUS <team@disqus.com>
 * @copyright           2007-2010 Big Head Labs
 * @link		http://disqus.com/
 * @package		disqusapi
 * @version		0.1.1
 *
 * Example:
 *
 * $disqus = new DisqusAPI($secret_key)
 * $disqus->trends->listThreads()
 *
 * **********************************************************************
 *
 * Plus modifications made by Roumen Damianoff <roumen@dawebs.com>
 *
 * @link https://github.com/RoumenMe/disqus-php Roumen's disqus-php fork
 * @link http://roumen.me/projects/laravel-disqus Laravel bundle project
 *
 * Important note:
 *
 * $disqus->setSecure(false); can be used to turn on/off SSL
 *
 * **********************************************************************
 */

if (!defined('DISQUS_API_HOST')) {
    define('DISQUS_API_HOST', 'disqus.com');
}
define('DISQUS_API_VERSION', '0.0.1');

require_once(dirname(__FILE__) . '/url.php');

if (!extension_loaded('json')) {
	require_once(dirname(__FILE__) . '/json.php');
	function dsq_json_decode($data) {
		$json = new JSON;
		return $json->unserialize($data);
	}
} else {
	function dsq_json_decode($data) {
		return json_decode($data);
	}
}

global $DISQUS_API_INTERFACES;

$DISQUS_API_INTERFACES = dsq_json_decode(file_get_contents(dirname(__FILE__) . '/interfaces.json'));

class DisqusInterfaceNotDefined extends Exception {}
class DisqusAPIError extends Exception {
    public function __construct($code, $message) {
        $this->code = $code;
        $this->message = $message;
    }
}

class DisqusResource {
    public function __construct($api, $interface=null, $node=null, $tree=array()) {
        global $DISQUS_API_INTERFACES;

        if (!$interface) {
            $interface = $DISQUS_API_INTERFACES;
        }
        $this->api = $api;
        $this->interface = $interface;
        $this->node = $node;
        if ($node) {
            array_push($tree, $node);
        }
        $this->tree = $tree;
    }

    public function __get($attr) {
        $interface = $this->interface->$attr;
        if (!$interface) {
            throw new DisqusInterfaceNotDefined();
        }
        return new DisqusResource($this->api, $interface, $attr, $this->tree);
    }

    public function __call($name, $args) {
        $resource = $this->interface->$name;
        if (!$resource) {
            throw new DisqusInterfaceNotDefined();
        }
        $kwargs = (array)$args[0];

        foreach ((array)$resource->required as $k) {
            if (empty($kwargs[$k])) {
                throw new Exception('Missing required argument: '.$k);
            }
        }

        $api = $this->api;

        if (empty($kwargs['api_secret'])) {
            $kwargs['api_secret'] = $api->key;
        }

        // emulate a named pop
        $version = (!empty($kwargs['version']) ? $kwargs['version'] : $api->version);
        $format = (!empty($kwargs['format']) ? $kwargs['format'] : $api->format);
        unset($kwargs['version'], $kwargs['format']);

        $url = ($api->secure ? 'https://'.DISQUS_API_HOST : 'http://'.DISQUS_API_HOST);
        $path = '/api/'.$version.'/'.implode('/', $this->tree).'/'.$name.'.'.$format;

        if (!empty($kwargs)) {
            if ($resource->method == 'POST') {
                $post_data = $kwargs;
            } else {
                $post_data = false;
                $path .= '?'.dsq_get_query_string($kwargs);
            }
        }


        $response = dsq_urlopen($url.$path, $post_data);

        $data = call_user_func($api->formats[$format], $response['data']);

        if ($response['code'] != 200) {
            throw new DisqusAPIError($data->code, $data->response);
        }

        return $data->response;
    }
}


class DisqusAPI extends DisqusResource {
    public $formats = array(
        'json' => 'dsq_json_decode'
    );

    public function __construct($key=null, $format='json', $version='3.0', $secure=true) {
        $this->key = $key;
        $this->format = $format;
        $this->version = $version;
        $this->secure = $secure;
        parent::__construct($this);
    }

    public function __invoke() {
        throw new Exception('You cannot call the API without a resource.');
    }

    public function setKey($key) {
        $this->key = $key;
    }

    public function setFormat($format) {
        $this->format = $format;
    }

    public function setVersion($version) {
        $this->version = $version;
    }

    public function setSecure($secure) {
        $this->secure = $secure;
    }
}