<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class contactform extends Model
{
    use HasFactory;

    protected $table = 'contactform';

    protected $casts = [
        'technologies' => 'array',
    ];

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'phone',
        'companyName',
        'helpMsg',
        'estimateBudget',
        'technologies',
    ];

    protected function data(): Attribute
   {
       return Attribute::make(
           get: fn ($value) => json_decode($value, true),
           set: fn ($value) => json_encode($value),
       );
   } 

}
