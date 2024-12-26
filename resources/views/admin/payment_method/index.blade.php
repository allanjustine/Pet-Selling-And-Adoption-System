@extends('layouts.admin.app')

@section('title', 'Admin | Payment Methods')

@section('content')

    {{-- CONTAINER --}}
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a class="float-right btn btn-sm btn-primary me-3" href="javascript:void(0)"
                            onclick="toggle_modal('#m_payment_method', '.payment_method_form', ['#m_payment_method_title','Add Payment Method'], ['.btn_add_payment_method','.btn_update_payment_method'])">Create
                            Payment Method +</a><br><br>
                        <div class="table-responsive">
                            <table class="table table-flush table-hover payment_method_dt">
                                <caption> Payment Methods <i class="fas fa-credit-card ml-1"></i></caption>
                                <thead class="thead-light">
                                    <tr>
                                        <th>Type</th>
                                        <th>Account Name</th>
                                        <th>Account No.</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Display Payment Methods --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End CONTAINER --}}

@endsection
