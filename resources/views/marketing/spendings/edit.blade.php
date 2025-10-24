@extends('layouts.app-marketing')

@section('content')
<div class="breadcrumb">
    <h1>Edit Spending (ID: {{$data->id}})</h1>
    <ul>
        <li><a href="#">Spending</a></li>
        <li>Edit Spending (ID: {{$data->id}})</li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Spending Form</div>
                    <form class="form" action="{{route('spending.update', $data->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf   
                        @method('PATCH')  
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="amount">Amount ($) <span>*</span></label>
                                        <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ old('amount', $data->amount) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="brand_id">Select Brand <span>*</span></label>
                                    <select name="brand_id" id="brand_id" class="form-control select2" required>
                                        <option value="">-- Select Brand --</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ (old('brand_id', isset($data) ? $data->brand_id : '') == $brand->id) ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('brand_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date">Date <span>*</span></label>
                                        <input type="date" id="date" name="date" class="form-control" value="{{ old('date', $data->date?->format('Y-m-d')) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="type">Type <span>*</span></label>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="">-- Select Type --</option>
                                        <option value="0" {{ old('type', $data->type) == 0 ? 'selected' : '' }}>PPC</option>
                                        <option value="1" {{ old('type', $data->type) == 1 ? 'selected' : '' }}>TikTok</option>
                                        <option value="2" {{ old('type', $data->type) == 2 ? 'selected' : '' }}>SMM</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-actions text-right">
                            <button type="submit" class="btn btn-primary">
                            <i class="la la-check-square-o"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
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