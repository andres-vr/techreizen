<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $table = 'majors'; // <-- Zorg ervoor dat dit er staat!

    protected $fillable = [
        'name',
        'education_id',
    ];
}
