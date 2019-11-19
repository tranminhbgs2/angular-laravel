<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\Resource;

class ProductResource extends Resource
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
            'categories_id' => $this->categories_id,
//            'totalPrice' => round(( 1 - ($this->discount/100)) * $this->price,2),
//            'totalPrice' => $this->price,
            'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count(),2) : 'No rating yet',
            'href' => [
                'reviews' => route('reviews.index',$this->id)
            ]
        ];
    }
}
