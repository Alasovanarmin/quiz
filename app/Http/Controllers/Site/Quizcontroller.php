<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\QuestionAnswer;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\UserQuestionAnswer;
use Illuminate\Http\Request;

class Quizcontroller extends Controller
{
    public function index()
    {
        $quizzes = Quiz::query()
            ->where('status',1)
            ->withCount('questions')
            ->get();

        return view('site.quizzes',compact('quizzes'));
    }

    public function detail($id, Request $request)
    {
        $quiz = Quiz::query()
            ->where('status',1)
            ->where('id',$id)
            ->withCount('questions')
            ->first();

        if (!$quiz) {
            abort(404);
        }

        $isJoined = UserQuestionAnswer::query()
            ->where('quiz_id',$id)
            ->where('user_id', \auth()->guard('site')->user()->id)
            ->exists();

        return view('site.quiz-detail',compact('quiz','isJoined'));
    }

    public function join($id)
    {
        $questions = QuizQuestion::query()
            ->select(
                'id',
                'title',
                'description',
                'type',
                'level'
            )
            ->with('answers_for_join_page')
            ->where('quiz_id',$id)
            ->get();

        return view('site.quiz-join',compact('questions','id'));
    }

    public function finish($id , Request $request)
    {
        $questions = QuizQuestion::query()
            ->where('quiz_id',$id)
            ->get();

        foreach ($questions as $question){
            $trueAnswer = QuestionAnswer::query()
                ->where('question_id', $question->id)
                ->where('is_true',1)
                ->get();

            //answer for 1 single
            if($question->type == 1){
                $trueAnswer = $trueAnswer[0];
                $is_true = $request->post($question ->id) == $trueAnswer->id;

                //we save  user's answers
                UserQuestionAnswer::query()
                    ->create([
                        'user_id' => \auth()->guard('site')->user()->id,
                        'question_id' => $question->id,
                        'quiz_id' => $question ->quiz->id,
                        'answer_id' =>$request->post($question->id),
                        'is_true' => $is_true
                    ]);
            }
            elseif($question->type == 2){
                $is_true = true;
                if(count($trueAnswer) != count($request->post($question->id))){
                    $is_true = false;
                }
                else{
                    foreach($trueAnswer as $trueA){
                        if(!in_array($trueA->id, $request->post($question->id))){
                            $is_true = false;
                        }
                    }
                }

                UserQuestionAnswer::query()
                    ->create([
                        'user_id'=>\auth()->guard('site')->user()->id,
                        'question_id'=>$question->question_id,
                        'quiz_id'=>$question->quiz_id,
                        'answer' =>implode(',',$request->post($question->id)),
                        'is_true'=>$is_true
                    ]);
            }
            elseif ($question->type == 3){
                $trueAnswer = $trueAnswer[0];
                $is_true = $trueAnswer->answer == $request->post($question->id);

                UserQuestionAnswer::query()
                    ->create([
                        'user_id'=>\auth()->guard('site')->user()->id,
                        'question_id'=>$question->question_id,
                        'quiz_id'=>$question->quiz_id,
                        'answer'=>$request->post($question->id),
                        'is_true'=>$is_true
                    ]);
            }
        }

        return redirect()->route('quiz.detail', $id)->with('success','Successfully saved');
    }
}
