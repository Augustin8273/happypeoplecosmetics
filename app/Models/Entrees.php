<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrees extends Model
{
    use HasFactory;

    public function Produitname(){

        return $this->belongsTo(ProductArticle::class,'product_Article_id','id');
    }
}
