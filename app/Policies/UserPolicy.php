<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    private $model;

    public function __construct(User $user)
    {
        $this->model = $user->getTable();
    }
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */

    public function before(User $user)
    {
        $permission = $user->role
                           ->menus
                           ->where('name', $this->model)
                           ->first();
        
        if ($permission->is_super_user) {
            return true;
        }
    }

    public function superuser(User $user)
    {
        $permission = $user->role
                           ->menus
                           ->where('name', $this->model)
                           ->first();

        return $permission AND $permission->is_super_user;
    }

    public function read(User $user)
    {

        $permission = $user->role
                           ->menus
                           ->where('name', $this->model)
                           ->first();

        return $permission AND $permission->read;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $permission = $user->role
                           ->menus
                           ->where('name', $this->model)
                           ->first();

        return $permission AND $permission->create;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    /**
     *first model is user model 
     *second model is action model
     */
    public function edit(User $user, User $model = null)
    {
        $permission = $user->role
                           ->menus
                           ->where('name', $this->model)
                           ->first();

        if($permission AND $permission->edit) {
            if(!$model) {
                return true;
            }

            return $user->id === $model->id;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model = null)
    {
        $permission = $user->role
                           ->menus
                           ->where('name', $this->model)
                           ->first();
   
        if($permission AND $permission->delete) {
            if(!$model) {
                return true;
            }
            return $user->id === $model->id;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model )
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
