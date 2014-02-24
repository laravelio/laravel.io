<?php namespace Lio\Bin;

interface PasteCreatorResponder
{
    public function pasteCreated($paste);
    public function pasteValidationError($errors);
}
