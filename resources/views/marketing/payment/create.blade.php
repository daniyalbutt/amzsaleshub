@extends('layouts.app-marketing')

@section('content')
<div class="breadcrumb">
    <h1>Payment Link - {{$user->name}} {{$user->last_name}}</h1>
    <ul>
        <li><a href="#">Clients</a></li>
        <li>Payment Link for {{$user->name}} {{$user->last_name}}</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Payment Details Form</div>
                <form class="form" action="{{route('marketing.invoice.create')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="client_id" value="{{$user->id}}">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3 form-group mb-3">
                                <label for="name">First Name <span>*</span></label>
                                <input type="text" id="name" class="form-control" value="{{ $user->name }} {{ $user->last_name }}" placeholder="Name" name="name" required="required">
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="email">Email <span>*</span></label>
                                <input type="email" id="email" class="form-control" value="{{ $user->email }}" placeholder="Email" name="email" required="required">
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="contact">Contact</label>
                                <input type="text" id="contact" class="form-control" value="{{ $user->contact }}" placeholder="Contact" name="contact">
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="sale_type">Sale Type <strong>*</strong></label>
                                <select class="form-control" name="sale_type" id="sale_type" required>
                                    <option value="">Select Sale Type</option>
                                    <option value="1">Front</option>
                                    <option value="2">Upsell</option>
                                    <option value="3">Remaining</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="brand">Brand Name <span>*</span></label>
                                <select name="brand" id="brand" class="form-control select2" required>
                                    <option value="">Select Brand</option>
                                    @foreach($brand as $brands)
                                    <option value="{{ $brands->id }}" {{ $brands->id == $user->brand_id ? 'selected' : '' }}>{{ $brands->name }} - {{ $brands->url }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="service">Service <span>*</span></label>
                                <select name="service[]" id="service" class="form-control select2" required multiple>
                                    @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="package">Package <span>*</span></label>
                                <select name="package" id="package" class="form-control" required>
                                    <option value="">Select Package</option>
                                    <option value="0" selected>Custom Package</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="custom_package">Name for a Custom Package</label>
                                <input type="text" id="custom_package" class="form-control" value="" placeholder="Custom Package Name" name="custom_package">
                            </div>
                            <div class="col-md-2 form-group mb-3">
                                <label for="currency">Currency<span>*</span></label>
                                <select name="currency" id="currency" class="form-control select2" required>
                                    <option value="">Select Currency</option>
                                    @foreach($currencies as $currency)
                                    <option value="{{$currency->id}}">{{$currency->name}} - {{$currency->short_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group mb-3">
                                <label for="amount">Amount<span>*</span></label>
                                <input step=".01" type="number" id="amount" class="form-control" value="" placeholder="Amount" name="amount" required min="1">
                            </div>
                            <div class="col-md-2 form-group mb-3">
                                <label for="total_amount">Total Amount<span>*</span></label>
                                <input step=".01" type="number" id="total_amount" class="form-control" value="" placeholder="Total Amount" name="total_amount" required min="1">
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="merchant">Merchant<span>*</span></label>
                                <select name="merchant" id="merchant" class="form-control" required>
                                    <option value="">Select Merchant</option>
                                    @foreach($merchant as $merchants)
                                    <option value="{{ $merchants->id }}">{{ $merchants->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="discription">Description</label>
                                <textarea name="discription" id="" cols="30" rows="6" class="form-control"></textarea>
                            </div>
                            <div class="col-md-12">
                                <input type="hidden" name="payment_type" value="0">
                                <button type="submit" class="btn btn-primary">Create Invoice</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Remaining Payment Modal -->
<div class="modal fade" id="remainingModal" tabindex="-1" role="dialog" aria-labelledby="remainingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="remainingModalLabel">Remaining Payment Summary</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Amount Paid</th>
                            <th>Total Amount</th>
                            <th>Remaining</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="align-middle">
                            <td class="align-middle">Front</td>
                            <td class="align-middle" id="frontAmount">-</td>
                            <td class="align-middle" id="frontTotal">-</td>
                            <td class="align-middle" id="frontRemaining">-</td>
                            <td class="align-middle">
                                <form id="frontInvoiceForm">
                                    <div class="input-group">
                                        <input step=".01" type="number" class="form-control" placeholder="Invoice Amount" name="invoice_amount" required min="1" style="width: 80px;">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary btn-sm" type="submit" style="height: 33px;font-size: 17px;line-height: 29px;">
                                                <i class="nav-icon i-Link"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <tr class="align-middle">
                            <td class="align-middle">Upsell</td>
                            <td class="align-middle" id="upsellAmount">-</td>
                            <td class="align-middle" id="upsellTotal">-</td>
                            <td class="align-middle" id="upsellRemaining">-</td>
                            <td class="align-middle">
                                <form id="upsellInvoiceForm">
                                    <div class="input-group">
                                        <input step=".01" type="number" class="form-control" placeholder="Invoice Amount" name="invoice_amount" required min="1" style="width: 80px;">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary btn-sm" type="submit" style="height: 33px;font-size: 17px;line-height: 29px;">
                                                <i class="nav-icon i-Link"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
    const clientId = $('input[name="client_id"]').val();

    function num(v){ return isNaN(parseFloat(v)) ? 0 : parseFloat(v); }

    $.get('{{ route("marketing.invoice.previous") }}', { client_id: clientId }, function (data) {
        const front  = data.front  || { amount:0,total:0,merchant_id:null,services:[] };
        const upsell = data.upsell || { amount:0,total:0,merchant_id:null,services:[] };

        $('#frontAmount').text(num(front.amount).toFixed(2));
        $('#frontTotal').text(num(front.total).toFixed(2));
        $('#frontRemaining').text((front.total - front.amount).toFixed(2));

        $('#upsellAmount').text(num(upsell.amount).toFixed(2));
        $('#upsellTotal').text(num(upsell.total).toFixed(2));
        $('#upsellRemaining').text((upsell.total - upsell.amount).toFixed(2));

        $('#remainingModal').modal('show');

        // ---- Front submit ----
        $('#frontInvoiceForm').on('submit', function(e){
            e.preventDefault();
            const val = num($(this).find('[name="invoice_amount"]').val());
            $('#sale_type').val(1);
            $('#amount').val(val.toFixed(2));
            $('#total_amount').val(front.total.toFixed(2));
            if(front.merchant_id) $('#merchant').val(front.merchant_id).trigger('change');
            if (front.currency_id) {
                $('#currency').val(front.currency_id).trigger('change');
            }
            if (front.brand) {
                $('#brand').val(front.brand).trigger('change');
            }
            $('#remainingModal').modal('hide');
        });

        // ---- Upsell submit ----
        $('#upsellInvoiceForm').on('submit', function(e){
            e.preventDefault();
            const val = num($(this).find('[name="invoice_amount"]').val());
            $('#sale_type').val(2);
            $('#amount').val(val.toFixed(2));
            $('#total_amount').val(upsell.total.toFixed(2));
            if(upsell.merchant_id) $('#merchant').val(upsell.merchant_id).trigger('change');
            if (upsell.currency_id) {
                $('#currency').val(upsell.currency_id).trigger('change');
            }
            if (upsell.brand) {
                $('#brand').val(upsell.brand).trigger('change');
            }
            $('#remainingModal').modal('hide');
        });
    });
});
</script>
@endpush
