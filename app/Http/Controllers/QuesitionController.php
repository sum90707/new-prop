<?php

namespace App\Http\Controllers;

use Lang;
use App\Quesition;
use App\Repositories\QuesitionRepository;
use App\Traits\DataTableSearch;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class QuesitionController extends Controller
{
    use DataTableSearch;

    private $quesitionRepo;

    public function __construct()
    {
        $this->quesitionRepo = new QuesitionRepository;
    }

    public function index(Request $request)
    {
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

        $quesition = $request->post('Quesition');
        $options = $request->post('Options');

        
        try {
            $model = Quesition::create($quesition);

            if ($options) {
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

    public function list(Request $request)
    {
        $list = $this->quesitionRepo->list();
        $list = self::dataTableSearch($list, $request->input(), ['id', 'name', 'year', 'type', 'introduce']);
        self::translateType($list['data']);

        return $list;
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

    public function status(Request $request, $id)
    {
        try {
            $quesition = Quesition::withTrashed()
                        ->find($id);

            $quesition->trashed() ? $quesition->restore() : $quesition->delete();

            return new JsonResponse([
                'message' => 'update successfully.',
                'deleted' => $quesition->trashed()
            ]);
        } catch (\Throwable $th) {
            return new JsonResponse([
                'message' => 'Operation fail'
            ], 422);
        }
    }

    public function get(Request $request, Quesition $quesition)
    {
        $quesition = array($quesition->toArray());
        self::translateType($quesition);

        return new JsonResponse([
            'data' => $quesition
        ]);
    }

    private static function translateType(&$data)
    {
        $type = Lang::get('quesition.types');
        foreach ($data as &$row) {
            $row['type'] = [
                'type' => $row['type'],
                'lang' => $type[$row['type']]
            ];
        }
    }
}
