<?php
namespace  App\Repositories\Interfaces;

interface QuizRepositoryInterface
{
    public function getSPQuizzes();

    public function list();
    
    public function listIn($ids);
}
