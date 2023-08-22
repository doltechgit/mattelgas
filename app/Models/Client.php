<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'phone',
        'email',
        'address',
        'category_id',
        'dob',
        'trans',
        'created_at',
        'updated_at'

    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'client_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function coupon()
    {
        return $this->hasOne(Coupon::class, 'client_id');
    }


}
