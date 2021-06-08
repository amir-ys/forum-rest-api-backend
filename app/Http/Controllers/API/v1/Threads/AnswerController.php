<?php

namespace App\Http\Controllers\API\v1\Threads;

use App\Http\Controllers\Controller;
use App\Http\Requests\Thread\AnswerRequest;
use App\Models\Subscribe;
use App\Models\Thread;
use App\Notifications\NewReplySubmitted;
use App\Repositories\AnswerRepo;
use App\Repositories\SubscribeRepo;
use App\Repositories\ThreadRepo;
use App\Repositories\UserRepo;
use App\Responses\AjaxResponse;
use Illuminate\Support\Facades\Notification;

class AnswerController extends Controller
{
    private $answerRepo;

    public function __construct(AnswerRepo $answerRepo)
    {

        $this->answerRepo = $answerRepo;
    }

    public function index()
    {
        $answers = $this->answerRepo->getAll();
        return AjaxResponse::SendData($answers);
    }

    public function store(AnswerRequest $request, SubscribeRepo $subscribeRepo, ThreadRepo $threadRepo, UserRepo $userRepo)
    {
        $this->answerRepo->store($request);
        $notifiableUser = $subscribeRepo->getNotifiableUser($request->thread_id);
        Notification::send($userRepo->findById($notifiableUser),
            new  NewReplySubmitted($threadRepo->findById($request->thread_id)));
        if (($threadRepo->findById($request->thread_id))->user_id !== auth()->id()) {
            auth()->user()->score = auth()->user()->score + 10;
            auth()->user()->save();
        }
        return AjaxResponse::created('answers submitted successfully');
    }

    public function update(AnswerRequest $request, $answerId)
    {
        $this->authorize('update', $this->answerRepo->findById($answerId));
        $this->answerRepo->update($request, $answerId);
        return AjaxResponse::ok('answers submitted successfully');
    }

    public function destroy($answerId)
    {
        $this->authorize('delete', $this->answerRepo->findById($answerId));
        $this->answerRepo->delete($answerId);
        return AjaxResponse::ok('answer deleted successfully');
    }
}
