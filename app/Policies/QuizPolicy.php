<?php

namespace App\Policies;

use App\User;
use App\Quiz;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuizPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = Quiz::getTableName();
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

    public function edit(User $user, Quiz $model = null)
    {
        
        $permission = $user->role
                           ->menus
                           ->where('name', $this->model)
                           ->first();

        if($permission AND $permission->edit) {
            if( is_null($model) ) {
                return true;
            }

            return $user->id === $model->id;
        }
        return false;
    }

    public function delete(User $user, Quiz $model = null)
    {
        
        $permission = $user->role
                           ->menus
                           ->where('name', $this->model)
                           ->first();

        if($permission AND $permission->delete) {
            if( is_null($model) ) {
                return true;
            }
            return $user->id === $model->create_by;
        }
        return false;
    }

    public function take(User $user, Quiz $quiz)
    {
        $permission = $quiz->users
                           ->where('id', $user->id)
                           ->first();

        return $permission;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    
}
