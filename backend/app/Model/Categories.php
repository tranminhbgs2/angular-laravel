<?php

namespace App\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use Sluggable;
    protected $table = 'categories';
    protected $fillable = [
        'title','slug','status'
    ];
    public function product()
    {
        return $this->hasMany(Product::class);
    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
