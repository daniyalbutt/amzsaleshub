
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
