<?php namespace Lio\Bin;

use App;

class PasteCreator
{
    protected $pastes;

    public function __construct(PasteRepository $pastes)
    {
        $this->pastes = $pastes;
    }

    public function create($observer, $code)
    {
        $paste = $this->pastes->getNew(['code' => $code]);
        if ( ! $this->pastes->save($paste)) {
            return $observer->pasteValidationError($paste->getErrors());
        }
        $this->addHash($paste);

        return $observer->pasteCreated($paste);
    }

    protected function addHash($paste)
    {
        $paste->hash = App::make('hashids')->encrypt($paste->id);
        $this->pastes->save($paste);
    }
}