<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use JetBrains\PhpStorm\Pure;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user)
    {
        //check if user is admin
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Product $foodItem
     * @return Response|bool
     */
    public function view(User $user, Product $foodItem)
    {
        //check if user is admin
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    #[Pure] public function create(User $user)
    {
        //check if user is admin
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Product $foodItem
     * @return Response|bool
     */
    public function update(User $user, Product $foodItem)
    {
        //check if user is admin
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Product $foodItem
     * @return Response|bool
     */
    public function delete(User $user, Product $foodItem)
    {
        //check if user is admin
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Product $foodItem
     * @return Response|bool
     */
    public function restore(User $user, Product $foodItem)
    {
        ///check if user is admin
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Product $foodItem
     * @return Response|bool
     */
    public function forceDelete(User $user, Product $foodItem)
    {
        ///check if user is admin
        return $user->isAdmin();
    }
}
