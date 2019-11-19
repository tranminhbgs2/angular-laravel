<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ticket_detail extends Model
{
    protected $table = 'ticket_details';
    public $primaryKey = 'tickets_id';
    protected $fillable = ['tickets_id', 'product_id', 'product_status', 'status'];
    public $timestamps = true;

    public function ticket(){
        return $this->belongsTo(Tickets::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
