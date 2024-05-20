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

        $validator = Validator::make($data, [
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }  
        $post = new Post(); 

        $post->title = $data['title'];
        $post->content = $data['content'];
        $post->user_id = $data['user_id']; 
        $post->save();  
        return response()->json([
            'message' => 'Post added successfully.',
            'data' => $post 
        ], 200);  
    }     

    // public function show(Post $post,$id)
    // {
    //     return Post::find($id);
    // }
    // public function update(UpdatePostRequest $request, Post $post,$id)
    // {
    //     $student = Post::find($id);
    //     if($student){

    //         $student->update($request->all());
    //         return response()->json(['message' => 'Success'],200);
    //     }else{
    //         return response()->json(['message' => 'Student not found'],400);
    //     }
    // }

    // public function destroy(Post $post,$id)
    // {
    //     $student = Post::find($id);

    //     if($student){

    //         $student->delete();
            
    //         return [
    //             'message'=>'Student Deleted successfully'
    //         ];
    //     }else{
    //         return [
    //             'message'=>'Student not found'
    //         ];
    //     }
    // } 
}
