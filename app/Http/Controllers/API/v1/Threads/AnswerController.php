<?php

namespace App\Http\Controllers\API\v1\Threads;

use App\Http\Controllers\Controller;
use App\Http\Requests\Thread\AnswerRequest;
use App\Repositories\AnswerRepo;
use App\Responses\AjaxResponse;

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

    public function store(AnswerRequest $request)
    {
        $this->answerRepo->store($request);
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
