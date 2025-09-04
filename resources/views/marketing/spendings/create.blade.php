@extends('layouts.app-marketing')

@section('content')
<div class="breadcrumb">
    <h1>Create Client</h1>
    <ul>
        <li><a href="#">Spending</a></li>
        <li>Create Spending</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Spending Form</div>
                <form class="form" action="{{route('spending.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf   
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="amount">Amount ($) <span>*</span></label>
                                <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" required>
                                @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">                                
                                <label for="date">Date <span>*</span></label>
                                <input type="date" name="date" id="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
                                @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="type">Type <span>*</span></label>
                                <select name="type" id="type" class="form-control" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="0" {{ old('type') === '0' ? 'selected' : '' }}>PPC</option>
                                    <option value="1" {{ old('type') === '1' ? 'selected' : '' }}>TikTok</option>
                                    <option value="2" {{ old('type') === '2' ? 'selected' : '' }}>SMM</option>
                                </select>
                                @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit">Save Spending</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        $('#contact').keypress(function(event){
            if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
                event.preventDefault(); //stop character from entering input
            }
        });
    </script>
@endpush