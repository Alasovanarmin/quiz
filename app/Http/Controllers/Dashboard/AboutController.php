<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::query()->first();

        return view("dashboard.about", compact("about"));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            "email"  => "required|email",
            "photo"  => "nullable|image|mimes:jpg,jpeg,png",
        ]);

        About::query()
            ->first()
            ->update([
                'email' => $request->email,
                'phone' => $request->phone,
                'summary' => $request->summary,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'github' => $request->github,
                'linkedin' => $request->linkedin,
            ]);

        if ($request->file('photo')) { // File metoddur. icine verdiyim string formdan gelen addir.
            $fileName = time() . rand(1, 1000) . '.' . $request->photo->extension();  // 12312312545.png Meqsedim unique bir ad yaratmaqdi serverde saxlamaga
            $fileNameWithUpload = 'storage/uploads/about/' . $fileName; // storage/uploads/about/12312312545.png

            $request->photo->storeAs('public/uploads/about/', $fileName); //servere(bizim kompyuter) hemin yazdigimiz foldere yukleyir

            About::query()
                ->first()
                ->update([
                    'photo' => $fileNameWithUpload
                ]);
        }

        return redirect()->route("dashboard.about")->with('success', 'Successfully updated');
    }
}
