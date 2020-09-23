<?php

namespace ManaCMS\ManaCategories\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function childs()
    {
        return $this->hasMany(Category::class,'parent_id');
    }
    public function moreChilds()
    {
        return $this->hasMany(Category::class,'parent_id')->with('childs');
    }

    public function posts()
    {
        return $this->morphedByMany(Post::class,'categorizable');
    }
}
