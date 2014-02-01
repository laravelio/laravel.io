<?php namespace Lio\Bin;

use Hashids\Hashids;

class PasteCreator
{
    protected $pastes;
    protected $hashids;

    public function __construct(PasteRepository $pastes, Hashids $hashids)
    {
        $this->pastes = $pastes;
        $this->hashids = $hashids;
    }

    public function create($observer, $code, $user)
    {
        $paste = $this->createPaste($code, $user);
        if ( ! $this->pastes->save($paste)) {
            return $observer->pasteValidationError($paste->getErrors());
        }
        $this->addHash($paste);
        return $observer->pasteCreated($paste);
    }

    protected function createPaste($code, $user)
    {
        $paste = $this->pastes->getNew(['code' => $code]);
        $paste->author = $user;
        return $paste;
    }

    protected function addHash($paste)
    {
        $paste->hash = $this->hashids->encrypt($paste->id);
        $this->pastes->save($paste);
    }
}