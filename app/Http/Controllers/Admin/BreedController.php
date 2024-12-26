<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Breed\BreedRequest;
use App\Models\Breed;
use App\Models\Category;

class BreedController extends Controller
{
    public function index()
    {
        if(request()->ajax())
        {
            return DataTables::of(Breed::with('category')->get())
                   ->addIndexColumn()
                   ->addColumn('actions', function($row) {

                    $btn = "
                        <div class='dropdown'>
                            <a class='btn btn-sm btn-icon-only text-light' href='#' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            <i class='fas fa-ellipsis-v'></i>
                            </a>
                            <div class='dropdown-menu dropdown-menu-right dropdown-menu-arrow'>

                            <a class='dropdown-item' href='javascript:void(0)' onclick='c_edit(`#m_breed`, `.breed_form :input`, [`#m_breed_title`, `Edit Breed`], [`.btn_add_breed`, `.btn_update_breed`], $row, {rname:`admin.breeds.create`, target:[`#d_categories`], column:`name`, r_model:[$row->category]})'>Edit</a>

                                <a class='dropdown-item' href='javascript:void(0)' onclick='c_destroy($row->id,`admin.breeds.destroy`,`.breed_dt`)'>Delete</a>
                            </div>
                        </div> ";
    
                    return $btn;
    
                   })
                   ->rawColumns(['actions'])
                   ->make(true);
        }

        return view('admin.breed.index');
    }

    public function create()
    {
        return $this->res(['results' => Category::all()]);
    }

    public function store(BreedRequest $request)
    {
       Breed::create($request->validated());

       return $this->res(['success' => 'Pet Breed Added Successfully']);
    }

    public function update(BreedRequest $request, Breed $breed)
    {
       $breed->update($request->validated());

       return $this->res(['success' => 'Pet Breed Updated Successfully']);
    }

    public function destroy(Breed $breed)
    {
        $breed->delete();

       return $this->res(['success' => 'Pet Breed Deleted Successfully']);
    }
}