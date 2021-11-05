<?php

namespace App\Http\Controllers;

use Auth;
use App\Paper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class PaperController extends Controller
{
    public function index(Request $request)
    {
        return view('paper.index');
    }

    public function create(Request $request)
    {
        
        request()->validate([
            'Paper.name' => 'required|max:20|unique:papers,name',
            'Paper.introduce' => 'required|max:1000'
        ]);

        
        try {
            
            $paper = $request->post('Paper');

            $model = new Paper;
            $model->fill($paper);
            $model->create_by = Auth::id();

            $model->save();

            return new JsonResponse([
                'message' => 'save successfully'
            ]);
        } catch (\Throwable $th) {
            return new JsonResponse([
                'message' => 'Operation fail'
            ], 400);
        }
    }

    public function list(Request $request)
    {
        return Paper::buildPaperList($request);
    }

    public function status(Request $request, $id)
    {
        try { 
            $paper = Paper::withTrashed()
                          ->find($id);

            if($request->user()->can('delete', $paper)) {
                $paper->trashed() ? $paper->restore() : $paper->delete();
            } else {
                throw  new \Exception('This action is unauthorized.');
            }

            return new JsonResponse([ 
                'message' => 'update successfully.',
                'deleted' => $paper->trashed()
            ]);
        } catch (\Throwable $th) {
            return new JsonResponse([ 
                'message' => 'Operation fail !' .$th->getMessage()
            ], 422);
        }
    }
}
