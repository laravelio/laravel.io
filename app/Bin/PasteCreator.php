<?php
namespace Lio\Bin;

use Hashids\Hashids;
use Request;

class PasteCreator
{
    protected $pastes;
    protected $hashids;

    public function __construct(PasteRepository $pastes, Hashids $hashids)
    {
        $this->pastes = $pastes;
        $this->hashids = $hashids;
    }

    public function create($observer, $code, $user, $validator = null)
    {
        if ($validator && ! $validator->isValid()) {
            return $observer->pasteValidationError($validator->getErrors());
        }

        $paste = $this->createPaste($code, $user);
        if ( ! $this->pastes->save($paste)) {
            return $observer->pasteValidationError($paste->getErrors());
        }
        $this->addHash($paste);
        return $observer->pasteCreated($paste);
    }

    protected function createPaste($code, $user)
    {
        return $this->pastes->getNew(['code' => $code, 'author' => $user, 'ip' => Request::getClientIp()]);
    }

    protected function addHash($paste)
    {
        $paste->hash = $this->hashids->encode($paste->id);
        $this->pastes->save($paste);
    }
}
