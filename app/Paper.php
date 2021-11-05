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
        return $this->belongsToMany('App\Quesition', 'paper_quesition');
    }

    public function createBy()
    {
        return $this->hasOne('App\User', 'id', 'create_by');
    }

    public static function buildPaperList($request)
    {
        $user = Auth::User();

        $list = self::withTrashed()
                    ->with([
                        'createBy' => function($list) {
                            $list->select('id', 'name', 'role_id');
                        }
                    ])
                    ->select('id', 'name', 'introduce', 'create_by', 'deleted_at')
                    ->orderBy('id');
        
        if($user->cannot('superuser', self::class)) {
            $list->where('create_by', $user->id);
        }

        return self::dataTableSearch($list, $request->input(), ['id', 'name', 'introduce']);
    }
}
