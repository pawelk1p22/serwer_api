<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Opinion;
use App\Models\UserOpinions;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Section;
use App\Models\TutoringSession;
use Tymon\JWTAuth\Facades\JWTAuth;

class TutoringSessionController extends Controller
{
    public function createTutoringSession(Request $request)
    {
        $rules = [
            'subject_name' => 'required|string',
            'section_name' => 'required|string',
            'topic_name' => 'required|string',
            'about' => 'required|string'
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

        $subject = Subject::where('name', $request->subject_name)->first();
        $section = Section::where('name', $request->section_name)->first();
        $topic = Topic::where('name', $request->topic_name)->first();

        $tutoringSession = new TutoringSession();
        $tutoringSession->tutor_id = $user->id;
        $tutoringSession->subject_id = $subject->id;
        $tutoringSession->section_id = $section->id;
        $tutoringSession->topic_id = $topic->id;
        $tutoringSession->about = $request->about;

        $tutoringSession->save();

        return response()->json(['message' => 'Tutoring session created successfully'], 200);
    }
}
