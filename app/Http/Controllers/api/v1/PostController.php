<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\v1\StorePostRequest;
use App\Http\Requests\v1\UpdatePostRequest;

use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        return Post::paginate(10);
    }

    // public function store(StorePostRequest $request)
    // {
    //     $data = $request->all();
        
    //     Post::create($data);

    //     return [
    //         'message'=>'Student Enrolled successfully'
    //     ];
    // }

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
