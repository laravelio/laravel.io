<?php namespace Lio\Bin;

use McCool\LaravelAutoPresenter\BasePresenter;

class PastePresenter extends BasePresenter
{
    public function code()
    {
        $code = $this->resource->code;
        $code = $this->convertNewlines($code);
        return $code;
    }

    public function createUrl()
    {
        return action('PastesController@getCreate');
    }

    public function showUrl()
    {
        return action('PastesController@getShow', $this->hash);
    }

    public function forkUrl()
    {
        return action('PastesController@getFork', $this->hash);
    }

    public function rawUrl()
    {
        return action('PastesController@getRaw', $this->hash);
    }

    protected function convertNewlines($content)
    {
        return str_replace("\n\n", '<br/>', $content);
    }
}
