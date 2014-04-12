<?php namespace Lio\Github\Requests;

class UserEmailRequest extends CurlRequest
{
    protected $url = 'https://api.github.com/user/emails';

    public function request($accessToken)
    {
        $this->init($this->url . '?access_token=' . $accessToken);
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setOption(CURLOPT_HTTPHEADER, [
            'Accept: application/vnd.github.v3+json',
        ]);
        $this->setOption(CURLOPT_USERAGENT, 'LaravelIO');
        $result = $this->execute();
        $this->close();

        return $this->jsonResponse($result);
    }
} 
