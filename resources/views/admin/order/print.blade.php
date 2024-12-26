@extends('layouts.print.app')

@section('content')
    <div class="container mt-5">
        <a href="{{ route('admin.orders.index') }}">
            <img class="img-fluid d-block mx-auto" src="{{ asset('img/logo/logo.png') }}" width="150" alt="logo">
        </a>
        <br>
        <h3 class="text-center">Order Record</h3> <br>
        <form class="d-print-none" action="{{ route('admin.print.handle') }}" method="GET">
            <div class="input-group">
                <input type="hidden" name="records" value="order">
                <input type="hidden" name="execute" value="1">
                <select class="form-control" name="qty">
                    <option value="">--- All Status ---
                    </option>
                    <option value="0">Pending</option>
                    <option value="1">Approved</option>
                    <option value="2">Declined</option>
                    <option value="3">To be Delivered</option>
                    <option value="4">Delivered</option>
                </select>
                <select class="form-control" name="rows">
                    <option value="{{ \App\Models\order::count() }}">--- All Rows--- </option>
                    <option value="10" @if (request('rows') == '10') selected @endif>10</option>
                    <option value="50" @if (request('rows') == '50') selected @endif>50</option>
                    <option value="100" @if (request('rows') == '100') selected @endif>100</option>
                    <option value="150" @if (request('rows') == '150') selected @endif>150</option>
                    <option value="200" @if (request('rows') == '200') selected @endif>200</option>
                </select>
                <div class="input-group-prepend">
                    <button type="submit" class="btn btn-warning text-white">Print Record</button>
                </div>
            </div>
        </form>
        <br>
        <table class="table table-flush table-hover">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Transaction No.</th>
                    <th>Reference No.</th>
                    <th>Payment Type</th>
                    <th>Pet</th>
                    <th>Breed</th>
                    <th>Category</th>
                    <th>Buyer</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $order->transaction_no }}</td>
                        <td>{{ $order->reference_no }}</td>
                        <td>{{ $order->payment_type }}</td>
                        <td>{{ $order->pet->name }}</td>
                        <td>{{ $order->pet->breed->name }}</td>
                        <td>{{ $order->pet->category->name }}</td>
                        <td>{{ $order->pet->user->full_name }}</td>
                        <td>{!! strip_tags(handleOrderStatus($order->status)) !!}</td>
                        <td>{{ formatDate($order->created_at, 'default') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Records Not Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <br><br>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            const url = new URL(location.href);
            const execute = url.searchParams.get('execute');

            execute == true ? print() : false
        });
        onafterprint = function() {
            window.location.href = @json(route('admin.orders.index'));
        }
    </script>
@endsection
