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
                    <?php
                    dd($transaction);
                    ?>
                    <div class="card card-body d-flex flex-column align-items-center">
                        <p id="address" class="fw-bold w-100 text-center">{{ $transaction['address'] }}</p>
                        <div id="qr-code"></div>
                        <input type="hidden" value="{{ $transaction['id'] }}" id="payment-id">
                        <input type="hidden" value="{{ route('success', ['uniqueCode' => $transaction['uniqueCode']]) }}"
                            id="success-url">
                        <input type="hidden" value="{{ url('/check-transaction?txid=' . $transaction['id']) }}"
                            id="check-url">
                        <input type="hidden" value="{{ asset('/public/images/' . $transaction->token->icon) }}"
                            id="icon">
                        <span id="danger-man" class="text-danger d-none">{{ __('Waiting for payment') }}</span>
                        <br>
                        <div id="loading" class="spinner-border text-success d-none" role="status">
                        </div>
                        <button id="confirm" class="btn btn-success w-75">{{ __('I have paid') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var button = document.getElementById('confirm');

            function clickButtonAndRefresh() {
                button.click();
                $('#danger-man').addClass('d-none');
            }

            // Trigger click and refresh every 11 seconds
            setInterval(clickButtonAndRefresh, 11000); // 11 seconds in milliseconds
        });
    </script>



@endsection
@section('page_scripts')
    <script src="{{ asset('public/assets/js/pay.js') }}"></script>
@endsection
