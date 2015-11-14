<?php
namespace Lio\DateTime;

interface Timestamps
{
    /**
     * @return \Carbon\Carbon
     */
    public function createdAt();

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt();
}
