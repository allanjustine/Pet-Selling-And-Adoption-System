<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Mail\AccountUpdate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Resources\User\UserResource;

class UserController extends Controller
{
    public function index()
    {
        if(request()->ajax())
        {
            $users = UserResource::collection(User::with('role')->where('id', '!=', auth()->id())->get());

            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('actions', function($row)
            {
                $new_row = collect($row);

                $route_edit = route('admin.users.edit', $new_row['id']);

                $btn = "
                <div class='dropdown'>
                    <a class='btn btn-sm btn-icon-only text-light' href='#' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    <i class='fas fa-ellipsis-v'></i>
                    </a>
                    <div class='dropdown-menu dropdown-menu-right dropdown-menu-arrow'>
                        <a class='dropdown-item' role='button' href='$route_edit'>Manage Account</a>
                    ";

                    // if ($row['is_activated'] == false) {
                    //     $btn .= "
                    //             <a class='dropdown-item' href='javascript:void(0)' 
                    //             onclick='crud_activate_deactivate($new_row[id], `admin.users.update` , `activate`, `.user_dt`, `Activate this Account`)'>Activate Account</a>";
                    // } else {
                    //     $btn .= "
                    //             <a class='dropdown-item' href='javascript:void(0)' 
                    //             onclick='crud_activate_deactivate($new_row[id], `admin.users.update` , `deactivate`, `.user_dt`, `Deactivate this Account`)'>Deactivate Account</a>";
                    // }

                    $btn.=    "<a class='dropdown-item' href='javascript:void(0)' onclick='c_destroy($new_row[id],`admin.users.destroy`,`.user_dt`)'>Delete</a>
                    </div>
                </div> ";

               return $btn;
           })
            ->rawColumns(['actions'])
            ->make(true);
        }

        return view('admin.user.index');
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', [
            'user' => $user,
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        //dd($request->validated());
        $user->update($request->validated());

        Mail::to($user)->send(new AccountUpdate(user: $user, request: $request->validated()));  // email user

        return to_route('admin.users.index')->with(['success' => 'Account Updated Successfully']);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return $this->res(['success' => 'User Acount Deleted Successfully']);
    }
}