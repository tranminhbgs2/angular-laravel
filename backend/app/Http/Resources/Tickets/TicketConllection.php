<?php

namespace App\Http\Resources\Tickets;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketConllection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = User::where('id', $this->customer_id)->first();
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name_user' => $user->name,
            'date_active' => Carbon::parse($this->date_active)->format('d-m-Y'),
            'date_back' => Carbon::parse($this->date_back)->format('d-m-Y'),
            'status' => $this->status
        ];
    }
}
