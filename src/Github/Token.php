<?php namespace Lio\Github; 

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'github_tokens';
    protected $guarded = [];
} 
