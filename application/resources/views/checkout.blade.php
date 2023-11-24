@extends('layouts.index')
@section('page', \Illuminate\Support\Facades\Lang::get('Checkout'))
@section('content')
    <section class="pt-5 products-section">
        <div class="container">
            @include('partials.flashmessages')
            <div class="row d-flex justify-content-center">
                <div class="col-md-4 p-3">
                    <div class="card shadow border-0">
                        <div class="card-header border-0">
                            <h5 class="text-center">{{__('Payment Method')}}</h5>
                        </div>
                        <div class="card-body m-0 p-0">
                            <form action="{{url('/pay')}}" method="post">
                                @csrf
                                <ul class="list-group rounded-0">
                                    @foreach($tokens as $token)
                                        <li class="list-group-item d-flex justify-content-between">
                                        <span><input required type="radio" value="{{$token->id}}" id="{{$token->id}}" name="payment_method" />
                                        <label for="{{$token->id}}">{{$token->ticker}} </label>
                                        </span>
                                            <img width="20px" src="{{asset('public/images/'.$token->icon)}}" alt="{{__('token')}}" />
                                        </li>
                                    @endforeach
                                </ul>
                                <button type="submit" class="btn btn-success rounded-0 w-100">{{__('Proceed to Pay')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-3">
                    <div class="card shadow border-0">
                        <div class="card-header border-0">
                            <h5 class="text-center">{{__('Order Summary')}}</h5>
                        </div>
                        <div class="card-body m-0 p-0">
                            <ul class="list-group rounded-0 summary">
                                <li class="list-group-item">
                                    <span class="fw-bold">{{__('Product')}}</span>
                                    <span class="fw-bold">{{__('Qty')}}</span>
                                    <span class="fw-bold">{{__('Total')}}</span>
                                </li>
                                @foreach($products as $product)
                                    <li class="list-group-item">
                                        <span>{{$product->name}}</span>
                                        <span class="middle">x {{$product->count}}</span>
                                        <span class="last">${{$product->price}}</span>
                                    </li>
                                @endforeach
                                <li class="list-group-item"></li>
                                <li class="list-group-item">
                                    <span class="fw-bold">{{__('Subtotal')}}</span>
                                    <span class="fw-bold">${{number_format($total, 2)}}</span>
                                </li>
                                <li class="list-group-item">
                                    <span>{{__('Charge')}}</span>
                                    <span>$00.00</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="fw-bold">{{__('Total')}}</span>
                                    <span class="fw-bold">${{number_format($total, 2)}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
