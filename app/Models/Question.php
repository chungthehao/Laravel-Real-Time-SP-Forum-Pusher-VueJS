<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title', 'slug', 'body', 'category_id', 'user_id'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['replies'];

    protected static function boot()
    {
        parent::boot();
        // Khi dùng eloquent lưu data, ko cần truyền slug, tự tạo cho mình từ title
        static::creating(function ($question) {
            $question->slug = str_slug($question->title);
        });
    }

    public function getRouteKeyName()
    {
        // Route model bindings: tự chuẩn bị $question instance theo slug trên url thay vì là id
        return 'slug';
    }

    public function getPathAttribute()
    {
        return "questions/$this->slug";
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
