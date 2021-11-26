<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EloquentGetTableNameTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserQuiz extends Model
{
    use EloquentGetTableNameTrait;

    protected $table = 'user_quiz';
    protected $dates = ['deleted_at'];
    protected $fillable = ['quiz_id', 'user_id', 'detail', 'score'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function quiz()
    {
        return $this->belongsTo('App\Quiz');
    }
}
