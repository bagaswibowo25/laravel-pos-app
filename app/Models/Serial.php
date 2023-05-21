<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serial extends Model
{
    use HasFactory;

    protected $table = 'serial';
    protected $primaryKey = 'id_serial';
    protected $guarded = [];

    public function product()
    {
        return $this->hasOne(Product::class, 'id_product', 'id_product');
    }
}
