<?php
namespace App\Repositories\Interfaces;

interface UserQuizRepositoryInterface
{
    public function getQuiz($user, $quizId);
    public function getQuizzes($user, $quizId);
    public function getByUser($user);
    public function createAndGet($userId, $quizId);
}
