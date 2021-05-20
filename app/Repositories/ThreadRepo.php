<?php


namespace App\Repositories;


use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThreadRepo
{
    public function getAvailableThreads()
    {
        return Thread::whereFlag(true)->get();
    }

    public function findThreadBySlug($slug)
    {
        return Thread::whereFlag(true)->whereSlug($slug)->get();
    }

    public function store($request)
    {
        return Thread::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'user_id' => auth()->id(),
            'channel_id' => $request->channel_id,
        ]);
    }

    public function update($request, $threadId)
    {
        if ($request->has('best_answer_id')) {
            Thread::whereId($threadId)->update([
                'best_answer_id' => $request->best_answer_id
            ]);
        } else {
            Thread::whereId($threadId)->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'user_id' => auth()->id(),
                'channel_id' => $request->channel_id,
            ]);
        }
    }

    public function findById($id)
    {
        return Thread::findOrFail($id);
    }

    public function delete($id)
    {
        $this->findById($id)->delete();
    }

}
