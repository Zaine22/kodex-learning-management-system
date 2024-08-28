<?php

namespace App\Modules\Auth\Http\Controllers\Api;
use App\Models\Instructor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class InstructorController extends Controller{
 public function instructorCreate(Request $request){
    Validator::make($request->all(),[
        'professional_field_id'=>'required|exists:professional_field,id',
        'work_experience_year'=>'required|integer',
        'teaching_experience_year'=>'required|integer',
    ])->validate();

    try {
        $instructor=Instructor::create([
            'user_id'=>Auth::id(),
            'professional_field_id'=>$request->professional_field_id,
            'work_experience_year'=>$request->work_experience_year,
            'teaching_experience_year'=>$request->teaching_experience_year
        ]);
        return response()->json([
            'status'=>true,
            'data'=>[
                'instructor'=>$instructor,
            ],
            'message'=>'Instructor create successfully'
        ],201);
    } catch (\Throwable $th) {
        return response()->json([
            'status'=>false,
            'data'=>[
                'instructor'=>null,
            ],
            'message'=>'Error Creating Instructor'.$th->getMessage(),
        ],500);
    }
 }
}
