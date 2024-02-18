<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ContactoMaillabe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    //

    public function pintarFormulario(){

        return view('contactoForm.formulario');
        
    }



    public function procesarFormulario( Request $request){

        //todo Se realiza las validaciones de los inputs del formulario y luego se hace un try catch

        $request -> validate([
            'nombre' => ['required' , 'string' , 'min:3'],
            'email' => ['required' ,'email'],
            'contenido' => ['required' , 'string' , 'min:10']
        ]);


        try {
            Mail::to('sergio@example') -> send( new ContactoMaillabe(ucfirst($request -> nombre) , $request -> email , ucfirst($request -> contenido)));
            return redirect() -> route('inicio') -> with('mensaje' , 'Se ha enviado el mensaje, gracias por contactar con nosotros');
        } catch (\Exception $ex) {
            dd("Error al enviar el correo: " . $ex -> getMessage());
            return redirect() -> route('inicio') -> with('mensaje' , 'No se ha podido enviar el mensaje, intentalo de nuevo mas tarde');
        }



    }

}
