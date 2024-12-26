<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarkAsAdopted\MarkAsAdoptedRequest;
use App\Models\Adoption;
use Illuminate\Http\Request;

class MarkAsAdoptedController extends Controller
{
    public function __invoke(MarkAsAdoptedRequest $request, Adoption $adoption)
    {
        $adoption->update($request->validated() + ['is_adopted' => true]);

        return back()->with([
            'success' => 'Congratulations on marking your pet as adopted! We appreciate your contribution to our community. Thank you for using our app to help find homes for pets in need. Your support furthers our mission to create a better future for animals. Together, we can make a difference!',
        ]);
    }
}