<?php

namespace App;

use Auth;
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

    protected $fillable = [
        'name', 'year', 'type', 'introduce' , 'answer'
    ];

    public function options()
    {
        return $this->hasMany('App\Option');
    }

}
