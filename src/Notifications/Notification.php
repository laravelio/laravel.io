<?php  namespace Lio\Notifications;

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

    public function setModel(Model $object)
    {
        $this->attributes['model_type'] = get_class($object);
        $this->attributes['model_id'] = $object->getKey();
    }

    public function markRead()
    {
        if ($this->exists) {
            $this->delete();
        }
    }
} 
