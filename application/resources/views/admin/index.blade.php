@extends('layouts.index')
@section('page', \Illuminate\Support\Facades\Lang::get('Admin'))
@section('content')
    <section class="pt-5 products-section">
        <div class="container">
            @include('partials.flashmessages')
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3 shadow border-0">
                        <div class="card-header">
                            <h5>{{__('Destination Address')}}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{url('/settings')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="destination_address" class="text-info">{{__('Must be a tron address')}}</label>
                                    <input id="destination_address" type="text" required name="destination_address" value="{{$setting->destination_address}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="{{__('Update')}}" class="btn btn-success mt-2">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-3 shadow border-0">
                        <div class="card-header d-flex justify-content-between">
                            <h5>{{__('Tokens')}}</h5>
                            <a href="{{url('/tokens/create')}}" class="btn btn-primary">{{__('New Token')}}</a>
                        </div>
                        <div class="card-body bg-light m-0 p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>{{__('Icon')}}</th>
                                        <th>{{__('Ticker')}}</th>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Contract Address')}}</th>
                                        <th>{{__('Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tokens as $token)
                                        <tr>
                                            <td><img class="img" width="30px" src="{{asset('public/images/'.$token->icon)}}" alt="{{$token->name}}"></td>
                                            <td>{{$token->ticker}}</td>
                                            <td>{{$token->name}}</td>
                                            <td>{{$token->contract_address}}</td>
                                            <td><a class="btn-link m-1 text-info" href="{{url('/tokens/'.$token->id.'/edit')}}">{{__('edit')}}</a>
                                                <a class="btn-link m-1 text-danger" href="{{url('/tokens/'.$token->id.'/delete')}}">{{__('delete')}}</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card border-0 shadow">
                        <div class="card-header d-flex justify-content-between align-items-center border-3px">
                            <h5>{{__('Products')}}</h5>
                            <a href="{{url('/products/create')}}" class="btn btn-primary">{{__('New Product')}}</a>
                        </div>
                        <div class="card-body bg-light m-0 p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{__('image')}}</th>
                                        <th>{{__('name')}}</th>
                                        <th>{{__('price')}}</th>
                                        <th>{{__('Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td><img class="img" width="50px" src="{{asset('public/images/'.$product->image)}}" alt="{{$product->name}}"></td>
                                            <td>{{$product->name}}</td>
                                            <td>${{number_format($product->price, 2)}}</td>
                                            <td><a class="btn-link m-1 text-info" href="{{url('/products/'.$product->id.'/edit')}}">{{__('edit')}}</a>
                                                <a class="btn-link m-1 text-danger" href="{{url('/products/'.$product->id.'/delete')}}">{{__('delete')}}</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
