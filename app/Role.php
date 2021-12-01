<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function menus()
    {
        return $this->belongsToMany('App\Menu', 'role_menu');
    }

}
