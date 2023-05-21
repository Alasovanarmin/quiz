<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\QuestionAnswer;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index($quiz_id)
    {
        $questions = QuizQuestion::query()
            ->with('answers')
            ->where('quiz_id', $quiz_id)
            ->get();

        $quiz = Quiz::query()
            ->select('title')
            ->where('id', $quiz_id)
            ->first();

        return view('dashboard.question.index',compact('quiz_id','questions','quiz'));
    }

    public function create($quiz_id)
    {
        return view('dashboard.question.create',compact('quiz_id'));
    }

    public function store($quiz_id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'type' => 'required|int|max:10',
            'level' => 'required|int|max:10',
            "photo" => "nullable|image|mimes:jpg,jpeg,png",
        ]);

        $question = QuizQuestion::query()
            ->create([
                'quiz_id' =>$quiz_id,
                'title' =>$request->title,
                'description' =>$request->description,
                'type' =>$request->type,
                'level' =>$request->level
            ]);

        if($request->file('photo')) {
            $fileName = time() . rand(1, 1000) . '.' . $request->photo->extension();
            $fileNameWithUpload = 'storage/uploads/question/' . $fileName;

            $request->photo->storeAs('public/uploads/question/', $fileName);

            QuizQuestion::query()
                ->where('id', $question->id)
                ->update([
                    'photo' => $fileNameWithUpload
                ]);
        }

        for($i=0; $i<count($request->answers); $i++)
        {
            $answer = $request->answers[$i];
            $is_true = $request->is_true[$i];

            QuestionAnswer::query()
                ->create([
                    'question_id' =>$question->id,
                    'answer' => $answer,
                    'is_true' => $is_true
                ]);
        }

        return redirect()->route('dashboard.quiz.questions',$quiz_id)->with('success','Successfully created');
    }

    public function edit($question_id)
    {
        $question = QuizQuestion::query()
            ->where('id',$question_id)
            ->with('answers')
            ->first();

        return view('dashboard.question.edit',compact('question'));

    }

    public function update($question_id, Request $request)
    {
        $question = QuizQuestion::query()
            ->where('id', $question_id)
            ->first();
        $quiz_id = $question->quiz_id;

        $question->update([
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'level' => $request->level
            ]);

        QuestionAnswer::query()
            ->where('question_id', $question_id)
            ->delete();

        for ($i = 0; $i < count($request->answers); $i++) {
            $answer = $request->answers[$i];
            $is_true = $request->is_true[$i];

            QuestionAnswer::query()
                ->create([
                    'question_id' => $question_id,
                    'answer' => $answer,
                    'is_true' => $is_true
                ]);
        }

        if ($request->file('photo')) {
            $fileName = time() . rand(1, 1000) . '.' . $request->photo->extension();
            $fileNameWithUpload = 'storage/uploads/about/' . $fileName;

            $request->photo->storeAs('public/uploads/about/', $fileName);

            QuizQuestion::query()
                ->first()
                ->update([
                    'photo' => $fileNameWithUpload
                ]);
        }

        return redirect()->route('dashboard.quiz.questions', $quiz_id)->with("success",'Successfully updated');
    }

    public function delete($question_id)
    {
       $question = QuizQuestion::query()
            ->where('id', $question_id)
            ->first();

       $quiz_id = $question->quiz_id;

       $question->delete();

       QuestionAnswer::query()
            ->where('question_id',$question_id)
            ->delete();

        return redirect()->route('dashboard.quiz.questions', $quiz_id)->with("success",'Successfully updated');
    }
}
