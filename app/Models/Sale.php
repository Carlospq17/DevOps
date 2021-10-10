<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $hidden = [
        'client_id'
    ];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    /**
     * The Products that belong to the Sale
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'sales_products', 'sales_id', 'products_id');
    }
}
