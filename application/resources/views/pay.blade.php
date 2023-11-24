@extends('layouts.index')
@section('page', \Illuminate\Support\Facades\Lang::get('Make Payment'))
@section('content')
    <section class="pt-5 products-section">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="alert alert-info">
                        {!! $message !!}
                    </div>
                    <div class="card card-body d-flex flex-column align-items-center">
                        <p id="address" class="fw-bold w-100 text-center">{{$transaction->address}}</p>
                        <div id="qr-code"></div>
                        <input type="hidden" value="{{$transaction->id}}" id="payment-id">
                        <input type="hidden" value="{{url('/success')}}" id="success-url">
                        <input type="hidden" value="{{url('/check-transaction?txid='.$transaction->id)}}" id="check-url">
                        <input type="hidden" value="{{asset('/public/images/'.$transaction->token->icon)}}" id="icon">
                        <span id="danger-man" class="text-danger d-none">{{__('Transaction not yet confirmed on the blockchain')}}</span><br>
                        <div id="loading" class="spinner-border text-success d-none" role="status">
                        </div>
                        <button id="confirm" class="btn btn-success w-75">{{__('I have paid')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page_scripts')
    <script src="{{asset('public/assets/js/pay.js')}}"></script>
@endsection
