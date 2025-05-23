<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppDownload extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'background',
        'title',
        'short_description',
        'play_store_link',
        'app_store_link'
    ];
}
