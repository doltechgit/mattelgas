<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'product_id'
    ];

    public function client (){
        return $this->hasMany(Client::class, 'client_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
