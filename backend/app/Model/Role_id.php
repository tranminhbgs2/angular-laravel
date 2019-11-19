<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role_id extends Model
{
    protected $table = 'role_ids';
    protected $fillable = ['role_id', 'user_id'];
    public $timestamps = true;
}
