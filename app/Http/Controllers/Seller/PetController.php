<?php

namespace App\Http\Controllers\Seller;

use App\Models\Pet;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pet\SellerPetRequest;
use App\Models\Breed;
use App\Services\ImageUploadService;

class PetController extends Controller
{
    public function index(Request $request)
    {
        return view('seller.pet.index', [
            'pets' => Pet::query()
            ->when($request->filled('category'), fn($query) => $query->where('category_id', $request->category_id))
            ->with('category', 'media')
            ->whereBelongsTo(auth()->user())
            ->paginate(10),
            'categories' => Category::pluck('name', 'id'),
        ]);
    }

    public function create()
    {
        return view('seller.pet.create', [
            'categories' => Category::with('breeds')->get(),
        ]);
    }

    public function store(SellerPetRequest $request, ImageUploadService $service)
    {
        $pet = auth()->user()->pets()->create($request->validated());
        
        if($request->avatar)
        {
            $service->handleImageUpload(model:$pet, images: $request->avatar, collection:'avatar_image', conversion_name:'avatar', action:'create');
        }

        if($request->featured_photos)
        {
            $service->handleImageUpload(model:$pet, images: $request->featured_photos, collection:'featured_photos', conversion_name:'card', action:'create');
        }

        if($request->proof_of_ownership)
        {
            $service->handleImageUpload(model:$pet, images: $request->proof_of_ownership, collection:'proof_of_ownership', conversion_name:'card', action:'create');
        }

        // handle the vaccination and deworming file upload

        if($request->has_vaccination == true && $request->vaccination_history_image)
        {
            $service->handleImageUpload(model:$pet, images: $request->vaccination_history_image, collection:'vaccination_history', conversion_name:'card', action:'create');
            
        }

        if($request->has_deworming == true && $request->deworming_history_image)
        {
            $service->handleImageUpload(model:$pet, images: $request->deworming_history_image, collection:'deworming_history', conversion_name:'card', action:'create');
            
        }

        return to_route('seller.pets.index')->with(['success' => 'Pet Added Successfully. You will receive an email update once the admin has made a decision regarding to your post. In the meantime, feel free to explore our website for more exciting pet-related content and services. We appreciate your trust and look forward to helping you find the perfect home for your furry friend!']);
    }

    public function show(Pet $pet)
    {
        return view('seller.pet.show', [
            'pet' => $pet->load('user', 'category', 'breed', 'likes', 'comments', 'media'),
        ]);
    }


    public function edit(Pet $pet)
    {
        return view('seller.pet.edit', [
            'pet' => $pet,
            'categories' => Category::all(),
            'breeds' => Breed::pluck('name', 'id'),
        ]);
    }

    public function update(SellerPetRequest $request, ImageUploadService $service, Pet $pet)
    {

        $pet->update($request->validated());

        if($request->avatar)
        {
            $service->handleImageUpload(model:$pet, images: $request->avatar, collection:'avatar_image', conversion_name:'avatar', action:'update');
        }

        if($request->featured_photos)
        {
            $service->handleImageUpload(model:$pet, images: $request->featured_photos, collection:'featured_photos', conversion_name:'card', action:'update');
        }

        // handle the vaccination and deworming file upload

        if($request->has_vaccination == true && $request->vaccination_history_image)
        {
            $service->handleImageUpload(model:$pet, images: $request->vaccination_history_image, collection:'vaccination_history', conversion_name:'card', action:'update');
            
        }

        if($request->has_deworming == true && $request->deworming_history_image)
        {
            $service->handleImageUpload(model:$pet, images: $request->deworming_history_image, collection:'deworming_history', conversion_name:'card', action:'update');
            
        }

        return to_route('seller.pets.index')->with(['success' => 'Pet Updated Successfully']);
    }

    public function destroy(Pet $pet)
    {
        $pet->delete();

       return back()->with(['success' => 'Pet Deleted Successfully']);
    }
}