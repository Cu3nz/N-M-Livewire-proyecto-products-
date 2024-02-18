<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PrincipalProducts extends Component
{

    use WithPagination;
    //todo Para actualizar estado de disponibilidad
    public string $estado = "";

    //todo para el buscador
    public string $buscar = "";

    //todo Para ordenar

    public string $orden = 'desc';

    public string $campo = 'id';

    #[On('ejecutarConsulta_index')] //? evento que esta definido en CrearProduct.php dentro del metodo store

    public function render()
    {
        $producto = Product::where('user_id' , auth() ->user() ->id)//todo En esta consulta, estamos obteniendo los productos que ha creado el usuario que ha iniciado sesión. auth() se refiere al sistema de autenticación de Laravel, user() devuelve el modelo del usuario autenticado y id devuelve el ID del usuario. Luego utilizamos where para filtrar los productos por el ID del usuario y paginate(5) para obtener los resultados paginados, mostrando 5 productos por página.

        //? Para que solo busque productos que ha subido ese usuario solamente.

        ->where(function($q){
            $q -> where('nombre' , 'like' , "$this->buscar%")
            ->orWhere( 'stock' , 'like' , "$this->buscar%");
        })
        ->orderBy($this -> campo , $this -> orden)
        ->paginate(5);
        return view('livewire.principal-products' , compact('producto'));
    }



    //todo El método `ordenar` se utiliza para cambiar el orden de un campo en la tabla de productos. Recibe el nombre del campo como parámetro. Primero, verifica si el orden actual es ascendente (`asc`). Si es así, cambia el orden a descendente (`desc`); de lo contrario, lo cambia a ascendente. Luego, actualiza el valor del campo de ordenamiento (`$campo`) con el nombre del campo recibido como parámetro.

    public function ordenar($campo){

        $this -> orden = ($this -> orden == 'asc') ? 'desc' : 'asc';
 
         $this -> campo = $campo;
 
     }


    public function actualizarDisponibleClick( Product $producto){
        
        $estado = ($producto -> disponible == 'NO') ? 'SI' : 'NO';

        $producto -> update([
            'disponible' => $estado
        ]);
    }

    public function subirStock(Product $producto){

        //? Cogemos el stock actual que tiene el producto

        $stockProducto = $producto -> stock;

        $stockProducto++; //? Lo incrementamos

        //? lo actualiamos, tanto el stock como el estado de disponible, en cuanto sea > que 0 pondra que si
        $producto -> update([
            'stock' => $stockProducto,
            'disponible' => ($stockProducto > 0) ? 'SI' : 'NO'
        ]);

    }


    public function bajarStock(Product $producto){
        
        if ($producto  -> stock > 0){ //? Si el stock del producto es mayor a 0

            $stockProducto = $producto -> stock; //? Cogemos el valor actual de stock de ese producto
    
            $stockProducto --; //? Le bajamos de 1 en 1

            $producto -> update([
                'stock' => $stockProducto,
                'disponible' => ($stockProducto > 0) ? 'SI' : 'NO'
            ]);
        }

    }

    //todo Para el buscador

    public function updatingBuscar(){
        $this -> resetPage();
    }


    //* PARA EL DELETE 

    public function pedirConfirmacion( Product $product){

        
        $this -> authorize('delete' , $product); 

        $this -> dispatch('confirmarDelete' , $product -> id); //? Defino un evento llamado ConfirmarDelete el cual lo va a escuchar la clase app.blade.php pasandole el id de ese producto.

    }

    #[On('deleteConfirmado')] //? Evento que proviene del script que esta en app.blade.php

    public function delete(Product $product){

        //todo Primero tenemos que comprobar que la imagen sea distinta a noimage.png (default)

        if (basename($product -> imagen) != 'noimage.png'){
            Storage::delete($product -> imagen);
        }

        //? Borramos el producto
        $product -> delete();

        //? Enviamos un mensaje de alerta de que se ha borrado correctamente

        $this -> dispatch('mensaje' , 'Producto eliminado correctamente');

    }


}
