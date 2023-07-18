<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'email',
        'contact',
        'admin'
    ];

    public function users(){
        return $this->hasMany(User::class, 'store_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'store_id');
    }

    public function transactions()
    {
        $this->hasMany(Transaction::class, 'store_id');
    }

}
