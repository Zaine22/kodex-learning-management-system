<?php

namespace App\Modules\ProfessionalField\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
 */

class ProfessionalFieldResource extends JsonResource{
    public function toArray($request){
        return [
            "id"=>$this->id,
        ];
    }
}
