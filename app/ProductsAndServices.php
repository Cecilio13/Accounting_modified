<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsAndServices extends Model
{
    protected $primaryKey = 'product_id';
    protected $table = 'products_and_services';
    protected $fillable = array(
        'product_id',
        'product_name',
        'product_sku',
        'product_type',
        'product_sales_description',
        'product_sales_price',
        'product_cost',
        'product_qty',
        'product_reorder_point'
    );

    public $timestamps = true;
}