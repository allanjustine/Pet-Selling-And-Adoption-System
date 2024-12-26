<?php

namespace App\Http\Controllers\Shared;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pet;

class LikeController extends Controller
{
    public function store(Request $request)
    {
       $like = auth()->user()->likes()->create($request->validate(['pet_id' => 'required']));

       Pet::findOrFail($like['pet_id']);

       return $this->res(['result' => Like::where('pet_id', $request->pet_id)->count()]);
    }

    public function destroy($id)
    {
        Pet::findOrFail($id);

        $like =  Like::where('user_id', auth()->id())->where('pet_id', $id)->first();

        $like->delete();

        return $this->res(['result' => Like::where('pet_id', $id)->count()]);

    }
}