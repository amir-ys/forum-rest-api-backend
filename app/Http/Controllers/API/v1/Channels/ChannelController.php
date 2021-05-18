<?php

namespace App\Http\Controllers\API\v1\Channels;

use App\Http\Controllers\Controller;
use App\Http\Requests\Channel\ChannelRequest;
use App\Http\Requests\Channel\DeleteChannelRequest;
use App\Repositories\ChannelRepo;
use Illuminate\Http\Response;

class ChannelController extends Controller
{
    private $channelRepo;

    public function __construct(ChannelRepo $channelRepo)
    {
        $this->channelRepo = $channelRepo;
    }

    public function getAllChannelList()
    {
        $channels = $this->channelRepo->all();
        return response()->json($channels, Response::HTTP_OK);
    }

    public function store(ChannelRequest $request)
    {
        $this->channelRepo->store($request);
        return response()->json(['message' => 'channel created successfully'], Response::HTTP_CREATED);
    }

    public function update(ChannelRequest $request)
    {
        $this->channelRepo->update($request);
        return response()->json(['message' => 'channel updated successfully'], Response::HTTP_OK);
    }

    public function destroy(DeleteChannelRequest $request)
    {
        $channel = $this->channelRepo->findById($request->id);
        $channel->delete();
        return \response(['message' => 'channel deleted successfully'] , Response::HTTP_OK);

    }
}
