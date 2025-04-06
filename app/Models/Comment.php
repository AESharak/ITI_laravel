<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'content',
        'user_id',
        'commentable_id',
        'commentable_type'
    ];
    
    /**
     * Get the parent commentable model (post, etc).
     */
    public function commentable()
    {
        return $this->morphTo();
    }
    
    /**
     * Get the user who wrote the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
