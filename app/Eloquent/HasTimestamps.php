<?php
namespace Lio\Eloquent;

trait HasTimestamps
{
    /**
     * @return \Carbon\Carbon
     */
    public function createdAt()
    {
        return $this->created_at;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt()
    {
        return $this->updated_at;
    }
}
