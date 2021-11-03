<?php

namespace App\Http\Controllers;

use Auth;
use App\Option;
use App\Quesition;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class QuesitionController extends Controller
{
    public function index(Request $request)
    {
        dd(Auth::User()->can('read', 'App\Quesition'));
        return view('quesition.index');
    }

    public function create(Request $request)
    {
        
        request()->validate([
            'Quesition.name' => 'required|max:30',
            'Quesition.year' => 'required|regex:/^[0-9\s]+$/i',
            'Quesition.introduce' => 'required|max:1024',
            'Quesition.answer' => 'required|regex:/^[0-9\s]+$/i',
            'Quesition.type' => [Rule::in(array_keys(config('quesition.types')))],
        ]);


        
        
        try {
            $quesition = $request->post('Quesition');
            $options = $request->post('Options');

            $model = Quesition::create($quesition);

            if($options) {
                $model->options()->createMany($options);
            }

            return new JsonResponse([
                'message' => 'save successfully'
            ]);
        } catch (\Throwable $th) {
            return new JsonResponse([
                'message' => 'Operation fail'
            ], 400);
        }
    }

    public function type(Request $request)
    {
        try {

            $blade = config('quesition.types')[$request->trigger];
            return view("quesition.$blade");
            
        } catch (\Throwable $th) {
            return new JsonResponse([
                'message' => 'Operation fail'
            ], 400);
        }
    }
    
}
