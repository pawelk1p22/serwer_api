<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Competency;
class UserController extends Controller
{



    //        _          _          _                                        
    //    __| |   ___  | |   ___  | |_    ___     _   _   ___    ___   _ __ 
    //   / _` |  / _ \ | |  / _ \ | __|  / _ \   | | | | / __|  / _ \ | '__|
    //  | (_| | |  __/ | | |  __/ | |_  |  __/   | |_| | \__ \ |  __/ | |   
    //   \__,_|  \___| |_|  \___|  \__|  \___|    \__,_| |___/  \___| |_|   
    public function deleteUser(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }


    //                          _           _                                         _   _ 
    //     _   _   _ __     __| |   __ _  | |_    ___      ___   _ __ ___     __ _  (_) | |
    //    | | | | | '_ \   / _` |  / _` | | __|  / _ \    / _ \ | '_ ` _ \   / _` | | | | |
    //    | |_| | | |_) | | (_| | | (_| | | |_  |  __/   |  __/ | | | | | | | (_| | | | | |
    //     \__,_| | .__/   \__,_|  \__,_|  \__|  \___|    \___| |_| |_| |_|  \__,_| |_| |_|
    //            |_|                                                                      
    public function updateEmail(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255',
            'newEmail' => 'required|email|max:255|unique:users,email'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        $user->email = $request->newEmail;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Email updated successfully'
        ], 200);
    }

    //                          _           _                                                                        _ 
    //     _   _   _ __     __| |   __ _  | |_    ___     _ __     __ _   ___   ___  __      __   ___    _ __    __| |
    //    | | | | | '_ \   / _` |  / _` | | __|  / _ \   | '_ \   / _` | / __| / __| \ \ /\ / /  / _ \  | '__|  / _` |
    //    | |_| | | |_) | | (_| | | (_| | | |_  |  __/   | |_) | | (_| | \__ \ \__ \  \ V  V /  | (_) | | |    | (_| |
    //     \__,_| | .__/   \__,_|  \__,_|  \__|  \___|   | .__/   \__,_| |___/ |___/   \_/\_/    \___/  |_|     \__,_|
    //            |_|                                    |_|                                                              
    public function updatePassword(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255',
            'newPassword' => 'required|min:64|max:64',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        $user->email = $request->newPassword;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Password updated successfully'
        ], 200);
    }


    //                          _           _               __   _                _                                        
    //     _   _   _ __     __| |   __ _  | |_    ___     / _| (_)  _ __   ___  | |_     _ __     __ _   _ __ ___     ___ 
    //    | | | | | '_ \   / _` |  / _` | | __|  / _ \   | |_  | | | '__| / __| | __|   | '_ \   / _` | | '_ ` _ \   / _ \
    //    | |_| | | |_) | | (_| | | (_| | | |_  |  __/   |  _| | | | |    \__ \ | |_    | | | | | (_| | | | | | | | |  __/
    //     \__,_| | .__/   \__,_|  \__,_|  \__|  \___|   |_|   |_| |_|    |___/  \__|   |_| |_|  \__,_| |_| |_| |_|  \___|
    //            |_|                                                                                                     
    public function updateFirstName(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255',
            'newFirstName' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        $user->first_name = $request->newFirstName;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'First name updated successfully'
        ], 200);
    }

    //                          _           _              _                 _                                        
    //     _   _   _ __     __| |   __ _  | |_    ___    | |   __ _   ___  | |_     _ __     __ _   _ __ ___     ___ 
    //    | | | | | '_ \   / _` |  / _` | | __|  / _ \   | |  / _` | / __| | __|   | '_ \   / _` | | '_ ` _ \   / _ \
    //    | |_| | | |_) | | (_| | | (_| | | |_  |  __/   | | | (_| | \__ \ | |_    | | | | | (_| | | | | | | | |  __/
    //     \__,_| | .__/   \__,_|  \__,_|  \__|  \___|   |_|  \__,_| |___/  \__|   |_| |_|  \__,_| |_| |_| |_|  \___|
    //            |_|                                                                                                
    public function updateLastName(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255',
            'newLastName' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        $user->last_name = $request->newLastName;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Last name updated successfully'
        ], 200);
    }

    //                          _           _                      _                       _   
    //     _   _   _ __     __| |   __ _  | |_    ___      __ _  | |__     ___    _   _  | |_ 
    //    | | | | | '_ \   / _` |  / _` | | __|  / _ \    / _` | | '_ \   / _ \  | | | | | __|
    //    | |_| | | |_) | | (_| | | (_| | | |_  |  __/   | (_| | | |_) | | (_) | | |_| | | |_ 
    //     \__,_| | .__/   \__,_|  \__,_|  \__|  \___|    \__,_| |_.__/   \___/   \__,_|  \__|
    //            |_|                                                                            
    public function updateAbout(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255',
            'newAbout' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        $user->about = $request->newAbout;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'About updated successfully'
        ], 200);
    }

    //                          _           _                     _                     
    //     _   _   _ __     __| |   __ _  | |_    ___      ___  | |   __ _   ___   ___ 
    //    | | | | | '_ \   / _` |  / _` | | __|  / _ \    / __| | |  / _` | / __| / __|
    //    | |_| | | |_) | | (_| | | (_| | | |_  |  __/   | (__  | | | (_| | \__ \ \__ \
    //     \__,_| | .__/   \__,_|  \__,_|  \__|  \___|    \___| |_|  \__,_| |___/ |___/
    //            |_|                                                                  
    public function updateClass(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255',
            'newClass' => 'required|integer|min:1|max:5',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        $user->class = $request->newClass;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Class updated successfully'
        ], 200);
    }

    public function addCompetencies(Request $request)
    {
        $rules = [
            'competencies' => 'required|array',
            'competencies.*' => 'string|exists:competencies,name',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $token = JWTAuth::parseToken($request->header('Authorization'));

        $user = $token->toUser();


        $competencyIds = Competency::whereIn('name', $request->competencies)->pluck('id')->toArray();


        $user->competencies()->syncWithoutDetaching($competencyIds);

        return response()->json([
            'message' => 'Kompetencje zostały dodane do użytkownika.',
        ]);
    }

    public function getCompetenciesByEmail(Request $request)
    {
        $rules = [
            'email' => 'required|email',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 400);
        }
    
        $token = JWTAuth::parseToken($request->header('Authorization'));
    
        $user = $token->toUser();
    
        $competencies = $user->competencies()->pluck('name')->toArray();

        return response()->json([
            'status' => 'success',
            'competencies' => $competencies,
        ]);
    }

    public function addSubjects(Request $request)
    {
        $rules = [
            'subjects' => 'required|array',
            'subjects.*' => 'string|exists:subjects,name',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $token = JWTAuth::parseToken($request->header('Authorization'));

        $user = $token->toUser();


        $competencyIds = Subject::whereIn('name', $request->subjects)->pluck('id')->toArray();


        $user->competencies()->syncWithoutDetaching($competencyIds);

        return response()->json([
            'message' => 'Kompetencje zostały dodane do użytkownika.',
        ]);
    }

    public function getDataFromToken(Request $request)
    {
        $token = JWTAuth::parseToken($request->header('Authorization'));

        $user = $token->toUser();

        return response()->json([
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'nick' => $user->nick,
            'about' => $user->about,
            'class' => $user->class,
            'is_tutor' => $user->is_tutor,
        ]);
    }
}