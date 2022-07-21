<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       // return parent::toArray($request);
       return [
        'name' => $this->name,
        'description' => $this->detail,
        'price' => $this->price,
        'stock' => $this->stock== 0 ? 'Out of Stock' : $this->stock,
        'discount' => $this->discount,
        'totalPrice' =>round((1 - ($this->discount/100)) * $this->price),
        'created_at' => (string) $this->created_at,
        'updated_at' => (string) $this->updated_at,
        'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count()) :'no rating',
        'href'=> [
            'reviews' => route('reviews.index',$this->id)
        ]
        
      ];
    }
}
