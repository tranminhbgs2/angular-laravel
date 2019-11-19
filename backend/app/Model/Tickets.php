<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    protected  $table = 'tickets';
    protected $fillable = ['code', 'customer_id', 'date_active', 'date_back', 'status'];
    public $timestamps = true;
    public function ticket_detail()
    {
        return $this->hasMany(Ticket_detail::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
