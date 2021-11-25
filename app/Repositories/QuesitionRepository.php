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



}

?>