<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "ma_customer" => $this->ma_customer,
            "email" => $this->email,
            "avatar" => $this->avatar,
            "phone" => $this->phone,
            "address" => $this->address,
            "gender" => $this->gender,
            "story" => $this->story,
            "status" => $this->status
        ];
    }
}
