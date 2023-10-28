<?php

namespace Modules\Post\Domain\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title', 'slug', 'content',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
    ];
}
