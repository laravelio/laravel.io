<?php

namespace App\Models;

use App\Concerns\HasAuthor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditLog extends Model
{
    use HasAuthor;
    use HasFactory;

    protected $fillable = [
        'author_id',
        'editable_id',
        'editable_type',
        'edited_at',
    ];

    protected $dates = [
        'edited_at',
    ];

    protected $with = [
        'authorRelation',
    ];

    public $timestamps = false;

    public function editable()
    {
        return $this->morphTo();
    }
}
