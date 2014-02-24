<?php  namespace Lio\Notifications;

use Illuminate\Database\Eloquent\Model;
use Lio\Core\SingleTableInheritanceEntity;

class Notification extends SingleTableInheritanceEntity
{
    protected $table = 'notifications';
    protected $subclassField = 'class';

    protected $fillable = ['user_id'];
    protected $softDelete = true;

    public function subject()
    {
        return $this->morphTo();
    }

    public function setSubject(Model $object)
    {
        $this->attributes['subject_type'] = get_class($object);
        $this->attributes['subject_id'] = $object->getKey();
    }

    public function markRead()
    {
        if ($this->exists) {
            $this->delete();
        }
    }
} 
