<?php

namespace App\Http\Resources\Tickets;

use App\Model\Product;
use App\Model\Tickets;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Ticket_detailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $ticket = Tickets::where('id', $this->tickets_id)->first();
        $book = Product::where('id', $this->product_id)->first();
        $user = User::where('id', $ticket->customer_id)->first();
        return [
            'ticket_id' => $this->tickets_id,
            'code' => $ticket->code,
            'name_book' => $book->name,
            'name_user' => $user->name,
            'date_active' => $ticket->date_active,
            'date_back' => $ticket->date_back,
            'product_status' => $this->product_status,
            'status' => $this->status
        ];
    }
}
