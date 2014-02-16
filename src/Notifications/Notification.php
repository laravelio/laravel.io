<?php  namespace Lio\Notifications; 

use Lio\Core\Entity;

class Notification extends Entity
{
    protected $table      = 'notifications';
    protected $fillable   = ['user_id', 'object_type', 'object_id'];
    protected $softDelete = true;

    public function markRead()
    {
        if ($this->exists) {
            $this->delete();
        }
    }
} 
