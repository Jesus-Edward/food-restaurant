<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contact extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'phone_one',
        'phone_two',
        'email_one',
        'email_two',
        'location',
        'map_link'
    ];
}
