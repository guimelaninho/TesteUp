<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Author extends Model
{
    use SoftDeletes, Uuids;

    protected $fillable = [
        'name'
    ];

    public function article()
    {
        return $this->hasMany(Article::class, 'author_id', 'id');
    }

    public static $createRules = [
        'name' => 'required|max:255',
    ];

    public static $updateRules = [
        'id' => 'required|exists:authors,id',
        'name' => 'required|max:255',
    ];
}
