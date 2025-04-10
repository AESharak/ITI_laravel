<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory, SoftDeletes, Sluggable, SluggableScopeHelpers;
    
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'image'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all comments for the post.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true, // This will make the slug update when the title changes
            ]
        ];
    }

    // Handle image uploads
    public function setImageAttribute($value)
    {
        if ($value && is_file($value)){
            // Delete old image if it exists
            if ($this->image){
                Storage::disk('public')->delete($this->image);
            }

            $path = $value->store('posts', 'public');
            $this->attributes['image'] = $path;
        }
    }

    // Get the full URL for the image 
    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    // Delete the image when post is deleted
    public static function boot()
    {
        parent::boot();
        
        static::deleting(function ($post) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
        });
    }

}
