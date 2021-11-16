<?php

namespace App;

use Auth;
use Lang;
use App\Option;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\DataTableSearch;
use App\Traits\EloquentGetTableNameTrait;

class Quesition extends Model
{
    use SoftDeletes;
    use DataTableSearch;
    use EloquentGetTableNameTrait;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $appends = ['option'];

    protected $fillable = [
        'name', 'year', 'type', 'introduce' , 'answer'
    ];

    public function options()
    {
        return $this->hasMany('App\Option');
    }

    public function getOptionAttribute()
    {
        return $this->options;
    }

    public static function buildQuesitionList($request)
    {
        $list = self::withTrashed()
                    ->with([
                        'options' => function($list) {
                            $list->select('quesition_id', 'order', 'introduce')
                                 ->orderBy('order', 'ASC');
                        }
                    ])
                    ->select('id', 'name', 'year', 'type', 'introduce', 'answer', 'deleted_at')
                    ->orderBy('id');
        
        return self::dataTableSearch($list, $request->input(), ['id', 'name', 'year', 'type', 'introduce']);
    }

    public static function random($type, $amount)
    {
       return Quesition::select('id')
                        ->where('type', $type)
                        ->inRandomOrder()
                        ->limit($amount)
                        ->get()
                        ->pluck('id')
                        ->toArray();
    }

}
