@extends('layouts.index')
@section('page', \Illuminate\Support\Facades\Lang::get('Transaction Successful'))
@section('content')
    <section class="products-section d-flex align-items-center">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 bg-success p-5 rounded-1 shadow">
                    <p class="text-center text-white w-100 fs-1">
                        {{__('Transaction Processed successfully')}}
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
