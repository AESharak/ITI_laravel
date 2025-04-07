<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller 
{
    

    public function index() 
    {
        // Change from latest() to orderBy('id') to sort by ID
        // Added with('user') to eager load the user relationship
        $posts = Post::with('user')->orderBy('id')->paginate(10);
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
        // $request->validate([
        //     'title' => ['required','min:3'],
        //     'description' => ['required','min:10'],
        //     'post_creator' => ['required'],
        // ],[
        //     'title.required' => "اكتب هنا متسيبهاش فاضية" ,
        //     'title.min' => "معلش زود شويه .. متكتبش اقل من 3 حروف" ,
        //     'description.required' => "اكتب هنا متسيبهاش فاضية" ,
        //     'description.min' => "معلش زود شويه .. متكتبش اقل من 10 حروف" ,
        // ]);
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
        $post->comments()->delete();
        $post->delete();
        
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }
}