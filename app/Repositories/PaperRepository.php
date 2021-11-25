<?php

namespace App\Repositories;

use App\Paper;

class PaperRepository
{
    private $paper;

    public function __construct()
    {
        $this->paper = new Paper;
    }

    public function getAndPluck($id, $key, $value)
    {
        
        if(is_array($id)) {
            $this->paper->whereIn('id', $id);
            
        } else {
            $this->paper->where('id', $ids);
        }
        dd($this->paper->whereIn('id', $id)->get()->toArray());
        return $this->paper->get()
                     ->pluck($key, $value)
                     ->toArray();
    }



}

?>