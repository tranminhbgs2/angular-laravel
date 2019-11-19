<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\Resource;

class CategoriesResource extends Resource
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
          'title' => $this->title,
          'slug' => $this->slug,
          'status' => $this->status
        ];
    }
}
