<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\QuestionAnswer;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\UserQuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Quizcontroller extends Controller
{
    public function index()
    {
        $quizzes = Quiz::query()
            ->where('status',1)
            ->withCount('questions')
            ->get();

         $quizzesYouJoin = UserQuestionAnswer::query()
            ->from('user_question_answers as uqa')
            ->select('quiz_id', 'quizzes.title')
            ->leftJoin('quizzes','quizzes.id','uqa.quiz_id')
            ->where('user_id',\auth()->guard('site')->user()->id)
            ->groupBy('quiz_id','quizzes.title')
            ->get();

        return view('site.quizzes',compact('quizzes','quizzesYouJoin'));
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

        $finishedDate = UserQuestionAnswer::query()
            ->select('created_at')
            ->where('quiz_id',$id)
            ->where('user_id',\auth()->guard('site')->user()->id)
            ->first()?->created_at;

        $result = UserQuestionAnswer::query()
            ->select(
                DB::raw("SUM(is_true) as correct_count"),
                DB::raw("COUNT(id)-SUM(is_true) as wrong_count"),
            )
            ->where('quiz_id',$id)
            ->where('user_id',\auth()->guard('site')->user()->id)
            ->groupBy('quiz_id')
            ->get();

        $participants = UserQuestionAnswer::query()
            ->select('user_id')
            ->where('quiz_id',$id)
            ->groupBy('user_id')
            ->get();
        $numberOfParticipants = count($participants);

        $topTen = UserQuestionAnswer::query()
            ->from('user_question_answers as uqa')
            ->select(
                DB::raw('SUM(uqa.is_true) as correct_count'),
                DB::raw("CONCAT(site_users.name,' ', site_users.surname) as fullName"),
                'site_users.id as user_id'
            )
            ->leftJoin('site_users','site_users.id','uqa.user_id')
            ->where('quiz_id',$id)
            ->groupBy('site_users.id',
                DB::raw("CONCAT(site_users.name,' ', site_users.surname)")
            )
            ->orderByDesc('correct_count')
            ->get();

        $myRank = null;
        $loop =1;

        foreach ($topTen as $top){
            if($top->user_id == \auth()->guard('site')->user()->id){
                $myRank = $loop;
                break;
            }

            $loop++;
        }

        return view('site.quiz-detail',compact(
            'quiz','isJoined','result','finishedDate','numberOfParticipants','topTen','myRank'));
    }

    public function join($id)
    {
        $checkJoin = UserQuestionAnswer::query()
            ->where('quiz_id', $id)
            ->where('user_id', \auth()->guard('site')->user()->id)
            ->exists();

        if($checkJoin){
            abort(403);
        }

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
                $is_true = $request->post($question->id) == $trueAnswer->id;

                //we save  user's answers
                UserQuestionAnswer::query()
                    ->create([
                        'user_id' => \auth()->guard('site')->user()->id,
                        'question_id' => $question->id,
                        'quiz_id' => $question->quiz_id,
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
                        'question_id'=> $question->id,
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
                        'question_id'=>$question->id,
                        'quiz_id'=>$question->quiz_id,
                        'answer'=>$request->post($question->id),
                        'is_true'=>$is_true
                    ]);
            }
        }

        return redirect()->route('quiz.detail', $id)->with('success','Successfully saved');
    }
}
