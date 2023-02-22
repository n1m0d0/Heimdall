<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    const Active = 1;
    const Inactive = 2;
    const Finalized = 3;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
