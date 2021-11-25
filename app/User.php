<?php

namespace App;

use DataTables;
use App\Role;
use App\Traits\Permission;
use App\Traits\DataTableSearch;
use App\Traits\EloquentGetTableNameTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use Permission;
    use DataTableSearch;
    use EloquentGetTableNameTrait;

    const ROLE_PUBLISHER = 3;
    const NAME = "User";


    protected $dates = ['deleted_at']; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'email', 'password', 'language' , 'api_token' , 'role_id', 'mug_shot'
    ];

    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['role_name', 'auth_group'];

    protected $attributes = [
        'role_id' => self::ROLE_PUBLISHER,
    ];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function tests()
    {
        return $this->hasMany('App\PaperDetail');
    }

    public function getRoleNameAttribute()
    {
        return $this->role->name;
    }

    public function getauthGroupAttribute()
    {
        $authsGroup = Role::select('id', 'name')
                    ->whereHas('menus', function($roles) {
                        $roles->where('is_super_user', false);
                    })
                    ->distinct()
                    ->get();
        
        return $authsGroup;
    }

    public static function buildUserList($request)
    {   
        $list = self::withTrashed()
                    ->select('id', 'name', 'email', 'language' , 'api_token' , 'role_id', 'deleted_at')
                    ->with([
                        'role.menus' => function($list) {
                            $list->select('name', 'is_super_user');
                        }
                    ])
                    ->whereHas('role.menus', function($list) {
                        $list->where('name', self::getTableName())
                            ->where('is_super_user', false);
                    });
        
        return self::dataTableSearch($list, $request->input(), ['name', 'email'], ['role', 'role_id']);
    }
}
