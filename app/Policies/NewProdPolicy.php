<?php

namespace App\Policies;

use App\User;
use App\Prod;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewProdPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the prod.
     *
     * @param  \App\User  $user
     * @param  \App\Prod  $prod
     * @return mixed
     */
    public function view(User $user, Prod $prod)
    {
        exit('XXXX');
        return true;
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
