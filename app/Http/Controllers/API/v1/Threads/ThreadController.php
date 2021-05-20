<?php

namespace App\Http\Controllers\API\v1\Threads;

use App\Http\Controllers\Controller;
use App\Http\Requests\Thread\ThreadRequest;
use App\Repositories\ThreadRepo;
use App\Responses\AjaxResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class ThreadController extends Controller
{

    private $threadRepo;

    public function __construct(ThreadRepo $threadRepo)
    {
        $this->threadRepo = $threadRepo;
    }

    public function index()
    {
        $threads = $this->threadRepo->getAvailableThreads();
        return \response()->json($threads, Response::HTTP_OK);
    }

    public function show($slug)
    {
        $thread = $this->threadRepo->findThreadBySlug($slug);
        return response()->json($thread, Response::HTTP_OK);
    }

    public function store(ThreadRequest $request)
    {
        $this->threadRepo->store($request);
        return AjaxResponse::created('thread created successfully');
    }

    public function update(ThreadRequest $request, $threadId)
    {
        $this->authorize('update', $this->threadRepo->findById($threadId));
        $this->threadRepo->update($request, $threadId);
        return AjaxResponse::ok('thread updated successfully');
    }

    public function destroy($id)
    {
        $this->authorize('delete', $this->threadRepo->findById($id));
        $this->threadRepo->delete($id);
        return AjaxResponse::ok('thread deleted successfully ');
//
    }
}
