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

    public function getSPQuizzes()
    {
        return $this->quiz->all();
    }

    public function list()
    {
        return $this->quiz
                    ->withTrashed()
                    ->with([
                        'createBy' => function($list) {
                            $list->select('id', 'name', 'role_id');
                        },
                        'paper'  => function($list) {
                            $list->select('id', 'name', 'introduce');
                        }
                    ])
                    ->select('id', 'name', 'introduce', 'create_by', 'deleted_at', 'paper_id')
                    ->orderBy('id');
    }

    public function listIn($ids)
    {
        return $this->quiz
                    ->withTrashed()
                    ->with([
                        'createBy' => function($list) {
                            $list->select('id', 'name', 'role_id');
                        },
                        'paper'  => function($list) {
                            $list->select('id', 'name', 'introduce');
                        }
                    ])
                    ->whereIn('id', $ids)
                    ->select('id', 'name', 'introduce', 'create_by', 'deleted_at', 'paper_id')
                    ->orderBy('id');
    }

}
