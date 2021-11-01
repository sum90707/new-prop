<?php

namespace App\Traits;

use Auth;
use App\Menu;

trait Permission
{
    public function permissions($class)
    {
        
        $user = Auth::user();

        return [
            'superuser' => $user->can('superuser', $class),
            'readable'  => $user->can('read', $class),
            'creatable' => $user->can('create', $class),
            'editable'  => $user->can('edit', $class),
            'deletable' => $user->can('delete', $class)
        ];
    }
}