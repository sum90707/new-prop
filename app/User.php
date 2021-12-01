<?php

namespace App;

use App\Role;
use App\Traits\DataTableSearch;
use App\Traits\EloquentGetTableNameTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
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
        'name', 'email', 'password', 'language' , 'api_token' , 'role_id', 'mug_shot', 'introduce'
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

    public function score()
    {
        return $this->hasMany('App\UserQuiz');
    }

    public function quizzes()
    {
        return $this->belongsToMany('App\Quiz', 'user_quiz');
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
}
