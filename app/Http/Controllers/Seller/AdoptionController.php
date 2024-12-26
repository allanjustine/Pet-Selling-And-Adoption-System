<?php

namespace App\Http\Controllers\Seller;

use App\Models\Breed;
use App\Models\Adoption;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ImageUploadService;
use App\Http\Requests\Adoption\SellerAdoptionRequest;
use App\Models\User;

class AdoptionController extends Controller
{
    public function index(Request $request)
    {
        return view('seller.adoption.index', [
            'adoptions' => Adoption::query()
            ->when($request->filled('category'), fn($query) => $query->where('category_id', $request->category))
            ->with('category', 'media')
            ->whereBelongsTo(auth()->user())
            ->paginate(10),
            'categories' => Category::pluck('name', 'id'),
        ]);
    }

    public function create()
    {
        return view('seller.adoption.create', [
            'categories' => Category::all(),
            'breeds' => Breed::pluck('name', 'id'),
        ]);
    }

    public function store(SellerAdoptionRequest $request, ImageUploadService $service)
    {
        $adoption = auth()->user()->adoptions()->create($request->validated());
        
        if($request->avatar)
        {
            $service->handleImageUpload(model:$adoption, images: $request->avatar, collection:'avatar_image', conversion_name:'avatar', action:'create');
        }

        if($request->featured_photos)
        {
            $service->handleImageUpload(model:$adoption, images: $request->featured_photos, collection:'featured_photos', conversion_name:'card', action:'create');
        }
        
        if($request->proof_of_ownership)
        {
            $service->handleImageUpload(model:$adoption, images: $request->proof_of_ownership, collection:'proof_of_ownership', conversion_name:'card', action:'create');
        }

         // handle the vaccination and deworming file upload

         if($request->has_vaccination == true && $request->vaccination_history_image)
         {
             $service->handleImageUpload(model:$adoption, images: $request->vaccination_history_image, collection:'vaccination_history', conversion_name:'card', action:'create');
             
         }
 
         if($request->has_deworming == true && $request->deworming_history_image)
         {
             $service->handleImageUpload(model:$adoption, images: $request->deworming_history_image, collection:'deworming_history', conversion_name:'card', action:'create');
             
         }

        return to_route('seller.adoptions.index')->with(['success' => 'Pet for Adoption Added Successfully. You will receive an email update once the admin has made a decision regarding to your post. In the meantime, feel free to explore our website for more exciting pet-related content and services. We appreciate your trust and look forward to helping you find the perfect home for your furry friend!']);
    }

    public function show(Adoption $adoption)
    {
        return view('seller.adoption.show', [
            'adoption' => $adoption->load('user', 'category', 'breed', 'media'),
            'buyers' => User::active()->byRole('buyer')->get(),
        ]);
    }


    public function edit(Adoption $adoption)
    {
        return view('seller.adoption.edit', [
            'adoption' => $adoption,
            'categories' => Category::all(),
            'breeds' => Breed::pluck('name', 'id'),
        ]);
    }

    public function update(SellerAdoptionRequest $request, ImageUploadService $service, Adoption $adoption)
    {
        $adoption->update($request->validated());

        if($request->avatar)
        {
            $service->handleImageUpload(model:$adoption, images: $request->avatar, collection:'avatar_image', conversion_name:'avatar', action:'update');
        }

        if($request->featured_photos)
        {
            $service->handleImageUpload(model:$adoption, images: $request->featured_photos, collection:'featured_photos', conversion_name:'card', action:'update');
        }

         // handle the vaccination and deworming file upload

         if($request->has_vaccination == true && $request->vaccination_history_image)
         {
             $service->handleImageUpload(model:$adoption, images: $request->vaccination_history_image, collection:'vaccination_history', conversion_name:'card', action:'update');
             
         }
 
         if($request->has_deworming == true && $request->deworming_history_image)
         {
             $service->handleImageUpload(model:$adoption, images: $request->deworming_history_image, collection:'deworming_history', conversion_name:'card', action:'update');
             
         }

        return to_route('seller.adoptions.index')->with(['success' => 'Pet for Adoption Updated Successfully']);
    }

    public function destroy(Adoption $adoption)
    {
        $adoption->delete();

       return back()->with(['success' => 'Pet for Adoption Deleted Successfully']);
    }
}