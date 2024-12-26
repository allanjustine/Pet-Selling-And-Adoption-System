@extends('layouts.admin.app')

@section('title', 'Admin | Orders')

@section('content')

    {{-- CONTAINER --}}
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form>
                    <div class="form-group">
                        <select class="form-control form-control-sm" onchange="filterOrderByStatus(this)">
                            <option value="" disabled selected>--- All Status ---
                            </option>
                            <option value="0">Pending</option>
                            <option value="1">Approved</option>
                            <option value="2">Declined</option>
                            <option value="3">To be Delivered</option>
                            <option value="4">Delivered</option>
                        </select>
                    </div>
                </form>

                <div class="card">
                    <div class="card-body">
                        <div class="float-right mb-3">
                            <a href="{{ route('admin.print.handle') }}?records=order" class="btn btn-sm btn-primary">Print
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-flush table-hover order_dt">
                                <caption>List of Order</caption>
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Transaction No.</th>
                                        <th>Reference No.</th>
                                        <th>Payment Type</th>
                                        <th>Pet</th>
                                        <th>Breed</th>
                                        <th>Buyer</th>
                                        <th>Status</th>
                                        <th>Updated At</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Display orders --}}
                                </tbody>
                            </table>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End CONTAINER --}}

@endsection
