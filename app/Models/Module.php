<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'title', 'content'];

    // Relasi ke Category (modul milik satu kategori)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
