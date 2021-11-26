<?php

namespace App\Repositories;

use App\Quiz;

class QuizRepository
{
    private $quiz;

    public function __construct()
    {
        $this->quiz = new Quiz;
    }

}
