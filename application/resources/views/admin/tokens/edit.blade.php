@extends('layouts.index')
@section('page', 'EditToken')
@section('content')
    <section class="pt-5 products-section">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="card border-0 shadow">
                        <div class="card-header">
                            <h5>{{__('Edit Token Details')}}</h5>
                        </div>
                        <div class="card-body">
                            @include('partials.flashmessages')
                            <form action="{{url('/tokens/'.$token->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="form-group m-1">
                                    <label for="name">{{__('Token Name')}}</label>
                                    <input id="name" type="text" required name="name" value="{{$token->name}}" class="form-control">
                                </div>
                                <div class="form-group m-1">
                                    <label for="ticker">{{__('Token Ticker')}}</label>
                                    <input type="text" name="ticker" id="ticker" required value="{{$token->ticker}}" class="form-control">
                                </div>
                                <div class="form-group m-1">
                                    <label for="contract_address">{{__('Contract Address')}}</label>
                                    <input type="text" name="contract_address" id="contract_address" required value="{{$token->contract_address}}" class="form-control">
                                </div>
                                <div class="form-group m-1">
                                    <label for="icon">{{__('Icon')}}</label>
                                    <input type="file" name="icon"accept="image/jpeg,image/png,image/jpg" id="icon" class="form-control">
                                </div>
                                <div class="form-group m-1">
                                    <input type="submit" value="{{__('Update')}}" class="btn btn-success mt-2">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
