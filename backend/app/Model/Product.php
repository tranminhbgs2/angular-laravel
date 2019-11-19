<?php

namespace App\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
//    use Sluggable;
    protected $table = 'products';
    protected $fillable = [
        'name','detail','size','price','weight', 'img', 'slug', 'author', 'company', 'pushlisher', 'translator', 'content', 'status'
    ];
    public function reviews(){
        return $this->hasMany(Review::class);
    }
    public function categories(){
        return $this->belongsTo(Categories::class);
    }
//    public function sluggable()
//    {
//        return [
//            'slug' => [
//                'source' => 'name'
//            ]
//        ];
//    }
}
