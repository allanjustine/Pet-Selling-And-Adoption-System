<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Breed;
use App\Models\Adoption;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdoptionController extends Controller
{
    public function index(Request $request)
    {
        return view('buyer.adoption.index', [
            'adoptions' => Adoption::query()
            ->available()
            ->when($request->filled('category_id'), fn($query) => $query->where('category_id', $request->category_id))
            ->with('category', 'breed', 'user.media','media')
            ->where('user_id', '!=', auth()->id())
            ->latest()
            ->paginate(10),
            'categories' => Category::with('breeds')->get(),
        ]);
    }

    public function show(Adoption $adoption)
    {
        return view('buyer.adoption.show', [
            'adoption' => $adoption->load('user', 'category', 'breed','media'),
        ]);
    }
}