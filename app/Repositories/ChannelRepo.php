<?php


namespace App\Repositories;


use App\Models\Channel;
use Illuminate\Support\Str;

class ChannelRepo
{


    public function all()
    {
        return Channel::all();
    }

    public function store($request)
    {
        return Channel::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
    }

    public function findById($id)
    {
        return Channel::findOrFail($id);
    }

    public function update($request)
    {
        return $this->findById($request->id)->update([
            'name' => $request->name
        ]);
    }
}
