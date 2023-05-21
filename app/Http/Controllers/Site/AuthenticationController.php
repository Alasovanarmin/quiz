<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\LoginRequest;
use App\Http\Requests\Site\RegisterRequest;
use App\Models\SiteUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthenticationController extends Controller
{
    public function registerPage()
    {
        return view('site.register');
    }

    public function register(RegisterRequest $request)
    {
        $create = [
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'name' => $request->name,
            'surname' => $request->surname,
        ];

        if ($request->photo != null) {
            $fileName = time() . rand(1, 1000) . '.' . $request->photo->extension();
            $fileNameWithUpload = 'storage/uploads/users/' . $fileName;

            $request->photo->storeAs('public/uploads/users/', $fileName);

            $create['photo'] = $fileNameWithUpload;
        }

        $user = SiteUser::query()
            ->create($create);

        $subject = "Email tesdiqleme";
        $email = $request->email;
        $link = env("APP_URL") . "/verify-account/$user->id";

        Mail::send("mail.verify-email", ['link' => $link], function ($a) use($subject, $email) {
            return $a->subject($subject)->to($email);
        });

        return redirect()->route("registerPage")->with("success", "Successfully registered. Please enter email and verify accaunt");
   }

    public function verifyAccount($user_id)
    {
        $user = SiteUser::query()
            ->where('id',$user_id)
            ->whereNull('email_verified_at')
            ->first();

        if(!$user){
            abort('404');
        }

        $user->update([
            'email-verified-at' => now()
        ]);

        return redirect()->route("registerPage")->with("success", "Successfully verified!");
   }

    public function loginPage()
    {
        return view('site.login');
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::guard('site')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route("loginPage")->with('fail', 'Email or password is wrong');
        }

        return redirect()->route("quizzes")->with('success', 'Successfully logged');
    }

    public function logout()
    {
        Auth::guard("site")->logout();

        return redirect()->route("loginPage");
    }
}
