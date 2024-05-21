<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\v1\StorePostRequest;
use App\Http\Requests\v1\UpdatePostRequest;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index(Request $request)
{
    // Default values for pagination and order
    $perPage = $request->query('per_page', 10);
    $orderBy = $request->query('order_by', 'id');
    $orderDirection = $request->query('order_direction', 'desc');

    // Get posts with user relationship, dynamically order them, and paginate
    return Post::with('user')
        ->orderBy($orderBy, $orderDirection)
        ->paginate($perPage);
} 

 
    public function store(Request $request) {
        // Retrieve all the request data
        $data = $request->all();
        
        // Get the authenticated user
        $user = auth()->user();

        // Ensure user is authenticated using Sanctum
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Add the user_id to the data array
        $data['user_id'] = $user->id;

        // Validate the request data
        $validator = Validator::make($data, [
            'title' => 'required',
            'content' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new Post instance and save the data
        $post = new Post();
        $post->title = $data['title'];
        $post->content = $data['content'];
        $post->user_id = $data['user_id'];
        $post->save();

        // Load the user relationship
        $post->load('user');

        // Return the response with the post and user info
        return response()->json([
            'message' => 'Post added successfully.',
            'data' => $post 
        ], 200);
    }  

    public function show(Post $post, $id)
    {
        $post = Post::with('user')->find($id);
        if ($post) {
            return response()->json(['data' => $post], 200);
        } else {
            return response()->json(['message' => 'Post not found'], 404);
        }
    }

    public function update(Request $request, Post $post, $id)
{
    // Retrieve the post by its ID
    $post = Post::find($id);

    // Check if the post exists
    if(!$post){
        return response()->json(['message' => 'Post not found'], 400);
    }
 
    // Get the currently authenticated user
    $user = auth()->user();

    // Check if the user is authorized to update the post
    if ($post->user_id !== $user->id) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // Update the post with the request data
    $post->update($request->all()); 

    // Return a success response
    return response()->json([
        'message' => 'Post has been updated.', 
        "data" => $post
    ], 200);
} 

    public function destroy(Post $post,$id)
    {
        $post = Post::find($id);

        if($post){

            $post->delete();
            
            return [
                'message'=>'Post Deleted successfully'
            ];
        }else{
            return [
                'message'=>'Post not found'
            ];
        }
    } 
}
