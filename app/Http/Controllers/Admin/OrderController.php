<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Http\Requests\Order\AdminOrderRequest;

class OrderController extends Controller
{
    public function __construct()
    {
        DB::statement("SET SQL_MODE=''"); // set the strict to false
    }
    
    public function index(Request $request)
    {
        if(request()->ajax())
        {
            $orders = OrderResource::collection(Order::query()
            ->when($request->has('status'), fn($query) => $query->where('status', $request->status))
            ->with('user', 'pet.breed')
            ->groupBy('transaction_no')
            ->get());

            return DataTables::of($orders)
                   ->addIndexColumn()
                   ->addColumn('actions', function($row) {

                    $new_row = collect($row);

                    $route_show  = route('admin.orders.show', $new_row['id']);

                    $btn = "
                        <div class='dropdown'>
                            <a class='btn btn-sm btn-icon-only text-light' href='#' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            <i class='fas fa-ellipsis-v'></i>
                            </a>
                            <div class='dropdown-menu dropdown-menu-right dropdown-menu-arrow'>

                                <a class='dropdown-item' href='$route_show'>View</a>
                            </div>
                        </div> ";
    
                    return $btn;
    
                   })
                   ->rawColumns(['actions'])
                   ->make(true);
        }

        return view('admin.order.index');
    }

    public function create()
    {
        return view('admin.order.create', [
            'users' => User::byRole('buyer')->get(),
        ]);
    }

    public function show(Order $order)
    {
        return view('admin.order.show', [
            'order' => $order->load([
                'pet' => fn($query) => $query->with('media', 'category', 'breed'), 
                'additional_payment' => fn($query) => $query->with('media', 'payment_method'),
                'payment_method',
                'user.barangay',
            ]),
        ]);
    }

    public function update(AdminOrderRequest $request, OrderService $service, Order $order)
    {
        $service->handleOrder(request:$request->validated(), order: Order::with('user')->where('transaction_no', $order->transaction_no)->first());

        return back()->with(['success' => "Order Status Updated Successfully"]);
    }

}