<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::query()
            ->whereNull("deleted_at")
            ->orderByDesc('id')
            ->get();

        return view("dashboard.skills.index", compact("skills"));
    }

    public function indexTrash()
    {
        $skills = Skill::query()
            ->whereNotNull("deleted_at")
            ->orderByDesc('id')
            ->get();

        return view("dashboard.skills.indextrash", compact("skills"));
    }

    public function create()
    {
        return view("dashboard.skills.create");
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'percent' => 'required|integer|min:1|max:100',
            'body' => 'nullable|string|max:1000',
        ]);

        $checkSkill = Skill::query()
            ->where("name", "like", "%$request->name%")
            ->first();

        if ($checkSkill != null) {
            return redirect()->route('dashboard.skill.create')->with("danger", "You cant insert duplicate data!");
        }

        Skill::query()
            ->create([
                'name' => $request->name,
                'percent' => $request->percent,
                'body' => $request->body,
            ]);

        return redirect()->route('dashboard.skills')->with("success", "Successfully created");
    }

    public function edit($id)
    {
        $skill = Skill::query()
            ->where("id", $id)
            ->first();

        return view("dashboard.skills.edit", compact("skill"));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'percent' => 'required|integer|min:1|max:100',
            'body' => 'nullable|string|max:1000'
        ]);

        $checkSkill = Skill::query()
            ->where("name", "like", "%$request->name%")
            ->where("id", "!=", $id)
            ->first();

        if ($checkSkill != null) {
            return redirect()->route('dashboard.skill.edit', $id)->with("danger", "You cant insert duplicate data!");
        }

        Skill::query()
            ->where("id", $id)
            ->update([
                'name' => $request->name,
                'percent' => $request->percent,
                'body' => $request->body,
            ]);

        return redirect()->route('dashboard.skills')->with("success", "Successfully updated");
    }

    public function delete($id)
    {
        Skill::query()
            ->where("id", $id)
            ->update([
                'deleted_at' => date("Y-m-d H:i:s"),
                'deleted_by' => auth()->user()->id
            ]);

        return redirect()->route('dashboard.skills')->with("success", "Successfully deleted");
    }

    public function trashBack($id)
    {
        Skill::query()
            ->where("id", $id)
            ->update([
                'deleted_at' => null,
                'deleted_by' => null,
            ]);

        return redirect()->route('dashboard.skills')->with("success", "Successfully restored");
    }
}
