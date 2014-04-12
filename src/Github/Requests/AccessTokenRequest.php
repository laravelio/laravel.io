<?php namespace Lio\Github\Requests;

class AccessTokenRequest extends CurlRequest
{
    protected $url = 'https://github.com/login/oauth/access_token';

    public function request($clientId, $clientSecret, $code)
    {
        $fields = [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'code' => $code,
        ];

        $this->init($this->url);
        $this->setOption(CURLOPT_POST, count($fields));
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setOption(CURLOPT_POSTFIELDS, $fields);
        $this->setOption(CURLOPT_HTTPHEADER, [
            'Accept' => 'application/vnd.github.v3+json',
        ]);
        $result = $this->execute();
        $this->close();

        parse_str($result, $output);
        return $output;
    }
} 
