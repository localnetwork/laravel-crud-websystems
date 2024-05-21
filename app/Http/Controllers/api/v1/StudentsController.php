<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Students;
use App\Http\Requests\v1\StoreStudentsRequest;
use App\Http\Requests\v1\UpdateStudentsRequest;

use App\Http\Controllers\Controller;

class StudentsController extends Controller
{
    public function index()
    {
        return Students::paginate(10);
    }

    // public function store(StoreStudentsRequest $request)
    // {
    //     $data = $request->all();
        
    //     Students::create($data);

    //     return [
    //         'message'=>'Student Enrolled successfully'
    //     ];
    // }

    // public function show(Students $students,$id)
    // {
    //     return Students::find($id);
    // }
    public function update(UpdateStudentsRequest $request, Students $students,$id)
    {
        $student = Students::find($id);
        if($student){

            $student->update($request->all());
            return response()->json(['message' => 'Success'],200);
        }else{
            return response()->json(['message' => 'Student not found'],400);
        }
    }

    // public function destroy(Students $students,$id)
    // {
    //     $student = Students::find($id);

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
