<?php

namespace App\Http\Controllers\API;
use App\Channel;
use App\Http\Resources\ChannelResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ChannelController extends Controller
{
  //we need to return all the channels
    public function index()
    {
        return ChannelResource::collection(Channel::all());
    }

   //in the store we need to add anew channel to the database
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            "title" => "required|unique:channels"
        ]);

        if ($v->fails()) {
            return response()->json([
                "error" => true,
                "errors" => $v->errors()
            ],422);
        }

        $channel = new Channel(["title" => $request->title]);
        $channel->save();
        return new ChannelResource($channel);
    }


    public function show(Channel $channel)
    {
        return new ChannelResource($channel);
    }


    public function update(Request $request, Channel $channel)
    {
        $v = Validator::make($request->all(), [
            "title" => "required|unique:channels"
        ]);

        if ($v->fails()) {
            return response()->json([
                "error" => true,
                "errors" => $v->errors()
            ],422);
        }
        $channel->title = $request->title;
        $channel->save();

        return new ChannelResource($channel);

    }


    public function destroy(Channel $channel)
    {
        $channel->delete();
        return response()->json([
            "error" => false,
            "message" => "the channel with id: $channel->id successfully been deleted."
        ],200);
    }
}
