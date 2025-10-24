@extends('layouts.app-marketing')
   
@section('content')

<div class="breadcrumb row">
    <div class="col-md-6">
        <h1>Spending List</h1>
        <ul>
            <li><a href="#">Spending</a></li>
            <li>Spending List</li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{ route('spending.create') }}" class="btn btn-primary">Create Spending</a>
    </div>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <form action="{{ route('spending.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-3 form-group mb-3">
                            <label for="name">Search Brand</label>
                            <select name="brand" id="brand" class="form-control select2">
                                <option value="">All Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ Request::get('brand') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="date">Search Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ Request::get('date') }}">
                        </div>
                        <div class="col-md-12">
                            <div class="text-right">
                                <button class="btn btn-primary">Search Result</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Spending Details</h4>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Brand</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Added By</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $datas)
                            <tr>
                                <td>{{ $datas->id }}</td>
                                <td><span class="btn btn-primary btn-sm">{{ $datas->brand != null ? $datas->brand->name : '' }}</span></td>
                                <td>{{ $datas->date->format('d M Y') }}</td>
                                <td><span class="btn btn-dark btn-sm">{{ $datas->type_label }}</span></td>
                                <td>${{ number_format($datas->amount, 2) }}</td>
                                <td>
                                    <span class="btn btn-info btn-sm">{{ $datas->added->name }}</span>
                                </td>
                                <td>
                                    <a href="{{route('spending.edit', $datas->id)}}" class="btn btn-primary btn-icon btn-sm">
                                        <span class="ul-btn__icon"><i class="i-Edit"></i></span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Brand</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Added By</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $data->links("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    
@endpush