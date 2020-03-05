<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function create(Request $request){

        $input = $request->all();
//        return response()->json(['comment' => $input]);
        $id = $input['idTask'];
        $text = $input['data']['text'];

        $comment = new Comment();
        $comment->task_id = $id;
        $comment->user_id = 0;
        $comment->text = $text;
        $comment->save();

        return response()->json(['comment' => $comment]);
    }
}
