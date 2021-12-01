<?php

namespace App\Repositories;

use App\Role;

class RoleRepository
{
    private $role;

    public function __construct()
    {
        $this->role = new Role;
    }

    public function rolesWithoutSuper($table, $columns)
    {
        $roles = $this->role
                      ->whereHas('menus', function($roles) use ($table) {
                            $roles->where('is_super_user', false)
                                ->where('name', $table);
                        })
                      ->distinct()
                      ->get()
                      ->pluck(...$columns)
                      ->toArray();

        return $roles;
    }

}
