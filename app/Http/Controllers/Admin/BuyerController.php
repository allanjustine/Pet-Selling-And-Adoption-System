<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Resources\Buyer\BuyerResource;

class BuyerController extends Controller
{
    public function index()
    {
        if(request()->ajax())
        {
            $buyers = BuyerResource::collection(User::byRole('buyer')->with('media') ->get());

            return DataTables::of($buyers)
                   ->addIndexColumn()
                   ->addColumn('actions', function($row) {

                    $new_row = collect($row);

                    $route_show = route('admin.buyers.show', $new_row['id']);
                    // <a class='dropdown-item' role='button' href='$route_show'>View</a>

                    
                    $btn = "
                    <div class='dropdown'>
                        <a class='btn btn-sm btn-icon-only text-light' href='#' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fas fa-ellipsis-v'></i>
                        </a>
                        <div class='dropdown-menu dropdown-menu-right dropdown-menu-arrow'>
                            
                        ";
                        $btn.=    "<a class='dropdown-item' href='javascript:void(0)' onclick='c_destroy($new_row[id],`admin.buyers.destroy`,`.buyer_dt`)'>Delete</a>
                        </div>
                    </div> ";
    
                    return $btn;
    
                   })
                   ->rawColumns(['actions'])
                   ->make(true);
        }
        
        return view('admin.buyer.index');
    }

    public function destroy(User $buyer)
    {
        $buyer->delete();

       return $this->res(['success' => 'Buyer Deleted Successfully']);
    }
}