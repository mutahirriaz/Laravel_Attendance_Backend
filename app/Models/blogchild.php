<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blogchild extends Model
{
    use HasFactory;

    protected $table = 'blogchild';

    protected $fillable = [
        'blogId',
        'heading',
        'image',
        'peragraph',
    ];


}
