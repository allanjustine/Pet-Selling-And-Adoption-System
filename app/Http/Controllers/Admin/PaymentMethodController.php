<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethod\PaymentMethodRequest;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index()
    {
        if(request()->ajax())
        {
            return DataTables::of(PaymentMethod::all())
                   ->addIndexColumn()
                   ->addColumn('actions', function($row) {

                    $btn = "
                        <div class='dropdown'>
                            <a class='btn btn-sm btn-icon-only text-light' href='#' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            <i class='fas fa-ellipsis-v'></i>
                            </a>
                            <div class='dropdown-menu dropdown-menu-right dropdown-menu-arrow'>
                                <a class='dropdown-item' role='button' onclick='c_edit(`#m_payment_method`, `.payment_method_form :input`, [`#m_payment_method_title`, `Edit Payment Method`], [`.btn_add_payment_method`, `.btn_update_payment_method`], $row)'>Edit</a>";

                            if ($row->is_online == false) {
                                $btn .= "
                                        <a class='dropdown-item' href='javascript:void(0)' 
                                        onclick='crud_activate_deactivate($row->id, `admin.payment_methods.update` , `activate`, `.payment_method_dt`, `Activate Payment Method`)'>Activate</a>";
                            } else {
                                $btn .= "
                                        <a class='dropdown-item' href='javascript:void(0)' 
                                        onclick='crud_activate_deactivate($row->id, `admin.payment_methods.update` , `deactivate`, `.payment_method_dt`, `Deactivate Payment Method`)'>Deactivate</a>";
                            }

                     $btn .= "<a class='dropdown-item' href='javascript:void(0)' onclick='c_destroy($row->id,`admin.payment_methods.destroy`,`.payment_method_dt`)'>Delete</a>
                            </div>
                        </div> ";
    
                    return $btn;
    
                   })
                   ->rawColumns(['actions'])
                   ->make(true);
        }

        return view('admin.payment_method.index');
    }

    public function store(PaymentMethodRequest $request)
    {
        PaymentMethod::create($request->validated());

       return $this->res(['success' => 'Payment Method Added Successfully']);
    }

    public function update(PaymentMethodRequest $request, PaymentMethod $payment_method)
    {
        if($request->option)
        {
            // Activate || Deactivate Payment Method
            return $request->option == 'activate' ? $payment_method->update(['is_online' => true]) 
            : $payment_method->update(['is_online' => false]);
        }

        $payment_method->update($request->validated());

       return $this->res(['success' => 'Payment Method Updated Successfully']);
    }

    public function destroy(PaymentMethod $payment_method)
    {
        $payment_method->delete();

       return $this->res(['success' => 'Payment Method Deleted Successfully']);
    }
}