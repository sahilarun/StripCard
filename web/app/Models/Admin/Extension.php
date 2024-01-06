<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Extension extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    protected $casts = [
        'shortcode' => 'object',
    ];
}
