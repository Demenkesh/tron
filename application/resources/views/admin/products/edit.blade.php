@extends('layouts.index')
@section('page', \Illuminate\Support\Facades\Lang::get('Edit Product'))
@section('content')
    <section class="pt-5 products-section">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="card mb-3 border-0 shadow">
                        <div class="card-header">
                            <h5>{{__('Edit Product')}}</h5>
                        </div>
                        <div class="card-body">
                            @include('partials.flashmessages')
                            <form action="{{url('/products/'.$product->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="form-group m-2">
                                    <label for="name">{{__('Product Name')}}</label>
                                    <input id="name" type="text" required name="name" value="{{$product->name}}" class="form-control">
                                </div>
                                <div class="form-group m-2">
                                    <label for="price">{{__('Price')}}</label>
                                    <input type="number" step="0.001" name="price" id="price" required value="{{$product->price}}" class="form-control">
                                </div>
                                <div class="form-group m-2">
                                    <label for="image">{{__('Image')}}</label>
                                    <input type="file" name="image" accept="image/jpeg,image/png,image/jpg" id="image" class="form-control">
                                </div>
                                <div class="form-group m-2">
                                    <input type="submit" value="{{__('Update')}}" class="btn btn-success bg-success">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
