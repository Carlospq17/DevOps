<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'brand', 'price', 'net_weight', 'category'];
    
    public $timestamps = false;

    /**
     * The Sales that belong to the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Sales(): BelongsToMany
    {
        return $this->belongsToMany(Sale::class, 'sales_products', 'sales_id', 'products_id');
    }
}
