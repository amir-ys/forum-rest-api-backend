<?php


namespace App\Http\Controllers\API\v1\Threads;


use App\Http\Controllers\Controller;
use App\Models\Thread;
use App\Responses\AjaxResponse;

class SubscribeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['user_block']);
    }

    public function subscribe(Thread $thread)
    {
        auth()->user()->subscribes()->create([
            'thread_id' => $thread->id
        ]);
        return AjaxResponse::ok('thread subscribe successfully');
    }

    public function unSubscribe(Thread $thread)
    {
        auth()->user()->subscribes()->where('thread_id', $thread->id)->delete();
        return AjaxResponse::ok('thread unsubscribe successfully');
    }

}