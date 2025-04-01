<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $table = 'trips'; // <-- Zorg ervoor dat dit er staat!

    protected $fillable = [
        'name',
        'contact_email',
    ];
}
