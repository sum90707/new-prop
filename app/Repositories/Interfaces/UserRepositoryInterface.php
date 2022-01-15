<?php
namespace  App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getTable();

    public function getById($id);

    public function getWithTrashById($user);

    public function getByColumn($column, $value);

    public function update($user, $attributes);

    public function forceUpdate($model, $attributes);

    //parameter $user is a user object
    public function softDel($user);

    public function buildUserList($request);

    public function getQuizzes($user);
}
