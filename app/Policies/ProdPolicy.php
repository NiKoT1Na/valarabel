<?php
namespace App\Policies;

use App\User;
use App\Prod;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProdPolicy
{
 


    /**
     * Determine whether the user can view the prod.
     *
     * @param  \App\User  $user
     * @param  \App\Prod  $prod
     * @return mixed
     */

    public function before($user, $ability) 
    {
        exit('XXX');
        if ($ability === 'index' || $ability === 'show' || $ability === 'view' ) {
            return true;
        }
        if ($user->roles === 'admin') {
            return true;
        }
        return false;
    }


    public function view(User $user, Prod $prod)
    {
        return false;
    }

    /**
     * Determine whether the user can create prods.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can update the prod.
     *
     * @param  \App\User  $user
     * @param  \App\Prod  $prod
     * @return mixed
     */
    public function update(User $user, Prod $prod)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can delete the prod.
     *
     * @param  \App\User  $user
     * @param  \App\Prod  $prod
     * @return mixed
     */
    public function delete(User $user, Prod $prod)
    {
        //
    }
}
