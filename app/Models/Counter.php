<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;

    protected $fillable = [
                'background',
                'counter_title_one',
                'counter_count_one',
                'counter_icon_one',

                'counter_title_two',
                'counter_count_two',
                'counter_icon_two',

                'counter_title_three',
                'counter_count_three',
                'counter_icon_three',

                'counter_title_four',
                'counter_count_four',
                'counter_icon_four',
    ];
}
