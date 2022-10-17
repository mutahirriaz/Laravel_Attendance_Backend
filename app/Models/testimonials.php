<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class testimonials extends Model
{
    use HasFactory;

    protected $table = 'testimonials';

    protected $fillable = [
        'review',
        'username',
    ];
}
