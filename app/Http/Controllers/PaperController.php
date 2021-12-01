<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Paper;
use App\Quesition;
use App\Repositories\QuesitionRepository;
use App\Repositories\PaperRepository;
use App\Traits\DataTableSearch;
use App\Traits\SortoutDropdown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class PaperController extends Controller
{
    use DataTableSearch;
    use SortoutDropdown;

    private $paperRepo;
    private $quesitionRepo;

    public function __construct()
    {
        $this->paperRepo = new PaperRepository;
        $this->quesitionRepo = new QuesitionRepository;
    }

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

        $paper = $request->post('Paper');
        try {

            $this->paperRepo->creatWithUser($paper, Auth::id());

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
        $list = $this->paperRepo->list();
        return self::dataTableSearch($list, $request->input(), ['id', 'name', 'introduce']);
    }

    public function dropdwon(Request $request)
    {
        $papers = $this->paperRepo->list();
        return self::SortoutDropdown($papers->get(), 'id', 'name');
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
            $quesitions = $paper->quesitions
                                ->makeHidden(['answer']);
            return new JsonResponse([ 
                'message' => 'save quesitions successfully.',
                'data' => $quesitions
            ]);
         } catch (\Throwable $th) {
            return new JsonResponse([ 
                'message' => 'Operation fail !' . $th->getMessage()
            ], 422);
        }
    }

    public function multiSave(Request $request, Paper $paper)
    {

        request()->validate([
            'Import.tf' => 'integer|between:0,50',
            'Import.mutltiple' => 'integer|between:0,50'
        ]);

        $amount = $request->post('Import');
        $ids = array();
        $types = array(
            'tf' => 0,
            'mutltiple' => 1
        );

        try {

            foreach($types as $key => $type) {
                $ids = array_merge($ids, $this->quesitionRepo->random($type, $amount[$key]));
            }
            sort($ids);
            $paper->quesitions()->sync($ids);

            return new JsonResponse([ 
                'message' => 'save quesitions successfully.',
            ]);
        } catch (\Throwable $th) {
            return new JsonResponse([ 
                'message' => 'Operation fail !' . $th->getMessage()
            ], 422);
        }
    }
    
}
