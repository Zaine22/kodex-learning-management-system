<?php

namespace App\Modules\ProfessionalField\Services;

use App\Modules\ProfessionalField\Models\ProfessionalField;

class ProfessionalFieldService {
    public function all(){
     $professionalField= ProfessionalField::when(request('key'),function($query){
        $query->orWhere('name','like','%'.request('key').'%');
        $query->orWhere('description','like','%'.request('key').'%');
      })->paginate();

      return $professionalField;
    }

    public function get($id){
        $professionalField=ProfessionalField::where('id',$id)->first();

        return $professionalField;
    }

    public function store($request){
      $professionalField=  ProfessionalField::create([
            'name'=>$request->name,
            'description'=>$request->description
        ]);
        return $professionalField;
    }

    public function update($professionalField, $data,)
    {
        $professionalField->name        = $data->name;
        $professionalField->description = $data->description;
        $professionalField->save();
        return $professionalField;
    }

    public function delete ($professionalField){
        $professionalField->delete();

        return true;
    }
}
