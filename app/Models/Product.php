<?php

namespace App\Models;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','detail','stock','price','discount','user_id'
     ];
  
     public function reviews()
     {
  
      return $this->hasMany(Review::class);
      
     }

     public function user()
   {

    return $this->belongsTo(User::class);
    
   }
}
