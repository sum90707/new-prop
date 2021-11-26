<?php

namespace App\Repositories;

use App\UserQuiz;

class UserQuizRepository
{
    private $userQuiz;

    public function __construct()
    {
        $this->userQuiz = new UserQuiz;
    }

    public function getQuiz($user, $quizId)
    {
        $quiz = $this->userQuiz
                     ->where('user_id', $user->id)
                     ->where('quiz_id', $quizId)
                     ->whereNull('detail')
                     ->first();
                    
        return $quiz;
    }

}
