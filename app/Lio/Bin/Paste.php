<?php namespace Lio\Bin;

use Lio\Core\Entity;

class Paste extends Entity {

    protected $table      = 'pastes';
    protected $fillable   = ['description', 'code', 'author_id', 'parent_id'];
    protected $with       = ['comments'];
    protected $softDelete = true;

    protected $validationRules = [
        'code' => 'required',
    ];

    public function parent()
    {
        return $this->belongsTo('Lio\Bin\Paste', 'parent_id');
    }
}