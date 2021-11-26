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
                    
        return $quizzes->score;
    }

}
