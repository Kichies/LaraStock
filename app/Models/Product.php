<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    // TENTUKAN KOLOM YANG BOLEH DIISI DARI FORM (MASS ASSIGNMENT)
    protected $fillable = [
        'name',
        'sku',
        'stock',
        'price',
        'description',
    ];
}