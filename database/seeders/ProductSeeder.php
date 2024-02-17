<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $producto = Product::factory(30) -> create(); //* Almacenamos en producto, el producto creado, para asi poder añadirle las etiquetas.

        foreach ($producto as $item) {
            $item -> tags() -> attach(self::devolverTags());
        }
    }


        //todo Deberia de estar en el modelo
        private static function devolverTags() : array{
            $tags = [];

            $idsTablaTag = Tag::pluck('id') -> toArray(); //* Saca todos los id de la tabla tag esto devuelve el siguiente array: 
            
            //todo idsTablaTag = [0,1,2,3,4,5,6,7,8,9] 10 en total

            //? A array rand se le pasa dos parametros: 
            //* El array que contienen todos los ids de cada uno de los tags de la tabla
            //* El numero de indices del array que tiene que coger, en este caso estamso definiendo un numero aleatorio entre 2 y el numero de ids que tenga la tabla TAG vamos a poner un ejemplo de 10, por lo tanto el rango sera 2 y 10

            //? Por lo tanto si el random_int saca un 5, array rand cogera 5 indices aleatorios del array $idsTablaTag : 2, 4, 6, 3 y 5

            $indicesRandom = array_rand($idsTablaTag , random_int(2 , count($idsTablaTag)));

            foreach( $indicesRandom as $indice){
                $tags[] = $idsTablaTag[$indice];
                //? Aqui lo que estamos haciendo es lo siguiente: 
                //* Si $indicesRandom devuelve los siguientes indices : 2, 4, 6, 3 y 5
                //todo Sabiendo el array siguiente $idsTablaTag  =  [0,1,2,3,4,5,6,7,8,9]
                //* $tags[] almacenara el id $tags[1,3,5,2,4] basicamente es contar por el 0 que es el 1.

                //? 1 porque? porque ha codigo el indice 2 del array de $idsTablaTag 
            }
            return $tags;
        }

    }

