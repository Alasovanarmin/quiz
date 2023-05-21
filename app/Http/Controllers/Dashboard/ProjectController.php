<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectPhoto;
use App\Models\ProjectTag;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function create()
    {
        return view("dashboard.project.create");
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'photos' => "array|required",
            'photos.*' => "nullable|image|mimes:jpg,jpeg,png",
            'tags' => 'array|required',
            'tags.*' => "nullable|string|max:20"
        ]);

        $project = Project::query()
            ->create([
                'title' => $request->title,
                'body' => $request->body,
                'url' => $request->url,
                'date' => $request->date,
            ]);

        $photos = $request->photos ?? [];
        foreach ($photos as $photo) {
            $fileName = time() . rand(1, 1000) . '.' . $photo->extension();
            $fileNameWithUpload = 'storage/uploads/project/' . $fileName;

            $photo->storeAs('public/uploads/project/', $fileName);

            ProjectPhoto::query()
                ->create([
                    'project_id' => $project->id,
                    'photo' => $fileNameWithUpload,
                ]);
        }

        $tags = $request->tags ?? [];
        foreach ($tags as $tag) {
            if ($tag != null) {
                ProjectTag::query()
                    ->create([
                        'project_id' => $project->id,
                        'tag' => $tag
                    ]);
            }
        }

        return redirect()->route("dashboard.project.create")->with("success", "Successfully added");
    }

    public function index()
    {
        $projects = Project::query()
            ->with("photos", 'tags')
            ->get();

        return view("dashboard.project.index", compact("projects"));
    }

    public function edit($id, Request $request)
    {
        $project = Project::query()
            ->where("id", $id)
            ->with("photos", "tags")
            ->first();

        return view("dashboard.project.edit", compact("project"));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'tags' => 'array|required',
            'tags.*' => "nullable|string|max:20"
        ]);

        Project::query()
            ->where("id", $id)
            ->update([
                'title' => $request->title,
                'body' => $request->body,
                'url' => $request->url,
                'date' => $request->date
            ]);

        ProjectTag::query()
            ->where("id", $id)
            ->delete();
        $tags = $request->tags ?? [];
        foreach ($tags as $tag) {
            if ($tag != null) {
                ProjectTag::query()
                    ->create([
                        'project_id' => $id,
                        'tag' => $tag
                    ]);
            }
        }

        return redirect()->route("dashboard.projects")->with("success", "Successfully updated");
    }

    public function photoIndex($project_id, Request $request)
    {
        $photos = ProjectPhoto::query()
            ->where("project_id", $project_id)
            ->get();

        return view("dashboard.project.photo", compact("photos", "project_id"));
    }

    public function photoDelete($photo_id)
    {
        ProjectPhoto::query()
            ->where("id", $photo_id)
            ->delete();

        return redirect()->route("dashboard.projects")->with("success", "Photo successfully deleted");
    }

    public function photoStore($project_id, Request $request)
    {
        $this->validate($request, [
            'photos' => "array|required",
            'photos.*' => "nullable|image|mimes:jpg,jpeg,png",
        ]);

        $photos = $request->photos ?? [];
        foreach ($photos as $photo) {
            $fileName = time() . rand(1, 1000) . '.' . $photo->extension();
            $fileNameWithUpload = 'storage/uploads/project/' . $fileName;

            $photo->storeAs('public/uploads/project/', $fileName);

            ProjectPhoto::query()
                ->create([
                    'project_id' => $project_id,
                    'photo' => $fileNameWithUpload,
                ]);
        }

        return redirect()->route("dashboard.project.photo", $project_id)->with("success", "Photo successfully added");
    }

}
