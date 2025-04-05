<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller 
{
    /**
     * Get all available posts
     *
     * @return array
     */
    private function getPosts()
    {
        return [
            ['id' => 1, 'title' => 'First Post', 'posted_by' => 'Ahmed','email'=> 'ahmed@gmail.com', 'created_at' => '2025-5-10 10:00:00', 'description' => 'This is the first post description'],
            ['id' => 2, 'title' => 'Second Post', 'posted_by' => 'Mohamed','email'=> 'mohamed@gmail.com', 'created_at' => '2024-11-10 10:00:00', 'description' => 'This is the second post description'],
            ['id' => 3, 'title' => 'Third Post', 'posted_by' => 'Ibrahem', 'email'=> 'ibrahem@gmail.com','created_at' => '2025-9-27 10:00:00', 'description' => 'This is the third post description'],
        ];
    }

    public function index() 
    {
        $posts = $this->getPosts();
        return view('posts.index', ['posts' => $posts]);
    }

    public function show($id)
    {
        $posts = $this->getPosts();
        
        // Find the post that matches the ID from the URL
        $post = collect($posts)->firstWhere('id', $id);

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
        return view('posts.create');
    }

    public function store(Request $request)
    {
       
        return to_route('posts.index');
    }
    
    public function edit($id)
    {
        $posts = $this->getPosts();
        
        // Find the post that matches the ID from the URL
        $post = collect($posts)->firstWhere('id', (int)$id);

        // If post not found, redirect to posts index or return 404
        if (!$post) {
            abort(404);
        }

        return view('posts.edit', [
            'post' => $post,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        // In a real application, you would update the post in your database
        // For this demo, we'll just redirect back to the index
        
        return to_route('posts.index');
    }
}