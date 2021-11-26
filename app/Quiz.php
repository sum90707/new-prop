<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EloquentGetTableNameTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use SoftDeletes;
    use EloquentGetTableNameTrait;

    protected $table = 'quizzes';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'introduce', 'paper_id', 'create_by'];

    public function paper()
    {
        return $this->hasOne('App\Paper', 'id', 'paper_id');
    }

    public function createBy()
    {
        return $this->hasOne('App\User', 'id', 'create_by');
    }

    public function ownner()
    {
        return $this->hasMany('App\UserQuiz');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_quiz');
    }
}
