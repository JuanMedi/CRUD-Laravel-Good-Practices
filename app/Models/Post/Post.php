<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable =[
        'title',
        'content',
        'status',
        'file_path',
        'file_type',
        'file_name'
    ];

    public const PAGINATE = 5;
}
