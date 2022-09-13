<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class Attendance extends Model
{

     //
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    
    use HasApiTokens, HasFactory;

    protected $table = 'attendance';

    protected $fillable = [
        'userId',
        'checkIn',
        'checkOut'
    ];



}
