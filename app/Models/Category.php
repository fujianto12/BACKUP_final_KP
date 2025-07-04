<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['division', 'subDivision', 'slug'];


    public function categoryQuestions()
    {
        return $this->hasMany(Question::class);
    }
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function classes()
    {
        return $this->belongsTo(ClassModel::class);
    }
}
