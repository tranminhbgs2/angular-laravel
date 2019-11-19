<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Categories;
use App\Model\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {

    $title = $faker->words(10);
//    $slug = str_slug ($title, '-');
    return [
        'name'=> $title,
//        'slug' => $slug,
        'detail'=>$faker->paragraph,
        'price'=>$faker->numberBetween(100000,1000000),
        'size'=>$faker->numberBetween(15,30).'x'.$faker->numberBetween(15,40).' cm',
        'weight'=>$faker->numberBetween(200,700).'g',
        'img' =>url('/') . $faker->image($dir = 'public/img/',150, 200),
        'content'=>$faker->paragraph,
        'author'=>$faker->name,
        'company'=>$faker->company,
        'pushlisher' => $faker->company,
        'translator'=>$faker->name,
        'status'=> '1',
        'categories_id' => function(){
            return Categories::all('id')->random();
        }

//            'stock' => $this->stock == 0 ? 'Out of Stock' : $this->stock,
//            'weight' =>$this->weight,
//            'size' => $this->size,
//            'img' => $this->img,
//            'contents' => $this->content,
//            'author' => $this->author,
//            'company' => $this->company,
//            'pushlisher' => $this->pushlisher,
//            'translator' => $this->translator,
//            'status' => $this->status,
//            'slug' => $this->slug,
//             'categories_id' => $this->categories_id,
//            'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count(),2) : 'No rating yet',
//            'href'=>[
//        'link'=> route('products.show', $this->id),
//    ],
    ];
});
