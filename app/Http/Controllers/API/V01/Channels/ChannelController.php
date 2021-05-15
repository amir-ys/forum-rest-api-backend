<?php

namespace App\Http\Controllers\API\V01\Channels;

use App\Http\Controllers\Controller;
use App\Http\Requests\Channel\ChannelRequest;
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

    public function createChannel(ChannelRequest $request)
    {
        $this->channelRepo->store($request);
        return response()->json(['message' => 'channel created successfully'], Response::HTTP_CREATED);
    }
}
