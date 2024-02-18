<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Tag;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use PhpParser\Node\Expr\FuncCall;

class CrearProduct extends Component
{

    public bool $abrirModalCreate = false;
   
    //todo Para la iamgen
    
    use WithFileUploads; //* Super importante para que cargue la imagen de la carpeta temporal
    
    #[Validate(['nullable' , 'image' , 'max:2048'])]
    public $imagen;
    //todo FIN Para la iamgen
    
   #[Validate(['required' , 'string' , 'min:3' , 'unique:products,nombre'])] 
    public string $nombre = "";

    #[Validate(['required' , 'string' , 'min:10'])]
    public string $descripcion = "";

    #[Validate(['required' , 'integer' , 'min:0'])]
    public int $stock;
    #[Validate(['required' , 'decimal:0,2' , 'min:0' , 'max:9999.99'])]
    public float $pvp;

    #[Validate(['required' , 'array' , 'min:2' , 'exists:tags,id'])]
    public array $tags = []; //? La definimso a vacia
    

    public function render()
    {
        //* Me traigo el id, nombre y color de todos los tags, ordenados ascedentemente por el nombre

        $misTags = Tag::select('id' , 'nombre' , 'color') -> orderBy('nombre') -> get();
        return view('livewire.crear-product' , compact('misTags'));
    }



    public function store(){
        $this -> validate(); //* Ejecutamos las validaciones

        //? Una vez pasadas las validaciones, creamos el objeto

        //todo Almacenamos en la variable $productoCreado, el producto que se acaba de crear, pero lo almacenamos para asignarle las etiquetas que se ha seleecionado para ese producto

       $productoCreado = Product::create([

            'nombre' => $this -> nombre,
            'descripcion' => $this -> descripcion,
            'stock' => $this -> stock,
            'pvp' => $this -> pvp,
            //? Si se ha subido una imagen, almaceno esa imagen en products con un nombre aleatorio gracias al metodo store y si no ha subido nada, asignamos la imagen noimagen.png
            'imagen' => ($this -> imagen) ? $this -> imagen -> store('products') : 'noimage.png',
            'disponible' => ($this -> stock > 0) ? 'SI' : 'NO',
            'user_id' => auth() -> user() -> id //? Defino el id del usuario autentificado
        ]);

        //todo Asignamos a $productoCreado los tags que se han seleccionado en el formulario

        $productoCreado -> tags() -> attach($this -> tags);

        //? Ahora vamos a definir un evento que solo va a poder escuchar la clase PrincipalProducts, este evento se va a encargar que ejecutar de nuevo la consulta que esta dentro del metodo render y asi mostrar el nuevo producto creado.

        $this -> dispatch('ejecutarConsulta_index') -> to(PrincipalProducts::class); //? El nombre del evento es 'ejecutarConsulta_index' y lo va a escuchar la clase PrincipalProducts.

        //todo Ahora mandamos un evento que lo va a escuchar app, el tipico mensaje de que se ha creado el producto

        $this -> dispatch('mensaje' , 'Producto creado Correctamente');

        $this -> salirModalCreate();

    }

    

    public function salirModalCreate(){
        $this -> reset(['nombre' , 'descripcion' , 'stock' , 'pvp' , 'imagen' , 'tags', 'abrirModalCreate']);
    }


}
