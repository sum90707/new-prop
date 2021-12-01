<?php

namespace App\Repositories;

use App\Quesition;

class QuesitionRepository
{
    private $paper;

    public function __construct()
    {
        $this->quesition = new Quesition;
    }

    public function getAndPluck($ids, $key, $value)
    {
        return $this->quesition
                    ->whereIn('id', $ids)
                    ->get()
                    ->pluck($value, $key)
                    ->toArray();
    }

    public function list()
    {
        return $this->quesition
                    ->withTrashed()
                    ->with([
                        'options' => function($list) {
                            $list->select('quesition_id', 'order', 'introduce')
                                 ->orderBy('order', 'ASC');
                        }
                    ])
                    ->select('id', 'name', 'year', 'type', 'introduce', 'answer', 'deleted_at')
                    ->orderBy('id');
    }

    public function random($type, $amount)
    {
       return $this->quesition
                   ->select('id')
                   ->where('type', $type)
                   ->inRandomOrder()
                   ->limit($amount)
                   ->get()
                   ->pluck('id')
                   ->toArray();
    }

}