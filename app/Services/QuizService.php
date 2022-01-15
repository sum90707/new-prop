<?php

namespace App\Services;

use App\Repositories\UserQuizRepository;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\QuizRepositoryInterface;
use App\Repositories\Interfaces\QuesitionRepositoryInterface;
use App\Repositories\Interfaces\UserQuizRepositoryInterface;

class QuizService
{
    private $userRepo;
    private $quizRepo;
    private $qeusitionRepo;
    private $userQuizRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
        QuizRepositoryInterface $quizRepo,
        QuesitionRepositoryInterface $qeusitionRepo,
        UserQuizRepositoryInterface $userQuizRepo
    ) {
        $this->userRepo = $userRepo;
        $this->quizRepo = $quizRepo;
        $this->qeusitionRepo = $qeusitionRepo;
        $this->userQuizRepo = $userQuizRepo;
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
        if ($user->can('superuser', 'App\Quiz')) {
            $quizzes = $this->quizRepo->getSPQuizzes();
        } else {
            $quizzes = $this->userRepo->getQuizzes($user);
        }

        return $quizzes;
    }

    public function getQuiz($user, $quizId)
    {
        if ($user->can('superuser', 'App\Quiz')) {
            $quiz = self::getOrCreateQuizModel(...func_get_args());
        } else {
            $quiz = self::getQuizModel(...func_get_args());
        }

        return $quiz->first();
    }

    public function getQuizDataTable($user)
    {
        if ($user->can('superuser', 'App\Quiz')) {
            $quizzes = $this->quizRepo->list();
        } else {
            $ids = self::getQuizId($user);
            $quizzes = $this->quizRepo->listIn($ids);
        }

        return $quizzes;
    }

    public function getOwnQuizDataTable($user)
    {
        return $this->userQuizRepo->getByUser($user);
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

        return $quiz->isEmpty() ? self::createQuize(...func_get_args()) : $quiz;
    }


    private function getCorrect($quesitionIDs)
    {
        return $this->qeusitionRepo->getAndPluck($quesitionIDs, 'id', 'answer');
    }

    private function checkCorrect($answers, $correct)
    {
        $right = array();
        $wrong = array();

        foreach ($answers as $id => $answer) {
            if ($answer == $correct[$id]) {
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
