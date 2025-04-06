<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller 
{
    

    public function index() 
    {


        $posts = Post::all();
        // dd($posts);
        return view('posts.index', compact('posts'));
    }

    public function show($id)
    {
        
        
        // Find the post that matches the ID from the URL
        // $post = Post::find($id);
        $post = Post::where('id', $id)->first();

       
        // If post not found, redirect to posts index or return 404
        if (!$post) {
            abort(404);
        }

        return view('posts.show', [
            'post' => $post,
        ]);
    }

    public function create()
    {
        $users = User::all();
        return view('posts.create',[
            "users"=> $users
        ]);
    }

    public function store(Request $request)
    {
        $title = request()->title;
        $description = request()->description;
        $postCreator = request()->post_creator;
       
        // old syntax 
        // $post = new Post;
        // $post->title = $title;
        // $post->description = $description;

        // $post->save();

        Post::create([
            'title' => $title,
            'description' => $description,
            'user_id' => $postCreator
        ]);

        return to_route('posts.index');
    }
    
    public function edit($id)
    {
        // Find the post that matches the ID from the database
        $post = Post::findOrFail($id);
        
        // Get all users for the dropdown
        $users = User::all();

        return view('posts.edit', compact('post', 'users'));
    }
    
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'post_creator' => 'required|exists:users,id'
        ]);
        
        // Find the post
        $post = Post::findOrFail($id);
        
        // Update the post
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->post_creator
        ]);
        
        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }
}