<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title', 'slug', 'body', 'category_id', 'user_id'];

    public function getRouteKeyName()
    {
        // Route model bindings: tự chuẩn bị $question instance theo slug trên url thay vì là id
        return 'slug';
    }

    public function getPathAttribute()
    {
        return url("api/questions/$this->slug");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
