<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Pet;
use App\Models\Breed;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PetController extends Controller
{
    public function index(Request $request)
    {
        return view('buyer.pet.index', [
            'pets' => Pet::query()
            ->when($request->filled('category_id'), fn($query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('breed_id'), fn($query) => $query->where('breed_id', $request->breed_id))
            ->doesntHave('pending_order')
            ->available()
            ->with([
                'category', 
                'breed', 
                'likes', 
                'comments', 
                'media', 
                'user' => fn($query) => $query->with('seller_account', 'media')
            ])
            ->where('user_id', '!=', auth()->id())
            ->latest()
            ->paginate(10)
            ->withQueryString(),
            'categories' => Category::with('breeds')->get(),
        ]);
    }

    public function show(Pet $pet)
    {
        return view('buyer.pet.show', [
            'pet' => $pet->load('user', 'category', 'breed', 'likes', 'comments', 'media'),
        ]);
    }

}