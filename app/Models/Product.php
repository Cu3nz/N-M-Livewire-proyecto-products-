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

    //? Meoto que devuelve todos los TagsIds que tiene un producto en un array 

    public function getTagsId(){
        // Crea un array vacío llamado $tags para almacenar los IDs de las etiquetas.
        $tags = [];
    
        // Itera sobre la propiedad $this->tags, que se espera sea un array de objetos (cada uno representa una etiqueta).
        foreach ($this->tags as $tag) {
            //? Accede a la propiedad id del objeto etiqueta actual ($tag) y la añade al array $tags.
            //? Esto significa que para cada etiqueta en $this->tags, se está extrayendo su ID y almacenándolo en el array $tags.
            $tags[] = $tag->id; //todo Cojo el id del tag y lo almaceno en el array
        }
        //* Devuelve el array $tags, que ahora contiene los IDs de todas las etiquetas asociadas con el objeto actual.
        return $tags;
    }

}
