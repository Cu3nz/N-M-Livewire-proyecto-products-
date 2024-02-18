<?php

use App\Http\Controllers\ContactoController;
use App\Http\Controllers\Socialite\GithubController;
use App\Livewire\PrincipalProducts;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    //todo Vamos a ver todos los productos que esten disponibles, tengo que pasar el with para no tener problema de la carga ansiosa
    $productos = Product::with('user') -> where('disponible' , 'SI') -> paginate(5);
    return view('welcome' , compact('productos'));
}) -> name('inicio');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('products' , PrincipalProducts::class) -> name('index.products');
});



//todo Login con github 

Route::get('/auth/github/redirect' , [GithubController::class , 'redirect']) -> name('github.redirect');
Route::get('/auth/github/callback' , [GithubController::class , 'callback']) -> name('github.callback');

//todo Para el correo

Route::get('contacto' , [ContactoController::class , 'pintarFormulario']) -> name('email.pintar');
Route::post('contacto' , [ContactoController::class , 'procesarFormulario']) -> name('email.enviar');