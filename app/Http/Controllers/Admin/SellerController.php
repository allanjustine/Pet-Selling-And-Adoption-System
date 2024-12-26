<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SellerAccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Seller\SellerRequest;
use App\Http\Resources\Seller\SellerResource;
use App\Mail\SellerAccountUpdate;

class SellerController extends Controller
{
    public function index()
    {
        if(request()->ajax())
        {
            $sellers = SellerResource::collection(SellerAccount::with('user.media') ->get());

            return DataTables::of($sellers)
                   ->addIndexColumn()
                   ->addColumn('actions', function($row) {

                    $new_row = collect($row);

                    $route_show = route('admin.sellers.show', $new_row['id']);
                    // <a class='dropdown-item' role='button' href='$route_show'>View</a>

                    
                    $btn = "
                    <div class='dropdown'>
                        <a class='btn btn-sm btn-icon-only text-light' href='#' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fas fa-ellipsis-v'></i>
                        </a>
                        <div class='dropdown-menu dropdown-menu-right dropdown-menu-arrow'>
                            <a class='dropdown-item' role='button' href='$route_show'>View</a>
                        ";
                        $btn.=    "<a class='dropdown-item' href='javascript:void(0)' onclick='c_destroy($new_row[id],`admin.sellers.destroy`,`.seller_dt`)'>Delete</a>
                        </div>
                    </div> ";
    
                    return $btn;
    
                   })
                   ->rawColumns(['actions'])
                   ->make(true);
        }
        
        return view('admin.seller.index');
    }

    public function show(SellerAccount $seller)
    {
        return view('admin.seller.show', [
            'seller' => $seller->load('user.avatar', 'media'),
        ]);
    }
    
    public function update(SellerRequest $request, SellerAccount $seller)
    {
        //dd($request->validated());
        $seller->update($request->validated());

        Mail::to($seller->user->email)->send(new SellerAccountUpdate(seller: $seller, request: $request->validated()));  // email the seller account

        return to_route('admin.sellers.index')->with(['success' => 'Seller Account Updated Successfully']);
    }


    public function destroy(SellerAccount $seller)
    {
        $seller->delete();

       return $this->res(['success' => 'Seller Deleted Successfully']);
    }
}