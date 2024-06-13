<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Opinion;
use App\Models\UserOpinions;
use Tymon\JWTAuth\Facades\JWTAuth;

class OpinionController extends Controller
{
    public function createOpinion(Request $request)
    {
        $rules = [
            'stars' => 'required|integer|min:1|max:5',
            'opinion_text' => 'nullable|string',
            'userReviewedEmail' => 'required|email|max:255'
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

        $email = $user->email;


        $opinion = new Opinion;
        $opinion->stars = $request->stars;
        $opinion->opinion_text = $request->opinion_text;
        $opinion->approved = false;

        $opinion->save();

        $userGivingReview = User::where('email', $email)->first();
        if (!$userGivingReview) {
            return response()->json([
                'status' => 'error',
                'message' => 'User giving review not found',
            ], 404);
        }

        $userReviewed = User::where('email', $request->userReviewedEmail)->first();
        if (!$userReviewed) {
            return response()->json([
                'status' => 'error',
                'message' => 'User reviewed not found',
            ], 404);
        }


        $userOpinions = new UserOpinions;
        $userOpinions->user_reviewed_id = $userReviewed->id;
        $userOpinions->user_giving_review_id = $userGivingReview->id;
        $userOpinions->opinion_id = $opinion->id;

        $userOpinions->save();

        return response()->json(['message' => 'Opinion created successfully'], 200);
    }


    public function getOpinionsByReviewedEmail(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 404);
        }

        $email = $request->email;

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $opinions = DB::table('approved_user_opinions')
            ->join('users as reviewers', 'approved_user_opinions.user_giving_review_id', '=', 'reviewers.id')
            ->where('user_reviewed_id', $user->id)
            ->select('approved_user_opinions.stars', 'approved_user_opinions.opinion_text', 'reviewers.email as reviewer_email')
            ->get();


        return response()->json($opinions);
    }

    public function getOpinionsByGivingEmail(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'tatus' => 'error',
                'errors' => $validator->errors(),
            ], 404);
        }

        $email = $request->email;

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $opinions = DB::table('approved_user_opinions')
            ->join('users as reviewed', 'approved_user_opinions.user_reviewed_id', '=', 'reviewed.id')
            ->join('opinions', 'approved_user_opinions.opinion_id', '=', 'opinions.id')
            ->where('user_giving_review_id', $user->id)
            ->select('opinions.stars', 'opinions.opinion_text', 'reviewed.email as reviewed_email')
            ->get();

        return response()->json($opinions);
    }
}
