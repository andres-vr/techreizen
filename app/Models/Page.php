<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactories;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'content', 'accessibility_level'];
    protected $table = 'pages';
}
