<?php namespace Lio\Github\Requests;

class UserRequest extends CurlRequest
{
    protected $url = 'https://api.github.com/user';

    public function request($accessToken)
    {
        $this->init($this->url . '?access_token=' . $accessToken);
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setOption(CURLOPT_HTTPHEADER, [
            'Accept: application/vnd.github.v3',
        ]);
        $this->setOption(CURLOPT_USERAGENT, 'LaravelIO');
        $result = $this->execute();
        $this->close();

        return $this->jsonResponse($result);
    }
} 
