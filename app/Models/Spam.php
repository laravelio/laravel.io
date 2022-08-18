<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spam extends Model
{
    use HasFactory;

    protected $table = 'spam';

    protected $fillable = [
        'user_id',
        'spammable_id',
        'spammable_type',
    ];

    public function spammable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
