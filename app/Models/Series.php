<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasAuthor;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'title',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
