<?php


namespace App\Repositories;


use App\Models\Answer;
use App\Models\Thread;

class AnswerRepo
{
    public function findById($id)
    {
        return Answer::findOrFail($id);
    }

    public function getAll()
    {
        return Answer::query()->latest();
    }

    public function store($values)
    {
       return Thread::query()->findOrFail($values->thread_id)->answers()->create([
                'content' => $values->content,
                'user_id' => auth()->id()
            ]
        );
    }

    public function update($values, $id)
    {
       return $this->findById($id)->update([
            'content' => $values->content
        ]);
    }

    public function delete($id)
    {
        return $this->findById($id)->delete();
    }

}