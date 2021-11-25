<?php

namespace App\Policies;

use App\User;
use App\Paper;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaperPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = Paper::getTableName();
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

    public function create(User $user)
    {
        
        $permission = $user->role
                           ->menus
                           ->where('name', $this->model)
                           ->first();

        return $permission AND $permission->create;
    }

    public function delete(User $user, Paper $model = null)
    {
        
        $permission = $user->role
                           ->menus
                           ->where('name', $this->model)
                           ->first();
                           
        if($permission AND $permission->delete) {
            if(!$model) {
                return true;
            }
            return $user->id == $model->create_by;
        }
        return false;
    }

    public function edit(User $user, Paper $model = null)
    {
        
        $permission = $user->role
                           ->menus
                           ->where('name', $this->model)
                           ->first();
                           
        if($permission AND $permission->edit) {
            if(!$model) {
                return true;
            }
            return $user->id == $model->create_by;
        }
        return false;
    }

    public function test(User $user, Paper $model = null)
    {
        return true;
    }
}
