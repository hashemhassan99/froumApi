<?php

namespace App\Http\Controllers\API;

use App\Discussion;
use App\Http\Controllers\Controller;
use App\Http\Resources\DiscussionResource;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;

class DiscussionController extends Controller
{

    public function index()
    {
        return DiscussionResource::collection(Discussion::all());
    }


    public function store(Request $request)
    {
        $v = Validator::make($request->all(),[
            'title' => 'required|unique:discussions',
            'contentt' => 'required'
        ]);
        if ($v->fails()){
            return response()->json([
                'error' => true,
                'errors' => $v->errors()
            ],422);
        }
        $discussion = new Discussion([
            'title'=>$request->title,
            'contentt' => $request->contentt,
            "slug" => Str::slug($request->title,"-"),
            "user_id" => $request->user_id,
            "channel_id" => $request->channel_id

        ]);
        $discussion->save();

        return new DiscussionResource($discussion);

    }


    public function show($slug)
    {
      $discussion =Discussion::where('slug',$slug)->firstOrfail();
        return new DiscussionResource($discussion);
    }


    public function update(Request $request, Discussion $discussion)
    {
        $v = Validator::make($request->all(), [
            "title" => "required|unique:discussions",
            "content" => "required"
        ]);

        if ($v->fails()) {
            return response()->json([
                "error" => true,
                "errors" => $v->errors()
            ],422);
        }

        $discussion->title = $request->title;
        $discussion->contentt = $request->contentt;
        $discussion->slug = Str::slug($request->title,"-");
        $discussion->channel_id= $request->channel_id;

        $discussion->save();
        return new DiscussionResource($discussion);

    }


    public function destroy(Discussion $discussion)
    {
        $discussion->delete();

        return response()->json(null, 204);
    }
}
