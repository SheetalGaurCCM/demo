<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table='books';
    protected $primaryKey='id';
    protected $fillable = ['title','author_name','description','price'];
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

}