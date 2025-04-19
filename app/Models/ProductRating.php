<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductRating extends Model
{
    use HasFactory;

    function users() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    function products() : BelongsTo {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
