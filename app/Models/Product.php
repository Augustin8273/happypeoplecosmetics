<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function Produitname(){

        return $this->belongsTo(ProductArticle::class,'product_Article_id','id');
    }

    public function Category(){

        return $this->belongsTo(Category::class,'category_id','id');
    }
}
