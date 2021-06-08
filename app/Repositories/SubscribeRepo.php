<?php


namespace App\Repositories;


use App\Models\Subscribe;

class SubscribeRepo
{
    public function getNotifiableUser($threadId)
    {
        return Subscribe::where('thread_id', $threadId)->pluck('user_id')->all();
    }

    public function findById($id)
    {
        return Subscribe::findOrFail($id);
    }

}