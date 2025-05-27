<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PageModel extends Model
{
    use HasFactory;

    protected $table = 'pages'; // Table name
    protected $primaryKey = 'id'; // Primary key

    protected $fillable = ['name', 'content', 'login','guideOrTraveller','routename','type'];

    public $timestamps = true; // Ensures created_at & updated_at are used


}
