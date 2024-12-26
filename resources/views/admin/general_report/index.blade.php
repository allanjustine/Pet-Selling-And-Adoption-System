@extends('layouts.admin.app')

@section('title', 'Admin | General Report')

@section('content')
    <!-- Page Content -->
    <div class="container-fluid mt-3">

        <ul class="nav nav-pills nav-fill flex-row" id="tabs-icons-text" role="tablist">
            <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 @if (!request()->query('tab') || request()->query('tab') == 'graphs') active @endif" id="tabs-icons-text-0-tab"
                    data-toggle="tab" href="#tabs-icons-text-0" role="tab" aria-controls="tabs-icons-text-0"
                    aria-selected="true"><i class="fas fa-project-diagram mr-2"></i>Graphs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 @if (request()->query('tab') == 'tables') active @endif"
                    id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab"
                    aria-controls="tabs-icons-text-1" aria-selected="true"><i class="fas fa-table mr-2"></i>Tables</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            {{-- Tab 0 --}}
            <div class="tab-pane fade @if (!request()->query('tab') || request()->query('tab') == 'graphs') show active @endif" id="tabs-icons-text-0"
                role="tabpanel" aria-labelledby="tabs-icons-text-0-tab">
                <br>

                <form class action="{{ route('admin.general_report.index') }}" method="get">
                    <div class="input-group">

                        <div class="input-group-prepend">
                            <select class="form-control form-control-sm" name="category">
                                <option value="">-- All Category --</option>
                                @foreach (\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}" @if (filled(request('category')) && request('category') == $category->id) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <select class="form-control form-control-sm" name="month">
                            <option value="">-- Select Month --</option>
                            @foreach (getOrderMonths() as $month)
                                <option value="{{ $month['month_no'] }}" @if (filled(request('month')) && request('month')) selected @endif>
                                    {{ $month['month'] }}
                                </option>
                            @endforeach
                        </select>

                        <div class="input-group-append">
                            <select class="form-control form-control-sm" name="year">
                                <option value="">-- Select Year --</option>
                                @foreach (getOrderYears() as $year)
                                    <option value="{{ $year['year'] }}" @if (filled(request('month')) && request('month')) selected @endif>
                                        {{ $year['year'] }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="tab" value="graphs">
                            <button class="btn btn-sm btn-primary">Filter</button>

                        </div>
                    </div>
                </form>
                <br>
                {{-- Tab 0 > Row Monthly Sales --}}
                <div class="row">
                    <div class="col-12 col-md-12 d-flex align-self-stretch">
                        <div class="card w-100">
                            <div class="card-header ">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h6 class="text-primary text-uppercase ls-1 mb-1">
                                            Total Monthly Sales
                                        </h6>
                                    </div>
                                    <div class="col-4">
                                        <a class="btn btn-sm btn-outline-primary float-right" href="javascript:void(0)"
                                            onclick='downloadChart("chart_total_monthly_sales", "Total Monthly Sales")'>Download
                                            <i class="fas fa-image ml-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body d-flex and flex-column">
                                <!-- Chart -->
                                <div>
                                    <canvas id="chart_total_monthly_sales"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Tab 0 > Row Monthly Sales --}}

                {{-- Tab 0 > Row Yearly Sales --}}
                <div class="row">
                    <div class="col-12 col-md-12 d-flex align-self-stretch">
                        <div class="card w-100">
                            <div class="card-header ">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h6 class="text-primary text-uppercase ls-1 mb-1">

                                            Total Yearly Sales

                                        </h6>
                                    </div>
                                    <div class="col-4">
                                        <a class="btn btn-sm btn-outline-primary float-right" href="javascript:void(0)"
                                            onclick='downloadChart("chart_total_yearly_sales", "Total Yearly Sales")'>Download
                                            <i class="fas fa-image ml-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body d-flex and flex-column">
                                <!-- Chart -->
                                <div>
                                    <canvas id="chart_total_yearly_sales"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Tab 0 > Row Yearly Sales --}}

                {{-- Tab 0 > Row Pets by Category --}}
                <div class="row">
                    <div class="col-12 col-md-12 d-flex align-self-stretch">
                        <div class="card w-100">
                            <div class="card-header ">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h6 class="text-primary text-uppercase ls-1 mb-1">
                                            Total Pets By Category
                                        </h6>
                                    </div>
                                    <div class="col-4">
                                        <a class="btn btn-sm btn-outline-primary float-right" href="javascript:void(0)"
                                            onclick='downloadChart("chart_total_pets_by_category", "Total pet By Category")'>Download
                                            <i class="fas fa-image ml-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body d-flex and flex-column">
                                <!-- Chart -->
                                <div>
                                    <canvas id="chart_total_pets_by_category"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Tab 0 > Row Pets by Category --}}

                {{-- Tab 0 > Row Top Selling Pet --}}
                <div class="row">
                    <div class="col-12 col-md-12 d-flex align-self-stretch">
                        <div class="card w-100">
                            <div class="card-header ">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h6 class="text-primary text-uppercase ls-1 mb-1">
                                            Top Selling Pet
                                        </h6>
                                    </div>
                                    <div class="col-4">
                                        <a class="btn btn-sm btn-outline-primary float-right" href="javascript:void(0)"
                                            onclick='downloadChart("chart_top_selling_pet", "Top Selling Pet")'>Download
                                            <i class="fas fa-image ml-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body d-flex and flex-column">
                                <!-- Chart -->
                                <div>
                                    <canvas id="chart_top_selling_pet"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Tab 0 > Row Top Selling Pet --}}

                {{-- Tab 0 > Row Top Seller --}}
                <div class="row">
                    <div class="col-12 col-md-12 d-flex align-self-stretch">
                        <div class="card w-100">
                            <div class="card-header ">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h6 class="text-primary text-uppercase ls-1 mb-1">
                                            Top Seller
                                        </h6>
                                    </div>
                                    <div class="col-4">
                                        <a class="btn btn-sm btn-outline-primary float-right" href="javascript:void(0)"
                                            onclick='downloadChart("chart_top_seller", "Top Seller")'>Download
                                            <i class="fas fa-image ml-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body d-flex and flex-column">
                                <!-- Chart -->
                                <div>
                                    <canvas id="chart_top_seller"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Tab 0 > End Row Top Seller --}}


                {{-- Tab 0 > Monthly Seller & Buyer --}}
                <div class="row">
                    <div class="col-12 col-md-6 d-flex align-self-stretch">
                        <div class="card w-100">
                            <div class="card-header ">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h6 class="text-primary text-uppercase ls-1 mb-1">
                                            Monthly Seller
                                        </h6>
                                    </div>
                                    <div class="col-4">
                                        <a class="btn btn-sm btn-outline-primary float-right" href="javascript:void(0)"
                                            onclick='downloadChart("chart_monthly_seller", "Monthly Seller")'>Download
                                            <i class="fas fa-image ml-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body d-flex and flex-column">
                                <!-- Chart -->
                                <div>
                                    <canvas id="chart_monthly_seller"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 d-flex align-self-stretch">
                        <div class="card w-100">
                            <div class="card-header ">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h6 class="text-primary text-uppercase ls-1 mb-1">
                                            Monthly Buyer
                                        </h6>
                                    </div>
                                    <div class="col-4">
                                        <a class="btn btn-sm btn-outline-primary float-right" href="javascript:void(0)"
                                            onclick='downloadChart("chart_monthly_buyer", "Monthly Buyer")'>Download
                                            <i class="fas fa-image ml-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body d-flex and flex-column">
                                <!-- Chart -->
                                <div>
                                    <canvas id="chart_monthly_buyer"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Tab 0 > End Monthly Buyer & Customer --}}

            </div>
            {{-- End Tab 0 --}}


            {{-- Tab 1 --}}
            <div class="tab-pane fade @if (request()->query('tab') == 'tables') show active @endif" id="tabs-icons-text-1"
                role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                <br>

                <form class action="{{ route('admin.general_report.index') }}" method="get">
                    <div class="input-group">

                        <div class="input-group-prepend">
                            <select class="form-control form-control-sm" name="category">
                                <option value="">-- All Category --</option>
                                @foreach (\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}" @if (filled(request('category')) && request('category') == $category->id) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <select class="form-control form-control-sm" name="month">
                            <option value="">-- Select Month --</option>
                            @foreach (getOrderMonths() as $month)
                                <option value="{{ $month['month_no'] }}"
                                    @if (filled(request('month')) && request('month')) selected @endif>
                                    {{ $month['month'] }}
                                </option>
                            @endforeach
                        </select>

                        <div class="input-group-append">
                            <select class="form-control form-control-sm" name="year">
                                <option value="">-- Select Year --</option>
                                @foreach (getOrderYears() as $year)
                                    <option value="{{ $year['year'] }}" @if (filled(request('month')) && request('month')) selected @endif>
                                        {{ $year['year'] }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="tab" value="graphs">
                            <button class="btn btn-sm btn-primary">Filter</button>

                        </div>
                    </div>
                </form>
                <br>
                {{-- Tab 1 > Row Monthly Sales --}}
                <div class="row">
                    <div class="col-12 col-md-12 d-flex align-self-stretch">
                        <div class="card w-100">
                            <div class="card-header ">
                                <div class="row align-items-center">
                                    <div class="col-md-7">
                                        <h6 class="text-primary text-uppercase ls-1 mb-1">
                                            TOTAL MONTHLY SALES (₱)


                                        </h6>
                                    </div>
                                    <div class="col-md-5">
                                        <a href="{{ route('admin.print.handle') }}?records=monthly_sales"
                                            class="btn btn-sm btn-outline-primary float-right ">Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body d-flex and flex-column">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Month</th>
                                                        <th>Total Sales </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse (array_combine($chart_total_monthly_sales[0], $chart_total_monthly_sales[1]) as $month => $total_sale)
                                                        <tr>
                                                            <td>{{ $month }}</td>
                                                            <td>{{ $total_sale }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td>
                                                                Records Not Found
                                                            </td>
                                                        </tr>
                                                    @endforelse

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                {{-- End Tab 1 > Row Monthly Sales --}}

                {{-- Tab 1 > Row Yearly Sales --}}
                <div class="row">
                    <div class="col-12 col-md-12 d-flex align-self-stretch">
                        <div class="card w-100">
                            <div class="card-header ">
                                <div class="row align-items-center">
                                    <div class="col-md-7">
                                        <h6 class="text-primary text-uppercase ls-1 mb-1">
                                            TOTAL YEARLY SALES (₱)
                                        </h6>
                                    </div>
                                    <div class="col-md-5">
                                        <a href="{{ route('admin.print.handle') }}?records=yearly_sales"
                                            class="btn btn-sm btn-outline-primary float-right ">Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body d-flex and flex-column">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Year</th>
                                                        <th>Total Sales </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse (array_combine($chart_total_yearly_sales[0], $chart_total_yearly_sales[1]) as $year => $total_sale)
                                                        <tr>
                                                            <td>{{ $year }}</td>
                                                            <td>{{ $total_sale }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td>
                                                                Records Not Found
                                                            </td>
                                                        </tr>
                                                    @endforelse

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                {{-- End Tab 1 > Row Yearly Sales --}}

                {{-- Tab 1 > Row Pets By Category --}}
                <div class="row">
                    <div class="col-12 col-md-12 d-flex align-self-stretch">
                        <div class="card w-100">
                            <div class="card-header ">
                                <div class="row align-items-center">
                                    <div class="col-md-7">
                                        <h6 class="text-primary text-uppercase ls-1 mb-1">
                                            TOTAL PETS BY CATEGORY
                                        </h6>
                                    </div>
                                    <div class="col-md-5">
                                        <a href="{{ route('admin.print.handle') }}?records=pet_by_category"
                                            class="btn btn-sm btn-outline-primary float-right ">Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body d-flex and flex-column">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Category</th>
                                                        <th>Total Pets </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse (array_combine($chart_total_pets_by_category[0], $chart_total_pets_by_category[1]) as $category => $total_pet)
                                                        <tr>
                                                            <td>{{ $category }}</td>
                                                            <td>{{ $total_pet }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td>
                                                                Records Not Found
                                                            </td>
                                                        </tr>
                                                    @endforelse

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                {{-- End Tab 1 > Row Pets By Category --}}

                {{-- Tab 1 > Row Top Selling Pet --}}
                <div class="row">
                    <div class="col-12 col-md-12 d-flex align-self-stretch">
                        <div class="card w-100">
                            <div class="card-header ">
                                <div class="row align-items-center">
                                    <div class="col-md-7">
                                        <h6 class="text-primary text-uppercase ls-1 mb-1">
                                            TOP SELLING PET
                                        </h6>
                                    </div>
                                    <div class="col-md-5">
                                        <a href="{{ route('admin.print.handle') }}?records=top_selling_pet"
                                            class="btn btn-sm btn-outline-primary float-right ">Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body d-flex and flex-column">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>pet</th>
                                                        <th>Total Successful Order Attempt </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse (array_combine($chart_top_selling_pet[0], $chart_top_selling_pet[1]) as $pet => $total_order)
                                                        <tr>
                                                            <td>{{ $pet }}</td>
                                                            <td>{{ $total_order }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td>
                                                                Records Not Found
                                                            </td>
                                                        </tr>
                                                    @endforelse

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                {{-- End Tab 1 > Row Top Selling Pet --}}

                {{-- Tab 1 > Row Top Seller --}}
                <div class="row">
                    <div class="col-12 col-md-12 d-flex align-self-stretch">
                        <div class="card w-100">
                            <div class="card-header ">
                                <div class="row align-items-center">
                                    <div class="col-md-7">
                                        <h6 class="text-primary text-uppercase ls-1 mb-1">
                                            TOP SELLER
                                        </h6>
                                    </div>
                                    <div class="col-md-5">
                                        <a href="{{ route('admin.print.handle') }}?records=top_seller"
                                            class="btn btn-sm btn-outline-primary float-right ">Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body d-flex and flex-column">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Seller</th>
                                                        <th>Total Successful Deliveries </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse (array_combine($chart_top_seller[0], $chart_top_seller[1]) as $seller => $total_order)
                                                        <tr>
                                                            <td>{{ $seller }}</td>
                                                            <td>{{ $total_order }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td>
                                                                Records Not Found
                                                            </td>
                                                        </tr>
                                                    @endforelse

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                {{-- End Tab 1 > Row Top Seller --}}


            </div>
            {{-- End Tab 1 --}}
        </div>
    </div>
    <!-- End Page Content -->
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            Chart.register(ChartDataLabels); // enable chart js plugins

            const bgc = [
                '#C66930',
                '#FFDE59',
                '#212529',
                '#ecf0f1',
                '#95a5a6',
                '#5603ad',
                '#2c3e50',
            ];


            const categories = @json($chart_total_pets_by_category[0]);
            const total_pets = @json($chart_total_pets_by_category[1]);

            const chart_total_pets_by_category = document.getElementById('chart_total_pets_by_category');
            const CHART_A = new Chart(chart_total_pets_by_category, {
                type: 'bar', // bar , horizontal, line ,doughnut ,radar , polarArea
                data: {
                    labels: categories,
                    datasets: [{
                        label: 'Total Pets',
                        data: total_pets,
                        backgroundColor: bgc
                    }],

                },
                options: {
                    // title: {
                    //     display: true,
                    //     text: 'Total Pets'
                    // },
                    // barThickness: 'flex',

                    plugins: {
                        // indexAxis: 'y',
                        datalabels: {
                            color: '#fff',
                            align: 'center',
                            backgroundColor: function(context) {
                                return context.dataset.backgroundColor;
                            },
                            borderColor: '#ECF0F1',
                            borderRadius: 25,
                            borderWidth: 2,
                            font: {
                                weight: 'bold'
                            },
                            padding: 6,
                        }
                    },
                }
            });


            const CHART_B_months = @json($chart_total_monthly_sales[0]);
            const CHART_B_total_monthly_sales = @json($chart_total_monthly_sales[1]);

            const chart_total_monthly_sales = document.getElementById('chart_total_monthly_sales');
            const CHART_B = new Chart(chart_total_monthly_sales, {
                type: 'bar', // bar , horizontal, line ,doughnut ,radar , polarArea
                data: {
                    labels: CHART_B_months,
                    datasets: [{
                        label: 'Total Monthly Sales (₱)',
                        data: CHART_B_total_monthly_sales,
                        backgroundColor: bgc
                    }],

                },
                options: {
                    title: {
                        display: true,
                        text: 'Total Monthly Sales (₱)'
                    },
                    plugins: {
                        // indexAxis: 'y',
                        datalabels: {
                            color: '#fff',
                            align: 'center',
                            backgroundColor: function(context) {
                                return context.dataset.backgroundColor;
                            },
                            borderColor: '#ECF0F1',
                            borderRadius: 25,
                            borderWidth: 2,
                            font: {
                                weight: 'bold'
                            },
                            padding: 6,
                        }
                    },
                }
            });

            const CHART_C_years = @json($chart_total_yearly_sales[0]);
            const CHART_C_total_yearly_sales = @json($chart_total_yearly_sales[1]);

            const chart_total_yearly_sales = document.getElementById('chart_total_yearly_sales');
            const CHART_C = new Chart(chart_total_yearly_sales, {
                type: 'bar', // bar , horizontal, line ,doughnut ,radar , polarArea
                data: {
                    labels: CHART_C_years,
                    datasets: [{
                        label: 'Total Yearly Sales (₱)',
                        data: CHART_C_total_yearly_sales,
                        backgroundColor: bgc
                    }],

                },
                options: {
                    title: {
                        display: true,
                        text: 'Total Yearly Sales (₱)'
                    },
                    plugins: {
                        // indexAxis: 'y',
                        datalabels: {
                            color: '#fff',
                            align: 'center',
                            backgroundColor: function(context) {
                                return context.dataset.backgroundColor;
                            },
                            borderColor: '#ECF0F1',
                            borderRadius: 25,
                            borderWidth: 2,
                            font: {
                                weight: 'bold'
                            },
                            padding: 6,
                        }
                    },
                }
            });


            const CHART_D_pets = @json($chart_top_selling_pet[0]);
            const CHART_D_total_orders = @json($chart_top_selling_pet[1]);

            const chart_top_selling_pet = document.getElementById('chart_top_selling_pet');
            const CHART_D = new Chart(chart_top_selling_pet, {
                type: 'bar', // bar , horizontal, line ,doughnut ,radar , polarArea
                data: {
                    labels: CHART_D_pets,
                    datasets: [{
                        label: 'Total Successful Order Attempt',
                        data: CHART_D_total_orders,
                        backgroundColor: bgc
                    }],

                },
                options: {
                    title: {
                        display: true,
                        text: 'Total Order'
                    },
                    plugins: {
                        // indexAxis: 'y',
                        datalabels: {
                            color: '#fff',
                            align: 'center',
                            backgroundColor: function(context) {
                                return context.dataset.backgroundColor;
                            },
                            borderColor: '#ECF0F1',
                            borderRadius: 25,
                            borderWidth: 2,
                            font: {
                                weight: 'bold'
                            },
                            padding: 6,
                        }
                    },
                }
            });


            const CHART_E_sellers = @json($chart_top_seller[0]);
            const CHART_E_total_orders = @json($chart_top_seller[1]);

            const chart_top_seller = document.getElementById('chart_top_seller');
            const CHART_E = new Chart(chart_top_seller, {
                type: 'bar', // bar , horizontal, line ,doughnut ,radar , polarArea
                data: {
                    labels: CHART_E_sellers,
                    datasets: [{
                        label: 'Total Successful Deliveries',
                        data: CHART_E_total_orders,
                        backgroundColor: bgc
                    }],

                },
                options: {
                    title: {
                        display: true,
                        text: 'Total Order'
                    },
                    plugins: {
                        // indexAxis: 'y',
                        datalabels: {
                            color: '#fff',
                            align: 'center',
                            backgroundColor: function(context) {
                                return context.dataset.backgroundColor;
                            },
                            borderColor: '#ECF0F1',
                            borderRadius: 25,
                            borderWidth: 2,
                            font: {
                                weight: 'bold'
                            },
                            padding: 6,
                        }
                    },
                }
            });


            const CHART_F_months = @json($chart_monthly_seller[0]);
            const CHART_F_total_seller = @json($chart_monthly_seller[1]);

            const chart_monthly_seller = document.getElementById('chart_monthly_seller');
            const CHART_F = new Chart(chart_monthly_seller, {
                type: 'bar', // bar , horizontal, line ,doughnut ,radar , polarArea
                data: {
                    labels: CHART_F_months,
                    datasets: [{
                        label: 'Total Seller',
                        data: CHART_F_total_seller,
                        backgroundColor: bgc
                    }],

                },
                options: {
                    title: {
                        display: true,
                        text: 'Total Monthly Seller'
                    }
                }
            });

            const CHART_G_months = @json($chart_monthly_buyer[0]);
            const CHART_G_total_buyer = @json($chart_monthly_buyer[1]);

            const chart_monthly_buyer = document.getElementById('chart_monthly_buyer');
            const CHART_G = new Chart(chart_monthly_buyer, {
                type: 'bar', // bar , horizontal, line ,doughnut ,radar , polarArea
                data: {
                    labels: CHART_G_months,
                    datasets: [{
                        label: 'Total Buyer',
                        data: CHART_G_total_buyer,
                        backgroundColor: bgc
                    }],

                },
                options: {
                    title: {
                        display: true,
                        text: 'Total Monthly Buyer'
                    }
                }
            });


        });
    </script>
@endsection
