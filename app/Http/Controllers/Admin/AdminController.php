<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Barangay;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\AdminRequest;
use App\Mail\AccountCreated;

class AdminController extends Controller
{
    public function index()
    {
        if(request()->ajax())
        {
            return DataTables::of(User::with('barangay')->byRole('admin')->where('id', '!=', auth()->id())->get())
                   ->addIndexColumn()
                   ->addColumn('actions', function($row) {

                    $route_edit = route('admin.admins.edit', $row);

                    $btn = "
                        <div class='dropdown'>
                            <a class='btn btn-sm btn-icon-only text-light' href='#' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            <i class='fas fa-ellipsis-v'></i>
                            </a>
                            <div class='dropdown-menu dropdown-menu-right dropdown-menu-arrow'>

                                <a class='dropdown-item' href='$route_edit'>Edit</a>

                                <a class='dropdown-item' href='javascript:void(0)' onclick='c_destroy($row->id,`admin.admins.destroy`,`.admin_dt`)'>Delete</a>
                            </div>
                        </div> ";
    
                    return $btn;
    
                   })
                   ->rawColumns(['actions'])
                   ->make(true);
        }

        return view('admin.admin.index', [
            'barangays' => Barangay::pluck('name', 'id'),
        ]);
    }

    public function create()
    {
        return view('admin.admin.create', [
            'barangays' => Barangay::pluck('name', 'id'),
        ]);
    }

    public function store(AdminRequest $request)
    {
        $password = Str::random(10); // the random password;

        $user = User::create($request->validated() + [
            'password' => bcrypt($password),
            'is_activated' => true, 
            'role_id' => Role::ADMIN
        ]);

        Mail::to($user->email)->send(new AccountCreated(user: $user, password: $password)); // notify admin  that the account has successfully created

        return to_route('admin.admins.index')->with(['success' => 'Admin Added Successfully']);
    }

    public function show(User $admin)
    {
        return view('admin.admin.show', [
            'admin' => $admin->load('gasoline_station', 'avatar'),
        ]);
    }
    
    public function edit(User $admin)
    {
        return view('admin.admin.edit', [
            'admin' => $admin,
            'barangays' => Barangay::pluck('name', 'id'),
        ]);
    }

    public function update(AdminRequest $request, User $admin)
    {
        $admin->update($request->validated());

       return to_route('admin.admins.index')->with(['success' => 'Admin Updated Successfully']);
    }
    
    public function destroy(User $admin)
    {
        $admin->delete();

       return $this->res(['success' => 'Admin Deleted Successfully']);
    }
}