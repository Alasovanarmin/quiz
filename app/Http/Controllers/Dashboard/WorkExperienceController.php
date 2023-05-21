<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WorkExperience;
use Illuminate\Http\Request;

class WorkExperienceController extends Controller
{
    public function create()
    {
        return view("dashboard.work.create");
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => "required",
            'body' => "required",
            'start_date' => "required",
            'end_date' => "nullable",
        ]);

        WorkExperience::query()
            ->create([
                'title' => $request->title,
                'body' => $request->body,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'on_going' => $request->on_going ? 1 : 0
            ]);

        return redirect()->route("dashboard.works")->with("success", "Successfully created");
    }

    public function index()
    {
        $works = WorkExperience::query()
            ->orderByDesc("id")
            ->get();

        return view("dashboard.work.index", compact("works"));
    }

    public function edit($id)
    {
        $work = WorkExperience::query()
            ->where("id", $id)
            ->first();

        return view("dashboard.work.edit", compact("work"));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'title' => "required",
            'body' => "required",
            'start_date' => "required",
            'end_date' => "nullable",
        ]);

        WorkExperience::query()
            ->where("id", $id)
            ->update([
                'title' => $request->title,
                'body' => $request->body,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'on_going' => $request->on_going ? 1 : 0
            ]);

        return redirect()->route("dashboard.works")->with("success", "Successfully updated");
    }
}
