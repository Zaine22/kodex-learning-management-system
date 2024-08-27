<?php

namespace App\Modules\Auth\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\professional_field;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProfessionalFieldController extends Controller
{
    //list
   public function index(Request $request){
    try {
        $professional=professional_field::when(request('key'),function($query){
            $query->orWhere('name','like','%'.request('key').'%');
            $query->orWhere('description','like','%'.request('key').'%');
        })->paginate(5);
        return response()->json([
            'status'=>true,
            'data'=>[
                'professional'=>$professional
            ],
            'message'=>'Lists of Roles'
        ],200);
    } catch (\Throwable $th) {
        return response()->json([
            'status'=>false,
            'data'=>null,
            'message'=>"Error fetching professional: " . $th->getMessage(),
        ],500);
    }
}

  //create
  public function store(Request $request){
   $this->validationStore($request);
   $data=$this->requestData($request);

   try {
   $professional= professional_field::create($data);
    return response()->json([
        'status'=>true,
        'data'=>[
            'professional'=>$professional
        ],
        'message'=>"Professional created successfully",
    ],201);
   } catch (\Throwable $th) {
    return response()->json([
        'status'=>false,
        'data'=>null,
        'message'=>"Error creating professional:".$th->getMessage(),
    ],500);
   }
  }

  //show
  public function show(professional_field $professionalField){
    try {
        return response()->json([
            'status'=>true,
            'data'=>$professionalField,
            'message'=>"Professional fetched successfully"
        ],200);
    } catch (\Throwable $th) {
        return response()->json([
            'status'=>false,
            'data'=>null,
            'message'=>"Error fetching Professional:".$th->getMessage(),
        ],200);
    }
  }

  //update
  public function update(Request $request, professional_field $professionalField){
    $this->validationStore($request);
    $data=$this->requestData($request);

    try {
      $professional=  professional_field::update($data);
      return response()->json([
        'status'=>true,
        'data'=>[
            'professional'=>$professional
        ],
        'message'=>"Update Professional Successfully"
    ],200);
    } catch (\Throwable $th) {
        return response()->json([ 'status'=>false,
        'data'=>null,
        'message'=>"Error Updating Professional".$th->getMessage()
    ],500);

    }
  }

  //delete
  public function destroy (professional_field $professionalField){
    try {
       $professionalField->delete();
    } catch (\Throwable $th) {
       return response()->json([
        'status'=>false,
        'data'=>null,
        'message'=>"Error Deleting Professional".$th->getMessage(),
       ],500);
    }
  }

  //validation Store
  private function validationStore($request){
    Validator::make($request->all(),[
        'name'=>'required|string|unique:professional_fields,name,',
        'description'=>'required|string,'
    ])->validate();
  }

  //request data
  private function requestData($request){
    return [
        'name'=>$request->name,
        'description'=>$request->description
    ];
  }
}

