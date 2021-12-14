<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function Article()
    {
        $this->hasMany(Article::class, 'author_id','id');
    }
}