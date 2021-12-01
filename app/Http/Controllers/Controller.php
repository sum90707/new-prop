<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function statusToggle($model, $index)
    {
        $model = $model->withTrashed()
                       ->find($index);

        $model->trashed() ? $model->restore() : $model->delete();

        return $model->trashed();
    }
}
