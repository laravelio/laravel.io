<?php
namespace Lio\Bin;

interface PasteCreatorListener {
    public function pasteCreated($paste);
    public function pasteValidationError($errors);
}
