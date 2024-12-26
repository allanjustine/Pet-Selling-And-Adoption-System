<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Category\CategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        if(request()->ajax())
        {
            return DataTables::of(Category::all())
                   ->addIndexColumn()
                   ->addColumn('actions', function($row) {

                    $route_edit = route('admin.categories.edit', $row);

                    $btn = "
                        <div class='dropdown'>
                            <a class='btn btn-sm btn-icon-only text-light' href='#' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            <i class='fas fa-ellipsis-v'></i>
                            </a>
                            <div class='dropdown-menu dropdown-menu-right dropdown-menu-arrow'>

                                <a class='dropdown-item' href='$route_edit' >Edit</a>

                                <a class='dropdown-item' href='javascript:void(0)' onclick='c_destroy($row->id,`admin.categories.destroy`,`.category_dt`)'>Delete</a>
                            </div>
                        </div> ";
    
                    return $btn;
    
                   })
                   ->rawColumns(['actions'])
                   ->make(true);
        }

        return view('admin.category.index');
    }

    public function store(CategoryRequest $request)
    {
       Category::create($request->validated());

       return to_route('admin.categories.index')->with(['success' => 'Category Added Successfully']);
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', [
            'category' => $category
        ]);
    }

    public function update(CategoryRequest $request, Category $category)
    {
       $category->update($request->validated());

       return to_route('admin.categories.index')->with(['success' => 'Category Updated Successfully']);
    }

    public function destroy(Category $category)
    {
        $category->delete();

       return $this->res(['success' => 'Category Deleted Successfully']);
    }
}