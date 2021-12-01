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

    public function creatWithUser($attributes, $id)
    {
        $attributes = array_add($attributes, 'create_by', $id);
        return $this->paper->forceFill($attributes)->saveOrFail();
        
    }

    public function list()
    {
        return $this->paper
                    ->withTrashed()
                    ->with([
                        'createBy' => function($list) {
                            $list->select('id', 'name', 'role_id');
                        }
                    ])
                    ->select('id', 'name', 'introduce', 'create_by', 'deleted_at')
                    ->visible()
                    ->orderBy('id');
    }



}