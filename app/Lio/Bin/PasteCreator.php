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
        $this->cats();
        return $observer->pasteCreated($paste);
    }

    protected function createPaste($code, $user)
    {
        return $this->pastes->getNew(['code' => $code, 'author' => $user]);
    }

    protected function addHash($paste)
    {
        $paste->hash = $this->hashids->encrypt($paste->id);
        $this->pastes->save($paste);
    }
}
