<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    private $user;

    public function __construct()
    {
        $this->user = new User;
    }

    public function getQuizzes($user)
    {
        $quizzes =  $this->user
                         ->where('id', $user->id)
                         ->with([
                             'score' => function($quizzes) use($user) {
                                 $quizzes->where('user_id', $user->id)
                                         ->whereNull('score')
                                         ->whereNull('detail')
                                         ->with('quiz');
                             }
                         ])
                         ->first();


        $quizzes = $quizzes->score->transform(function ($item, $key) use ($quizzes) {
            return $item->quiz ?? null;
        });

        return $quizzes->filter(function ($item, $key) {
             return !is_null($item); 
        });
    }

    public function getById($user)
    {
        return $this->user
                    ->find($user);
    }

    public function getWithTrashById($user)
    {
        return $this->user
                    ->withTrashed()
                    ->find($user);
    }

    public function update($user, $attributes)
    {
        return $user->update($attributes);
    }

    public function buildUserList($request)
    {   
        $list = $this->user
                     ->withTrashed()
                     ->select('id', 'name', 'email', 'language' , 'api_token' , 'role_id', 'deleted_at')
                     ->whereHas('role.menus', function($list) {
                         $list->where('name',  $this->user->getTableName())
                             ->where('is_super_user', false);
                     });
        
        return $list;
    }

    public function getByColumn($column, $index)
    {
        return $this->user
                    ->where($column, $index)
                    ->firstOrFail();
    }

    public function softDel($user)
    {
        $user->trashed() ? $user->restore() : $user->delete();

        return $user->trashed();
    }

    public function forceUpdate($model, $attributes)
    {
        return $model->forceFill($attributes)->saveOrFail();
    }

    public function getTable()
    {
        return $this->user->getTableName();
    }

}
