<?php

namespace App\Repositories;

use App\PaperDetail;

class PaperDetailRepository
{
    private $detail;

    public function __construct()
    {
        $this->detail = new PaperDetail;
    }

    public function getQuizzes($user)
    {
        return $this->detail
                    ->where('user_id', $user->id)
                    ->whereNull('detail')
                    ->get();           
    }

    public function getQuiz($user)
    {
        return $this->detail
                    ->where('user_id', $user->id)
                    ->whereNull('detail')
                    ->first();
    }

}

?>