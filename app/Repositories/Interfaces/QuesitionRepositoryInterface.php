<?php
namespace App\Repositories\Interfaces;

interface QuesitionRepositoryInterface
{
    public function getAndPluck($ids, $key, $value);
    public function list();
    public function random($type, $amount);
}
