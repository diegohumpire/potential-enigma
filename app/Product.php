<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name', 
        'price', 
        'supplier_id', 
        'is_active'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
