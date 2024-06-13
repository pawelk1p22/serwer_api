<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Note;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\UserNotes;
use Tymon\JWTAuth\Facades\JWTAuth;

class NoteController extends Controller
{
    public function createNote(Request $request)
    {
        $rules = [
            'noteTitle' => 'required|string',
            'noteText' => 'required|string',
            'subjectName' => 'required|string',
            'topicName' => 'required|string'
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

        $topic = Topic::where('name', $request->topicName)->first();
        if (!$topic) {
            return response()->json([
                'status' => 'error',
                'message' => 'Topic not found',
            ], 404);
        }

        $subject = Subject::where('name', $request->subjectName)->first();
        if (!$subject) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subject not found',
            ], 404);
        }

        $topicId = $topic->id;
        $subjectId = $subject->id;

        $note = new Note;

        $note->note_title = $request->noteTitle;
        $note->note_text = $request->noteText;
        $note->subject_id = $subjectId;
        $note->topic_id = $topicId;
        $note->approved = false;

        $note->save();


        $userNotes = new userNotes;
        $userNotes->user_id = $user->id;
        $userNotes->note_id = $note->id;

        $userNotes->save();

        return response()->json(['message' => 'Note created successfully'], 200);
    }

    public function getNotesByEmail(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:191',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $email = $request->email;
        $subjectName = $request->subject_name;

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $notes = Note::with(['subject:name,id', 'topic:name,id'])
            ->get();

        return response()->json(['notes' => $notes], 200);
    }

    
    public function getNotesByEmailAndSubject(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:191',
            'subject_name' => 'required|string|max:255', 
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $email = $request->email;
        $subjectName = $request->subject_name;

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $subject = Subject::where('name', $subjectName)->first();

        if (!$subject) {
            return response()->json(['error' => 'Subject not found'], 404);
        }

        $notes = Note::whereHas('subject', function ($query) use ($subject) {
                $query->where('id', $subject->id);
            })
            ->with(['subject:name,id', 'topic:name,id'])
            ->get();

        return response()->json(['notes' => $notes], 200);
    }
    

    public function getNotesByTitle(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 400);
        }
    
        $title = $request->input('title');
        $notes = Note::where('note_title', 'like', '%' . $title . '%')
                    ->where('approved', true)
                    ->with(['subject:id,name', 'topic:id,name'])
                    ->get(['note_title', 'note_text', 'subject_id', 'topic_id']);
    
    
        $notes = $notes->map(function ($note) {
            return [
                'note_title' => $note->note_title,
                'note_text' => $note->note_text,
                'subject_name' => $note->subject->name ?? null,
                'topic_name' => $note->topic->name ?? null,
            ];
        });
    
        return response()->json([
            'status' => 'success',
            'notes' => $notes,
        ], 200);
    }
}
