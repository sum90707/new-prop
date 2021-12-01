<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Quiz;
use App\Repositories\UserRepository;
use App\Repositories\UserQuizRepository;
use App\Services\QuizService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\SortoutDropdown;

class QuizController extends Controller
{
    use SortoutDropdown;

    private $userRepo;
    private $userQuizRepo;
    private $quizService;

    public function __construct()
    {
        $this->userRepo = new UserRepository;
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
        $quizzes = $this->userRepo->getQuizzes(Auth::User());
        return self::SortoutDropdown($quizzes, 'quiz.id', 'quiz.name');
    }

    public function grade(Request $request, Quiz $quiz)
    {
        request()->validate([
            'Answer' => 'required',
        ]);

        $answer = $request->post('Answer');

        try {
            $grade = $this->quizService->grade($answer);
            $model = $this->userQuizRepo->getQuiz(Auth::User(), $quiz->id);
            
            $model->update([
                'detail' => json_encode($grade),
                'score' => $grade['percent']
            ]);
            
            return new JsonResponse([ 
                'message' => 'Successfully handed in ! Score : ' . $grade['percent'] . '/100',
            ]);
        } catch (\Throwable $th) {
            return new JsonResponse([ 
                'message' => 'Operation fail !'
            ], 422);
        }
    }
}
