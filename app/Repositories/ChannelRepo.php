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
}
