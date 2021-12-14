<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'author_id',
        'title',
        'sub_title',
        'description',
        'slug',
        'is_active'
    ];

    public function author()
    {
        $this->belongsTo(Author::class, 'author_id','id');
    }
}
