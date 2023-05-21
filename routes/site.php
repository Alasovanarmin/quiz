<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\AuthenticationController;
use App\Http\Controllers\Site\Quizcontroller;


Route::redirect("/", "/login");

Route::get('/register',[AuthenticationController::class,'registerPage'])->name('registerPage');
Route::post('/register',[AuthenticationController::class,'register'])->name('register');
Route::get('/verify-account/{user_id}',[AuthenticationController::class,'verifyAccount'])->name('verifyaccount');
Route::get("/login", [AuthenticationController::class, 'loginPage'])->name("loginPage");
Route::post("/login", [AuthenticationController::class, 'login'])->name("login");
Route::get("/logout", [AuthenticationController::class, 'logout'])->name("logout");

Route::group(['middleware'=>'authCheckSite'],function (){

    Route::get("/quizzes", [Quizcontroller::class, 'index'])->name("quizzes");
    Route::get("/quiz/{id}", [Quizcontroller::class, 'detail'])->name("quiz.detail");
    Route::get("/quiz/join/{id}", [Quizcontroller::class, 'join'])->name("quiz.join");
    Route::post("/quiz/finish/{id}", [Quizcontroller::class, 'finish'])->name("quiz.finish");
});
