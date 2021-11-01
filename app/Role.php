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

    public static function rolesWithOutSuper($table, $columns)
    {
        $roles = self::whereHas('menus', function($roles) use ($table) {
                        $roles->where('is_super_user', false)
                              ->where('name', $table);
                    })
                    ->distinct()
                    ->get()
                    ->pluck(...$columns)
                    ->toArray();
        
        return $roles;
    }

    public static function getRoleName(self $role)
    {
        dd($role);
        return $role->name;
    }

}
