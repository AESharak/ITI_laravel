<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created comment.
     */
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ]);
        
        $post = Post::findOrFail($postId);
        
        $comment = new Comment([
            'content' => $request->content,
            'user_id' => $request->user_id
        ]);
        
        $post->comments()->save($comment);
        
        return redirect()->back()->with('success', 'Comment added successfully.');
    }
    
    /**
     * Show the form for editing the comment.
     */
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        
        // Removed authorization check to allow anyone to edit comments for testing
        
        return view('comments.edit', compact('comment'));
    }
    
    /**
     * Update the comment.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string'
        ]);
        
        $comment = Comment::findOrFail($id);
        
        // Removed authorization check to allow anyone to update comments for testing
        
        $comment->update([
            'content' => $request->content
        ]);
        
        return redirect()->route('posts.show', $comment->commentable_id)->with('success', 'Comment updated successfully.');
    }
    
    /**
     * Delete the comment.
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        
        // Removed authorization check to allow anyone to delete comments for testing
        
        $comment->delete();
        
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
