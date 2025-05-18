<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $table = "hotels";
    protected $fillable = [
        "name",
        "type",
        "street",
        "zip_code",
        "link",
        "city",
        "country",
        "phone",
        "image1",
        "image2",
        "trip_id",
    ];
}
