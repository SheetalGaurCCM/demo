<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table='books';
    protected $primaryKey='id';
    protected $fillable = ['image','title','author_name','description','price','user_id'];
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function user(){
        return $this->belongsToMany(User::class);
    }

}