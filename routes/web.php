<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthenticationController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\AboutController;
use App\Http\Controllers\Dashboard\CategoryController;
//use App\Http\Controllers\Dashboard\WorkExperienceController;
//use App\Http\Controllers\Dashboard\ProjectController;
//use App\Http\Controllers\Dashboard\MessageController;
use App\Http\Controllers\Dashboard\QuizController;
use App\Http\Controllers\Dashboard\QuestionController;


Route::get("/dashboard/login", [AuthenticationController::class, 'loginPage'])->name("dashboard.loginPage");
Route::post("/dashboard/login", [AuthenticationController::class, 'login'])->name("dashboard.login");
Route::get("/dashboard/logout", [AuthenticationController::class, 'logout'])->name("dashboard.logout");

Route::group(['middleware' => 'authCheck'],function (){
    Route::get("/dashboard/home", [HomeController::class, 'index'])->name("dashboard.home");

    Route::get("/dashboard/about", [AboutController::class, 'index'])->name("dashboard.about");
    Route::post("/dashboard/about/update", [AboutController::class, 'update'])->name("dashboard.about.update");

    Route::get("/dashboard/category/create", [CategoryController::class, 'create'])->name("dashboard.category.create");
    Route::get("/dashboard/categories", [CategoryController::class, 'index'])->name("dashboard.categories");
    Route::post("/dashboard/category/store", [CategoryController::class, 'store'])->name("dashboard.category.store");
    Route::get("/dashboard/category/edit/{id}", [CategoryController::class, 'edit'])->name("dashboard.category.edit");
    Route::post("/dashboard/category/update/{id}", [CategoryController::class, 'update'])->name("dashboard.category.update");
    Route::get("/dashboard/category/delete/{id}", [CategoryController::class, 'delete'])->name("dashboard.category.delete");

    Route::get("/dashboard/quiz/create", [QuizController::class, 'create'])->name("dashboard.quiz.create");
    Route::get("/dashboard/quizzes", [QuizController::class, 'index'])->name("dashboard.quizzes");
    Route::post("/dashboard/quiz/store", [QuizController::class, 'store'])->name("dashboard.quiz.store");
    Route::get("/dashboard/quiz/edit/{id}", [QuizController::class, 'edit'])->name("dashboard.quiz.edit");
    Route::post("/dashboard/quiz/update/{id}", [QuizController::class, 'update'])->name("dashboard.quiz.update");
    Route::get("/dashboard/quiz/delete/{id}", [QuizController::class, 'delete'])->name("dashboard.quiz.delete");

    Route::get("/dashboard/questions/{quiz_id}", [QuestionController::class, 'index'])->name("dashboard.quiz.questions");
    Route::get("/dashboard/questions/create/{quiz_id}", [QuestionController::class, 'create'])->name("dashboard.question.create");
    Route::post("/dashboard/questions/store/{quiz_id}", [QuestionController::class, 'store'])->name("dashboard.question.store");
    Route::get("/dashboard/questions/edit/{question_id}", [QuestionController::class, 'edit'])->name("dashboard.question.edit");
    Route::post("/dashboard/questions/update/{question_id}", [QuestionController::class, 'update'])->name("dashboard.question.update");
    Route::get("/dashboard/questions/delete/{question_id}", [QuestionController::class, 'delete'])->name("dashboard.question.delete");

    Route::post("/dashboard/change-password", [AuthenticationController::class, 'changePassword'])->name("dashboard.change-password");
});
