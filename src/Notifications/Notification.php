<?php  namespace Lio\Notifications;

use Lio\Core\SingleTableInheritanceEntity;

class Notification extends SingleTableInheritanceEntity
{
    protected $table = 'notifications';
    protected $subclassField = 'class';

    protected $fillable = [];
    protected $softDelete = true;

    public function subject()
    {
        return $this->morphTo();
    }

    public function markRead()
    {
        if ($this->exists) {
            $this->delete();
        }
    }
} 
