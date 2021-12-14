<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Article extends Model
{
    use SoftDeletes, Uuids;
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
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }


    public static $createRules = [
        'author_id' => 'required|exists:authors,id',
        'title' => 'required|string|max:100',
        'sub_title' => 'required|string|max:100',
        'description' => 'required|string',
        'slug' => 'string|max:100',
        'is_active' => 'required|boolean'
    ];

    public static $updateRules = [
        'id' => 'required|exists:articles,id',
        'author_id' => 'required|exists:authors,id',
        'title' => 'required|string|max:100',
        'sub_title' => 'required|string|max:100',
        'description' => 'required|string',
        'slug' => 'string|max:100',
        'is_active' => 'required|boolean'
    ];
}
