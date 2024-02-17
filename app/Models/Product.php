<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['nombre' , 'descripcion' , 'pvp' , 'imagen' , 'stock' , 'user_id' , 'disponible'];


    //todo Un producto, cuantas etiquetas puede tener? Muchas

    public function tags(){
        return $this -> belongsToMany(Tag::class); //! Cuando es una relacion N:M se pone belongsToMany
    }


    //todo Un producto cuantos usuarios puede tener? Solo 1.

    public function user(){
        return $this -> belongsTo(User::class);
    }



    public function nombre(){
        return Attribute::make(
            set: fn($v) => ucfirst($v)
        );
    }
    public function descripcion(){
        return Attribute::make(
            set: fn($v) => ucfirst($v)
        );
    }

}
