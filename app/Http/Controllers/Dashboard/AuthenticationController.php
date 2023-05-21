<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function loginPage()
    {
        return view("dashboard.login");
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:155',
            'parol' => 'required|string|max:500|min:3'
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->parol])) {
            return redirect()->route("dashboard.login")->with('fail', 'Email or password is wrong');
        }

        return redirect()->route("dashboard.home")->with('success', 'Successfully logged');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route("dashboard.login");
    }

    public function changePassword(Request $request)
    {
        if (!Auth::attempt(['email' => auth()->user()->email, 'password' => $request->old_password])) {
            return redirect()->route("dashboard.home")->with('fail', 'Password is wrong');
        }

        User::query()
            ->where("email", auth()->user()->email)
            ->update([
                'password' => bcrypt($request->new_password)
            ]);

        Auth::logout();

        return redirect()->route("dashboard.login");
    }
}
