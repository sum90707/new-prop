<?php

namespace App\Jobs;

use App\UserQuiz;
use App\Services\QuizService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Grade implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $quizService;
    private $answer;
    private $quiz;
    private $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        QuizService $quizService,
        $answer,
        $quiz,
        $user
    )
    {
        $this->quizService = $quizService;
        $this->answer = $answer;
        $this->quiz = $quiz;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $grade = $this->quizService->grade($this->answer);
        $model = $this->quizService->getQuiz($this->user, $this->quiz->id);
        $model->update([
            'score' => $grade['percent'],
            'detail' => json_encode($grade)
        ]);
    }
}
