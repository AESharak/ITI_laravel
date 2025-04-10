<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller 
{
    

    public function index() 
    {
        // Change from latest() to orderBy('id') to sort by ID
        // Added with('user') to eager load the user relationship
        $posts = Post::with('user')->latest('id')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function show($id)
    {
        // Find the post that matches the ID from the URL
        // $post = Post::find($id);
        $post = Post::with(['user', 'comments.user'])->where('id', $id)->first();

       
        // If post not found, redirect to posts index or return 404
        if (!$post) {
            abort(404);
        }

        // Get all users for the comment form
        $users = User::all();

        return view('posts.show', [
            'post' => $post,
            'users' => $users
        ]);
    }

    public function create()
    {
        $users = User::all();
        return view('posts.create',[
            "users"=> $users
        ]);
    }

    public function store(StorePostRequest $request)
    {
        // Extract validated data
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->post_creator,
        ];
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }
        
        // Create the post
        Post::create($data);

        return to_route('posts.index')->with('success', 'Post created successfully');
    }
    
    public function edit($id)
    {
        // Find the post that matches the ID from the database
        $post = Post::findOrFail($id);
        
        // Get all users for the dropdown
        $users = User::all();

        return view('posts.edit', compact('post', 'users'));
    }
    
    public function update(StorePostRequest $request, $id)
    {
        // Find the existing post
        $post = Post::findOrFail($id);
        
        // Handle image deletion if checkbox is checked
        if ($request->has('delete_image') && $post->image) {
            // Delete the image file from storage
            Storage::disk('public')->delete($post->image);
            
            // Directly update the image column in the database
            $post->timestamps = false; // Prevent updated_at from being changed
            $post->getConnection()->table('posts')
                ->where('id', $post->id)
                ->update(['image' => null]);
            $post->timestamps = true; // Re-enable timestamps
            
            // Refresh the model to reflect the database change
            $post->refresh();
        }
        
        // Prepare data for update
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->post_creator
        ];
        
        // Add image to update data if a new image was uploaded
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }
        
        // Update the post
        $post->update($data);
        
        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->comments()->delete();
        $post->delete();
        
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }
}