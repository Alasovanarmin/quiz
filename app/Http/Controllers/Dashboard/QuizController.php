<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function create()
    {
        $categories = Category::query()
                ->get();
        return view('dashboard.quiz.create',compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:100',
        ]);

        Quiz::query()
            ->create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'category_id' => $request->category_id
            ]);

        return redirect()->route('dashboard.quizzes')->with("success","created successfully");
    }

    public function index()
    {
        $quizzes = Quiz::query()
            ->select([
                'quizzes.id',
                'quizzes.title',
                'quizzes.description',
                'quizzes.status',
                'categories.name as category_name'
            ])
            ->withCount('questions')
            ->leftJoin('categories','quizzes.category_id','categories.id')
            ->orderByDesc('id')
            ->get();

            return view('dashboard.quiz.index',compact('quizzes'));
    }

    public function edit($id)
    {
        $quiz = Quiz::query()
                ->where('id', $id)
                ->first();

        $categories = Category::query()
            ->get();

        return view('dashboard.quiz.edit',compact('categories','quiz'));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:100',
        ]);

        Quiz::query()
            ->where('id',$id)
            ->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'category_id' => $request->category_id
            ]);

        return redirect()->route('dashboard.quizzes');
    }

    public function delete($id)
    {
        Quiz::query()
            ->where('id',$id)
            ->delete();

        return redirect()->route('dashboard.quizzes');
    }
}
