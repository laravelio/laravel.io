<?php namespace Lio\Bin\Entities;

use Illuminate\Database\Eloquent\Model;
use Lio\Accounts\Member;

class Paste extends Model
{
    protected $table      = 'pastes';
    protected $fillable   = ['code', 'author_id', 'parent_id'];
    protected $softDelete = true;

    public $presenter = 'Lio\Bin\PastePresenter';

    public function author()
    {
        return $this->belongsTo('Lio\Accounts\Member', 'author_id');
    }

    public function parent()
    {
        return $this->belongsTo('Lio\Bin\Entities\Paste', 'parent_id');
    }

    public static function createPaste($author, $code)
    {
        return new static([
            'author_id' => is_null($author) ? null : $author->id,
            'code' => $code,
        ]);
    }

    public function fork($author, $code)
    {
        return new static([
            'parent_id' => $this->id,
            'author_id' => is_null($author) ? null : $author->id,
            'code' => $code,
        ]);
    }

    public function isOwnerBy(Member $author)
    {
        return $author->id == $this->author_id;
    }
}
