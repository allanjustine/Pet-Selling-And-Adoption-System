<?php

namespace App\Http\Controllers\Admin;

use App\Models\Adoption;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\Adoption\AdoptionResource;
use App\Mail\AdoptionApprovalUpdate;

class AdoptionController extends Controller
{
    public function index(Request $request)
    {
        //Mail::to('imdevaes@gmail.com')->send( new PetApprovalUpdate(pet:Pet::find(1)));

        if(request()->ajax())
        {
            $pets = AdoptionResource::collection(Adoption::query()
                ->when($request->filled('category'), fn($query) => $query->where('category_id', $request->category))
                ->with('category', 'breed', 'user', 'media')
                ->get()
            );

            return DataTables::of($pets)
                   ->addIndexColumn()
                   ->addColumn('actions', function($row) {

                    $new_row = collect($row);

                    $route_show = route('admin.adoptions.show', $new_row['id']);

                    $btn = "
                    <div class='dropdown'>
                        <a class='btn btn-sm btn-icon-only text-light' href='#' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fas fa-ellipsis-v'></i>
                        </a>
                        <div class='dropdown-menu dropdown-menu-right dropdown-menu-arrow'>
                            <a class='dropdown-item' role='button' href='$route_show'>View</a>
                        ";


                        if ($row['status'] == Adoption::PENDING) {
                            $btn .= "
                                    <a class='dropdown-item' href='javascript:void(0)' 
                                    onclick='crud_activate_deactivate($new_row[id], `admin.adoptions.update` , `approve`, `.adoption_dt`, `Approve Pet`)'>
                                        Approve Pet
                                    </a>
                                    <a class='dropdown-item' href='javascript:void(0)' 
                                    onclick='crud_activate_deactivate($new_row[id], `admin.adoptions.update` , `decline`, `.adoption_dt`, `Decline Pet`)'>
                                     Decline Pet
                                    </a>
                                    ";
                        } 
    
                        $btn.=    "<a class='dropdown-item' href='javascript:void(0)' onclick='c_destroy($new_row[id],`admin.adoptions.destroy`,`.adoption_dt`)'>Delete</a>
                        </div>
                    </div> ";
    
                    return $btn;
    
                   })
                   ->rawColumns(['actions'])
                   ->make(true);
        }

        return view('admin.adoption.index', [
            'categories' => Category::has('pets')->pluck('name', 'id'),
        ]);
    }

    
    public function show(Adoption $adoption)
    {
        return view('admin.adoption.show', [
            'adoption' => $adoption->load('user', 'category', 'breed', 'media'),
        ]);
    }

    public function update(Request $request, Adoption $adoption)
    {
        if($request->option)
        {
            $request->option == 'approve' ? $adoption->update(['status' => Adoption::APPROVED]) : $adoption->update(['status' => Adoption::DECLINED]);  //

            Mail::to($adoption->user->email)->send(new AdoptionApprovalUpdate(adoption: $adoption));  // email seller
        }

        return true;
    }

    public function destroy(Adoption $adoption)
    {
        $adoption->delete();

       return $this->res(['success' => 'Pet for Adoption Deleted Successfully']);
    }
}