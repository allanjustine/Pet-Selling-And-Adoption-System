<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pet;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\Pet\PetResource;
use App\Mail\PetApprovalUpdate;
use App\Mail\PetRegistrationUpdate;
use Yajra\DataTables\Facades\DataTables;

class PetController extends Controller
{
    public function index(Request $request)
    {
        if(request()->ajax())
        {
            $pets = PetResource::collection(Pet::query()
                ->when($request->filled('category'), fn($query) => $query->where('category_id', $request->category))
                ->with('category', 'breed', 'user', 'media')
                ->get()
            );

            return DataTables::of($pets)
                   ->addIndexColumn()
                   ->addColumn('actions', function($row) {

                    $new_row = collect($row);

                    $route_show = route('admin.pets.show', $new_row['id']);

                    $btn = "
                    <div class='dropdown'>
                        <a class='btn btn-sm btn-icon-only text-light' href='#' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fas fa-ellipsis-v'></i>
                        </a>
                        <div class='dropdown-menu dropdown-menu-right dropdown-menu-arrow'>
                            <a class='dropdown-item' role='button' href='$route_show'>View</a>
                        ";


                        if ($row['status'] == Pet::PENDING) {
                            $btn .= "
                                    <a class='dropdown-item' href='javascript:void(0)' 
                                    onclick='crud_activate_deactivate($new_row[id], `admin.pets.update` , `approve`, `.pet_dt`, `Approve Pet`)'>
                                        Approve Pet
                                    </a>
                                    <a class='dropdown-item' href='javascript:void(0)' 
                                    onclick='crud_activate_deactivate($new_row[id], `admin.pets.update` , `decline`, `.pet_dt`, `Decline Pet`)'>
                                     Decline Pet
                                    </a>
                                    ";
                        } 
    
                        // if ($row['status'] == Pet::DECLINED) {
                        //     $btn .= "
                        //             <a class='dropdown-item' href='javascript:void(0)' 
                        //             onclick='crud_activate_deactivate($new_row[id], `admin.pets.update` , `approve`, `.pet_dt`, `Approve Pet`)'>Approve Pet</a>";
                        // } else {
                        //     $btn .= "
                        //             <a class='dropdown-item' href='javascript:void(0)' 
                        //             onclick='crud_activate_deactivate($new_row[id], `admin.pets.update` , `decline`, `.pet_dt`, `Decline Pet`)'>Decline Pet</a>";
                        // }
    
                        $btn.=    "<a class='dropdown-item' href='javascript:void(0)' onclick='c_destroy($new_row[id],`admin.pets.destroy`,`.pet_dt`)'>Delete</a>
                        </div>
                    </div> ";
    
                    return $btn;
    
                   })
                   ->rawColumns(['actions'])
                   ->make(true);
        }

        return view('admin.pet.index', [
            'categories' => Category::has('pets')->pluck('name', 'id'),
        ]);
    }

    
    public function show(Pet $pet)
    {
        return view('admin.pet.show', [
            'pet' => $pet->load('user', 'category', 'breed', 'media'),
        ]);
    }

    public function update(Request $request, Pet $pet)
    {
        if($request->option)
        {
            $request->option == 'approve' ? $pet->update(['status' => Pet::APPROVED]) : $pet->update(['status' => Pet::DECLINED]);  //

            Mail::to($pet->user->email)->send(new PetApprovalUpdate(pet:$pet));  // email seller
        }

        return true;
    }

    public function destroy(Pet $pet)
    {
        $pet->delete();

       return $this->res(['success' => 'Pet Deleted Successfully']);
    }
}