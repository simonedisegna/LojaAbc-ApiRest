<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['sales_id', 'total_amount'];

    public function saleProducts()
    {
        return $this->hasMany(SaleProduct::class);
    }

}
