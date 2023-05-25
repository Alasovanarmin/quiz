<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\ProfileUpdate;
use App\Http\Requests\Site\ProfileUpdateRequest;
use App\Models\SiteUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        $user = SiteUser::query()->where('id',\auth()->guard('site')->user()->id)->first();

        return view('site.profile',compact('user'));
    }

    public function profileUpdate(ProfileUpdateRequest $request)
    {

        $update = [
            'name' => $request->name,
            'surname' => $request->surname
        ];

        if ($request->file('photo')) {
            $fileName = time() . rand(1, 1000) . '.' . $request->photo->extension();
            $fileNameWithUpload = 'storage/uploads/profile/' . $fileName;

            $request->photo->storeAs('public/uploads/profile/', $fileName);
            $update['photo'] = $fileNameWithUpload;
        }

        SiteUser::query()
            ->where('id', \auth()->guard('site')->user()->id)
            ->first()
            ->update($update);

        return redirect()->route('profile');
    }

    public function changePassword(Request $request)
    {
        if (!Auth::guard('site')->attempt(['email' => auth()->guard('site')->user()->email, 'password' => $request->current_password])) {
            return redirect()->route("profile")->with('fail', 'password is wrong');
        }

        SiteUser::query()
            ->where('id',\auth()->guard('site')->user()->id)
            ->update([
                'password' =>bcrypt($request->new_password)
            ]);

        Auth::logout();

        return redirect()->route('quizzes');

    }
}
