<?php

namespace App\Http\Controllers;

use Auth;
use App\Paper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Traits\SortoutDropdown;

class PaperController extends Controller
{
    
    use SortoutDropdown;

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

    public function dropdwon(Request $request)
    {
        $papers = Paper::select('id', 'name')
                        ->visible()
                        ->get();

        return self::SortoutDropdown($papers, 'id', 'name');
        
        // return $papers->get()
        //               ->pluck('name', 'id');
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

    public function selected(Request $request,Paper $paper)
    {
        request()->validate([
            'Quesition.id' => 'required'
        ]);

        $ids = array_unique($request->post('Quesition')['id']);
    
        try {
            $paper->quesitions()->sync($ids);
            
            return new JsonResponse([ 
                'message' => 'save quesitions successfully.'
            ]);
         } catch (\Throwable $th) {
            return new JsonResponse([ 
                'message' => 'Operation fail !' . $th->getMessage()
            ], 422);
        }
    }

    public function getSelected(Request $request,Paper $paper)
    {
        try {
            return new JsonResponse([ 
                'message' => 'save quesitions successfully.',
                'data' => $paper->quesitions
            ]);
         } catch (\Throwable $th) {
            return new JsonResponse([ 
                'message' => 'Operation fail !' . $th->getMessage()
            ], 422);
        }
    }
}
