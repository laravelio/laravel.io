<?php namespace Lio\Bin;

class PasteForkCreator implements PasteCreatorListener
{
    protected $listener;
    protected $parent;
    protected $pastes;

    public function __construct(PasteRepository $pastes)
    {
        $this->pastes = $pastes;
    }

    public function setListener($listener)
    {
        $this->listener = $listener;
    }

    public function setParentPaste($parent)
    {
        $this->parent = $parent;
    }

    public function pasteCreated($paste)
    {
        $paste->parent = $this->parent;
        if ( ! $this->pastes->save($paste)) {
            return $this->pasteValidationError($paste->getErrors());
        }
        return $this->listener->pasteCreated($paste);
    }

    public function pasteValidationError($errors)
    {
        return $this->listener->pasteValidationError($errors);
    }
}