<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'name'=>$this->name,
            'age'=>$this->age,
            'email'=>$this->email,
            'gender'=>$this->gender,
            'phone'=>$this->phone,
            'address'=>$this->address,
            'class'=>$this->class,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
