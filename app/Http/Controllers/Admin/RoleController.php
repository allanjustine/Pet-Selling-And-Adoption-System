<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function __invoke()
    {
        if(request()->ajax())
        {
            return DataTables::of(Role::all())->make(true);
        }

        return view('admin.role.index');
    }

}
