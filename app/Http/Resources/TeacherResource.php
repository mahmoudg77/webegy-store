<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Tymon\JWTAuth\Providers\Auth\Illuminate;
use Illuminate\Database\Eloquent\Collection;

class TeacherResource extends JsonResource
{
   



    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            
                'User Name'                 =>$this->ms_username,
                'First  Name'               =>$this->first_name,
                'Last Name'                 =>$this->last_name,
                'Display name'              =>$this->first_name .' '.$this->last_name,
                'Job title'                 =>$this->User->AccountLevel->role,
                'Department'                =>$this->Department?$this->Department->name:'',
                'Grade teacher works in'    =>$this->Educational?$this->Educational->name:'',
                'Speciality'                =>$this->Speciality?$this->Speciality->name:'',
                'Whats App phone number'    =>$this->mobile_phone,
                'Personal email'            =>$this->User->email,
                'Address'                   =>$this->address,
                'City'                      =>$this->area,
                'Province'                  =>$this->City?$this->City->name:'',
                'Another phone number'      =>$this->father_mobile,
                'Country'                   =>$this->Country?$this->Country->name:'',
        ];
        return parent::toArray($request);
    }
}
