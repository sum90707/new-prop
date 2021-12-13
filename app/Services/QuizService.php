<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\QuizRepository;
use App\Repositories\PaperRepository;
use App\Repositories\QuesitionRepository;
use App\Repositories\UserQuizRepository;

class QuizService
{
    private $userRepo;
    private $quizRepo;
    private $paperRepo;
    private $qeusitionRepo;
    private $userQuizRepo;

    public function __construct() 
    {
        $this->userRepo = new UserRepository;
        $this->quizRepo = new QuizRepository;
        $this->paperRepo = new PaperRepository;
        $this->qeusitionRepo = new QuesitionRepository;
        $this->userQuizRepo = new UserQuizRepository;
    }

    public function grade($answer)
    {
        $correct = self::getCorrect(array_keys($answer));
        list($right, $wrong) = self::checkCorrect($answer, $correct);
        $perecnt = (count($right) / count($correct)) * 100;
        
        return array(
            'origin' => $answer,
            'right' => $right,
            'wrong' => $wrong,
            'percent' => round($perecnt)
        );
    }

    public function getQuizzes($user)
    {
        if($user->can('superuser', 'App\Quiz')) {
            $quizzes = $this->quizRepo->getSPQuizzes($user);
        } else {
            $quizzes = $this->userRepo->getQuizzes($user);
        }

        return $quizzes;
    }

    public function getQuiz($user, $quizId)
    {
        if($user->can('superuser', 'App\Quiz')) {
            $quiz = self::getOrCreateQuizModel(...func_get_args());
        } else {
            $quiz = self::getQuizModel(...func_get_args());
        }

        return $quiz;
    }

    public function getQuizDataTable($user)
    {
        if($user->can('superuser', 'App\Quiz')) {
            $quizzes = $this->quizRepo->list();
        } else {
            $ids = self::getQuizId($user);
            $quizzes = $this->quizRepo->listIn($ids);
        }

        return $quizzes;
    }

    private function getQuizModel($user, $quizId)
    {
        return $this->userQuizRepo->getQuizzes(...func_get_args());
    }

    public function createQuize($user, $quizId)
    {
        return $this->userQuizRepo->createAndGet($user->id, $quizId);
    }

    private function getOrCreateQuizModel($user, $quizId)
    {
        $quiz = self::getQuizModel(...func_get_args());

        return $quiz ?? self::createQuize(...func_get_args());
    }


    private function getCorrect($quesitionIDs)
    {
       return $this->qeusitionRepo->getAndPluck($quesitionIDs, 'id', 'answer'); 
    }

    private function checkCorrect($answers, $correct)
    {
        $right = array();
        $wrong = array();

        foreach($answers as $id => $answer) {
            if($answer == $correct[$id]) {
                array_push($right, $id);
            } else {
                array_push($wrong, $id);
            }
        }

        return array($right, $wrong);
    }

    private function getQuizId($user)
    {
        $quizzes = $this->userRepo->getQuizzes($user);

        return $quizzes->transform(function ($item, $key) {
            return $item->id;
        })->toArray();
    }
}