<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
         //todo Tenemos que comprobar que el id del usuario que ha iniciado sesion = que el user_id del producto el cual se quiere actualar, si es igual es porque ese producto es de ese usuario
        /*
         * Verifica si el producto pertenece al usuario autenticado antes de permitir una actualización.
         * Compara el ID del usuario autenticado con el 'user_id' del producto para asegurar que solo
         * el propietario del producto pueda actualizarlo. Retorna true si los IDs coinciden, indicando
         * que la operación de actualización puede proceder, de lo contrario, false
         */

        return $user->id === $product->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        //todo Hace lo mismo antes de borrar el producto comprueba que el id del usuario logueado sea = que el user_id del producto si son iguales, es porque ese producto lo ha creado el usuario logueado

        return $user->id === $product->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product)
    {
        //
    }
}
