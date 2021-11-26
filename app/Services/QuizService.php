<?php

namespace App\Services;

use App\Repositories\PaperRepository;
use App\Repositories\QuesitionRepository;

class QuizService
{
    private $paperRepo;
    private $qeusitionRepo;

    public function __construct() 
    {
        $this->paperRepo = new PaperRepository;
        $this->qeusitionRepo = new QuesitionRepository;
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
}