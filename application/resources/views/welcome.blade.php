@extends('layouts.index')
@section('page', \Illuminate\Support\Facades\Lang::get('Accept Tron crypto payments on the tron Block chain network'))
@section('content')
    <section class="pt-5 products-section">
        <div class="container">
            <div class="alert alert-info">
                <strong>NOTE: </strong> Some features will not work well within the <em class="text-warning">codecanyon frame</em>. If you are opening the demo inside the frame,
                <a href="{{url('/')}}" target="_blank">Click here to open in a new tab</a>
            </div>
            <div class="row">
                @foreach($products as $product)
                <div class="col-md-3 mb-2">
                    <div class="card shadow">
                        <div class="card-body p-0 position-relative">
                            <img
                                src="{{asset('public/images/'.$product->image)}}"
                                class="img w-100" height="260"
                            />
                            <p class="p-1 m-0 bg-dark text-center position-absolute w-100 p-name text-white bg-opacity-75">
                                {{$product->name}} <br>
                                <span class="fw-bold">${{number_format($product->price, 2)}}</span>
                            </p>
                        </div>
                        <div class="card-footer p-0">
                            <a href="{{url('/products/'.$product->id.'/add-to-cart')}}" class="btn btn-danger w-100 rounded-0">
                                {{__('Add to cart')}}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
