<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogComment extends Model
{
    use HasFactory;

    function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    function blog() : BelongsTo {
        return $this->belongsTo(Blog::class);
    }
}
