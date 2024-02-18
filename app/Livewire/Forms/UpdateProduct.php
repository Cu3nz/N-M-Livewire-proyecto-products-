<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateProduct extends Form
{
    // todo Definimos las variables

    public ?Product $producto = null;

    public string $nombre = "";

    public string $descripcion = "";

    public float $pvp = 0;

    public int $stock = 0;
    //? Disponible no hace falta definirlo
    //todo Inicializamos el array de tags a vacio, este array almacena los tags que tiene ya selecciona el producto
    public array $tags = [];

    public $imagen;


    //? Seteamos los campos 

    public function setProducto(Product $product)
    {

        //? El producto viene de la variable ->  public ?Product $producto = null;
        //? $product viene de la variable que se pasa por el metodo de la funcion

        $this->producto = $product;
        $this->nombre =  $product->nombre;
        $this->descripcion =  $product->descripcion;
        $this->pvp =  $product->pvp;
        $this->stock =  $product->stock;
        $this->tags =  $product->getTagsId(); //? Este metodo esta definido en el Modelo de Products


    }


    //todo Definimos validaciones 

    public function rules()
    {

        //? Devolvemos un array con las validaciones
        return [
            'nombre' => ['required', 'string', 'min:3', 'unique:products,nombre,' . $this -> producto -> id], //? Para que no de error de el nombre ya existe  a la hora de actualizar 
            'descripcion' => ['required', 'string', 'min:10'],
            'stock' => ['required', 'integer', 'min:0'],
            'pvp' => ['required', 'decimal:0,2', 'min:0', 'max:9999.99'],
            'imagen' => ['nullable', 'image', 'max:2048'],
            'tags' => ['required', 'array', 'min:2', 'exists:tags,id']
        ];
    }


    //todo Actualizamos el producto 

    public function editarProducto(){

        //todo Hacemos la comprobacion de la imagen 

        //? en $ruta esta la imagen actual del producto 

        $ruta = $this -> producto -> imagen;

        if ($this -> imagen){ //? Si se ha subido una imagen
            //* Compruebo que la iamgen actual del producto la que se definio en el create sea distinta a la default (noimage.png), si es distinta a la default la borro
            if (basename($ruta) != 'noimage.png'){
                Storage::delete($ruta); //? Borro la imagen
            }
            
            //? Machacho lo que habia en $ruta y almaceno la nueva imagen que esta guardada en la carpeta products con un nombre aletatorio.

            $ruta = $this -> imagen -> store('products');
    }

    //todo Ahora si que si editamos

    $this -> producto -> update([

        'nombre' => $this -> nombre,
        'descripcion' => $this -> descripcion,
        'stock' => $this -> stock,
        'pvp' => $this -> pvp,
        'imagen' => $ruta,
        'disponible' => ($this -> stock > 0) ? 'SI' : 'NO',
        'user_id'=>auth()->user()->id,
    ]);

    //? Actualizamos las etiquetas

    $this -> producto ->  tags() -> sync($this -> tags);
}


public function limpiarCampos(){
    $this -> reset(['nombre' , 'descripcion' , 'imagen' , 'pvp' , 'stock' , 'producto' ,'tags']);
}

}
