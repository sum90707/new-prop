<?php

namespace App;

use Auth;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\DataTableSearch;
use App\Traits\EloquentGetTableNameTrait;

class Paper extends Model
{
    use SoftDeletes;
    use DataTableSearch;
    use EloquentGetTableNameTrait;

    protected $fillable = [
        'name', 'introduce' 
    ];

    public function quesitions()
    {
        return $this->belongsToMany('App\Quesition', 'paper_quesition')
                    ->withTimestamps()
                    ->orderBy('type');
    }

    public function createBy()
    {
        return $this->hasOne('App\User', 'id', 'create_by');
    }

    public function scopeVisible($query)
    {
        if(Auth::User()->can('superuser', Paper::class)) {
            return $query;
        }

        return $query->where('create_by', Auth::id());
        
    }
}
