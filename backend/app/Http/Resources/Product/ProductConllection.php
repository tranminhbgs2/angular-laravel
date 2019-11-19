<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\Resource;
use phpDocumentor\Reflection\File;

class ProductConllection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return  [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->detail,
            'price' => $this->price,
//            'stock' => $this->stock == 0 ? 'Out of Stock' : $this->stock,
            'weight' =>$this->weight,
            'size' => $this->size,
            'img' => $this->img,
            'contents' => $this->content,
            'author' => $this->author,
            'company' => $this->company,
            'pushlisher' => $this->pushlisher,
            'translator' => $this->translator,
            'status' => $this->status,
            'slug' => $this->slug,
             'categories_id' => $this->categories_id,
            'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count(),2) : 'No rating yet',
            'href'=>[
                'link'=> route('products.show', $this->slug),
            ],
        ];
//        return parent::toArray($request);
    }
}
