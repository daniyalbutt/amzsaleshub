
@extends('layouts.app-marketing')
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Dashboard</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Credit-Card"></i>
                        <p class="text-muted mt-2 mb-2"><strong>Total Sales</strong><br>{{ $month_name }} - {{ $year }}</p>
                        <p class="text-primary text-24 line-height-1 m-0">${{ $month_sales }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Dollar-Sign"></i>
                        <p class="text-muted mt-2 mb-2"><strong>Total Spending</strong><br>{{ $month_name }} - {{ $year }}</p>
                        <p class="text-primary text-24 line-height-1 m-0">${{ $month_spending }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="separator-breadcrumb border-top mb-4"></div>
<div class="breadcrumb">
    <h1 class="mr-2">Spending Overview</h1>
</div>
<div class="separator-breadcrumb border-top mb-4"></div>
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label for="brand_id">Select Brand</label>
                        <select id="brand_id" class="form-control select2">
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="type">Select Type</label>
                        <select id="type" class="form-control">
                            <option value="">All Types</option>
                            @foreach(\App\Models\Spending::TYPES as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="from_date">From</label>
                        <input type="date" id="from_date" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label for="to_date">To</label>
                        <input type="date" id="to_date" class="form-control">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button id="filter" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
                <div class="card shadow-sm p-3">
                    <canvas id="spendingChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="separator-breadcrumb border-top mb-4"></div>
<div class="breadcrumb">
    <h1 class="mr-2">Spending</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="row">
            @foreach ($today_spending as $item)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Dollar-Sign"></i>
                        <p class="text-muted mt-2 mb-2"><strong>Today Spending</strong><br>{{ $item->type_label }}</p>
                        <p class="text-primary text-24 line-height-1 m-0">${{ number_format($item->total, 2) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="separator-breadcrumb border-top mb-4"></div>
<div class="breadcrumb">
    <h1 class="mr-2">Invoices</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="row">
            @foreach ($sales_by_type as $row)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Credit-Card"></i>
                        <p class="text-muted mt-2 mb-2"><strong>{{ $row->sale_type() }}</strong><br>{{ $month_name }} - {{ $year }}</p>
                        <p class="text-primary text-24 line-height-1 m-0">${{ number_format($row->total, 2) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('spendingChart').getContext('2d');
    let chart;

    function fetchData() {
        const brand_id = document.getElementById('brand_id').value;
        const from_date = document.getElementById('from_date').value;
        const to_date = document.getElementById('to_date').value;

        fetch(`{{ route('dashboard.spendingChart') }}?brand_id=${brand_id}&from_date=${from_date}&to_date=${to_date}`)
            .then(res => res.json())
            .then(data => {
                const labels = data.dates;
                const datasets = Object.keys(data.datasets).map((type, i) => ({
                    label: type,
                    data: data.datasets[type],
                    borderWidth: 3,
                    borderColor: ['#4f46e5', '#16a34a', '#dc2626'][i % 3],
                    backgroundColor: ['#4f46e533', '#16a34a33', '#dc262633'][i % 3],
                    fill: true,
                    tension: 0.4,
                }));

                if (chart) chart.destroy();

                chart = new Chart(ctx, {
                    type: 'line',
                    data: { labels, datasets },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        },
                        plugins: {
                            legend: { display: true },
                            tooltip: { enabled: true }
                        }
                    }
                });
            });
    }



    // Initial load
    fetchData();

    // On filter button click
    document.getElementById('filter').addEventListener('click', fetchData);
});
</script>
@endpush
