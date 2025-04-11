<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index (){
        $posts = Post::with('user')->paginate(10);
        return PostResource::collection($posts);
    }

    public function show($id){
        // $post = Post::find($id);
        // return [
        //     'id' => $post->id,
        //     'title' => $post->title,
        //     'description' => $post->description,
        //     'image' => $post->image
        // ];
        $post = Post::with('user')->find($id);
        if (!$post){
            return response()->json([
                'message' => 'Post not found',
                'status' => 'error'
            ], 404);
        }
        return new PostResource($post);
    }
    
    public function store(StorePostRequest $request){
        $title = $request->title;
        $description = $request->description;
        $postCreator = $request->post_creator;
        $data = [
            'title' => $title,
            'description' => $description,
            'user_id' => $postCreator,
        ];
        if ($request->hasFile('image')){
            $data['image'] = $request->file('image');
        }
        $post = Post::create($data);
        // return [
        //     'id' => $post->id,
        //     'title' => $post->title,
        //     'description' => $post->description,
        //     'image' => $post->image
        // ];
        return new PostResource($post);
    }


}
