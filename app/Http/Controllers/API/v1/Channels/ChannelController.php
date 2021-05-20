<?php

namespace App\Http\Controllers\API\v1\Channels;

use App\Http\Controllers\Controller;
use App\Http\Requests\Channel\ChannelRequest;
use App\Http\Requests\Channel\DeleteChannelRequest;
use App\Models\Channel;
use App\Models\Permission;
use App\Repositories\ChannelRepo;
use App\Responses\AjaxResponse;
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
        return AjaxResponse::SendData($channels);
    }

    public function store(ChannelRequest $request)
    {
        $this->authorize('store' , Channel::class);
        $this->channelRepo->store($request);
        return AjaxResponse::created('channel created successfully');
    }

    public function update(ChannelRequest $request)
    {
        $this->authorize('update' , Channel::class);
        $this->channelRepo->update($request);
        return AjaxResponse::ok('channel updated successfully');
    }

    public function destroy(DeleteChannelRequest $request)
    {
        $this->authorize('delete' , Channel::class);
        $channel = $this->channelRepo->findById($request->id);
        $channel->delete();
        return AjaxResponse::ok('channel deleted successfully');
    }
}
