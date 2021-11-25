<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EloquentGetTableNameTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaperDetail extends Model
{
    use SoftDeletes;
    use EloquentGetTableNameTrait;

    protected $table = 'paper_detail';
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id', 'paper_id', 'detail'];
    protected $with= ['paper'];

    public function paper()
    {
        return $this->hasOne('App\Paper', 'id', 'paper_id');
    }

}
