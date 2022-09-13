<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeRequestt extends Model
{
    use HasFactory;

    protected $table = 'changerequest';

    protected $fillable = [
        'userId',
        'deviceId',
    ];

}
