<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OpinionController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TutoringSessionController;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\JwtMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware([JwtMiddleware::class])->group(function () {

    //                                          _             _ _           
    //    _   _ ___  ___ _ __    ___ ___  _ __ | |_ _ __ ___ | | | ___ _ __ 
    //   | | | / __|/ _ \ '__|  / __/ _ \| '_ \| __| '__/ _ \| | |/ _ \ '__|
    //   | |_| \__ \  __/ |    | (_| (_) | | | | |_| | | (_) | | |  __/ |   
    //    \__,_|___/\___|_|     \___\___/|_| |_|\__|_|  \___/|_|_|\___|_|   
    Route::post('/user/deleteUser', [UserController::class, 'deleteUser']);
    Route::post('/user/updateEmail', [UserController::class, 'updateEmail']);
    Route::post('/user/updatePassword', [UserController::class, 'updatePassword']);
    Route::post('/user/updateFirstName', [UserController::class, 'updateFirstName']);
    Route::post('/user/updateLastName', [UserController::class, 'updateLastName']);
    Route::post('/user/updateAbout', [UserController::class, 'updateAbout']);
    Route::post('/user/updateClass', [UserController::class, 'updateClass']);

    Route::post('/user/addCompetencies', [UserController::class,'addCompetencies']);
    Route::post('/user/addSubjects', [UserController::class, 'addSubjects']);
    Route::post('/user/getCompetenciesByEmail', [UserController::class,'getCompetenciesByEmail']);

    Route::post('/user/getDataFromToken', [UserController::class, 'getDataFromToken']);


    //               _       _                               _             _ _           
    //    ___  _ __ (_)_ __ (_) ___  _ __     ___ ___  _ __ | |_ _ __ ___ | | | ___ _ __ 
    //   / _ \| '_ \| | '_ \| |/ _ \| '_ \   / __/ _ \| '_ \| __| '__/ _ \| | |/ _ \ '__|
    //  | (_) | |_) | | | | | | (_) | | | | | (_| (_) | | | | |_| | | (_) | | |  __/ |   
    //   \___/| .__/|_|_| |_|_|\___/|_| |_|  \___\___/|_| |_|\__|_|  \___/|_|_|\___|_|   
    //        |_|                                                                        
    Route::post('/opinion/createOpinion', [OpinionController::class, 'createOpinion']);
    Route::post('/opinion/getOpinionsByReviewedEmail', [OpinionController::class, 'getOpinionsByReviewedEmail']);
    Route::post('/opinion/getOpinionsByGivingEmail', [OpinionController::class, 'getOpinionsByGivingEmail']);
 


    //                _                         _             _ _           
    //    _ __   ___ | |_ ___    ___ ___  _ __ | |_ _ __ ___ | | | ___ _ __ 
    //   | '_ \ / _ \| __/ _ \  / __/ _ \| '_ \| __| '__/ _ \| | |/ _ \ '__|
    //   | | | | (_) | ||  __/ | (_| (_) | | | | |_| | | (_) | | |  __/ |   
    //   |_| |_|\___/ \__\___|  \___\___/|_| |_|\__|_|  \___/|_|_|\___|_|   
    //
    Route::post('/note/createNote', [NoteController::class, 'createNote']);
    Route::post('/note/getNotesByEmail', [NoteController::class, 'getNotesByEmail']);
    Route::post('/note/getNotesByEmailAndSubject', [NoteController::class,'getNotesByEmailAndSubject']);

    Route::post('/note/getNotesByTitle', [NoteController::class,'getNotesByTitle']);



    // tutoring controller
    Route::post('/tutoring/createTutoringSession', [TutoringSessionController::class, 'createTutoringSession']);
});

Route::post('/user/login', [ApiController::class, 'authenticate']);
Route::post('/user/register', [ApiController::class, 'register']);
Route::post('/user/logout', [ApiController::class, 'logout']);
Route::post('/user/get_user', [ApiController::class, 'get_user']);
Route::post('/user/validateToken', [ApiController::class, 'validateToken']);
