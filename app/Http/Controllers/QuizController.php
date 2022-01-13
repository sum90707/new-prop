<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Quiz;
use App\Jobs\Grade;
use App\Repositories\UserRepository;
use App\Repositories\QuizRepository;
use App\Repositories\UserQuizRepository;
use App\Services\QuizService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\SortoutDropdown;
use App\Traits\DataTableSearch;

class QuizController extends Controller
{
    use SortoutDropdown;
    use DataTableSearch;

    private $userRepo;
    private $quizRepo;
    private $userQuizRepo;
    private $quizService;

    public function __construct()
    {
        $this->userRepo = new UserRepository;
        $this->quizRepo = new QuizRepository;
        $this->userQuizRepo = new UserQuizRepository;
        $this->quizService = new QuizService;
    }

    public function index(Request $request)
    {
        return view('quiz.index');
    }

    public function get(Request $request, Quiz $quiz)
    {
        try {
            $quesitions = $quiz->paper
                               ->quesitions
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

    public function dropdown(Request $request)
    {
        $quizzes = $this->quizService->getQuizzes(Auth::User());
        return self::SortoutDropdown($quizzes, 'id', 'name');
    }

    public function list(Request $request)
    {
        $list = $this->quizService->getQuizDataTable(Auth::User());
        return self::dataTableSearch($list, $request->input(), ['id', 'name', 'introduce']);
    }

    public function own(Request $request)
    {
        $list = $this->quizService->getOwnQuizDataTable(Auth::User());

        return self::dataTableSearch($list, $request->input(), ['id', 'score'], ['detail', 'quiz_id', 'user_id', 'create_at']);
    }

    public function grade(Request $request, Quiz $quiz)
    {
        request()->validate([
            'Answer' => 'required',
        ]);

        $answer = $request->post('Answer');

        
        try {
            // $grade = $this->quizService->grade($answer);
            // $model = $this->quizService->getQuiz(Auth::User(), $quiz->id);

            // $model->update([
            //     'detail' => json_encode($grade),
            //     'score' => $grade['percent']
            // ]);
            dispatch((new Grade($answer, $quiz, Auth::User())));

            return new JsonResponse([ 
                'message' => 'Successfully handed in !',
            ]);
            
            // return new JsonResponse([ 
            //     'message' => 'Successfully handed in ! Score : ' . $grade['percent'] . '/100',
            // ]);
        } catch (\Throwable $th) {
            return new JsonResponse([ 
                'message' => 'Operation fail !'
            ], 422);
        }
    }

    public function status(Request $request, $id)
    {
        try { 
            $model = Quiz::withTrashed()
                          ->find($id);

            if($request->user()->can('delete', $model)) {
                $model->trashed() ? $model->restore() : $model->delete();
            } else {
                throw  new \Exception('This action is unauthorized.');
            }

            return new JsonResponse([ 
                'message' => 'update successfully.',
                'deleted' => $model->trashed()
            ]);
        } catch (\Throwable $th) {
            return new JsonResponse([ 
                'message' => 'Operation fail !' .$th->getMessage()
            ], 422);
        }
    }
}
