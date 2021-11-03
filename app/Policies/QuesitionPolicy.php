<?php

namespace App\Policies;

use App\User;
use App\Quesition;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuesitionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = Quesition::getTableName();
    }

    public function before(User $user)
    {
        $permission = $user->role
                           ->menus
                           ->where('name', $this->model)
                           ->first();
        
        if($permission) {
            if ($permission->is_super_user) {
                return true;
            }
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
    public function create(User $user, Quesition $model = null)
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
}
