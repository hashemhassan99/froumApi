<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReplyResource;
use App\Reply;
use Illuminate\Http\Request;
use Validator;

class ReplyController extends Controller
{

    public function index()
    {

    }


    public function store(Request $request)
    {

      $v = Validator::make($request->all(),[
        'contentt' => 'required'
      ]);
      if ($v->fails()){
        return response()->json([
          'error' => true,
          'errors' => $v->errors()
        ],422);
      }
      $reply = new Reply([
        'contentt' => $request->contentt,
        "user_id" => $request->user_id,
        "discussion_id" => $request->discussion_id

      ]);
      $reply->save();

      return new ReplyResource($reply);

    }


    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
