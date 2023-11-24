@extends('layouts.index')
@section('page', \Illuminate\Support\Facades\Lang::get('Cart'))
@section('content')
    <section class="pt-5 products-section">
        <div class="container">
            @include('partials.flashmessages')
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">{{__('Product')}}</th>
                        <th scope="col">{{__('Price')}}</th>
                        <th scope="col">{{__('Quantity')}}</th>
                        <th scope="col">{{__('Total')}}</th>
                        <th scope="col">{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td class="p-2">
                                <div class="d-flex align-items-center">
                                    <div class="m-2">
                                        <img width="50px" src="{{asset('public/images/'.$product->image)}}" alt="{{__('product')}}" />
                                    </div>
                                    <div class="m-2">
                                        <p>{{$product->name}}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-2">
                                <h5>${{$product->price}}</h5>
                            </td>
                            <td class="p-2">
                                {{$product->count}}
                            </td>
                            <td class="p-2">
                                <h5>${{number_format(($product->price * $product->count), 2)}}</h5>
                            </td>
                            <td class="p-2">
                                <a href="{{url('/cart/remove/?key='.$product->index)}}" class="btn-link text-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square-fill" viewBox="0 0 16 16">
                                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                                    </svg></a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <h5>{{__('Total')}}</h5>
                        </td>
                        <td>
                            <h5>${{number_format($total, 2)}}</h5>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary m-2" href="{{url('/')}}">{{__('Continue Shopping')}}</a>
                    <a class="btn btn-success m-2" href="{{url('/checkout')}}">{{__('Proceed to checkout')}}</a>
                </div>
            </div>
        </div>
    </section>
@endsection
