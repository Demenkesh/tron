@extends('layouts.index')
@section('page', \Illuminate\Support\Facades\Lang::get('Transactions'))
@section('content')
    <section class="pt-5 products-section">
        <div class="container">
            @include('partials.flashmessages')
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3 border-0">
                        <div class="card-header">
                            <h5>{{__('Transactions')}}</h5>
                        </div>
                        <div class="card-body table-responsive p-0 m-0 shadow">
                            <table class="table table-striped table-bordered m-0">
                                <thead>
                                <tr>
                                    <th>{{__('Token')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Amount USD')}}</th>
                                    <th>{{__('Address')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Date')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td><img class="img" width="30px" src="{{asset('public/images/'.$transaction->token->icon)}}" alt="">
                                        {{$transaction->token->ticker}}
                                        </td>
                                        <td>{{$transaction->crypto_amount}} {{$transaction->token->ticker}}</td>
                                        <td>{{$transaction->amount}}</td>
                                        <td>{{$transaction->address}}</td>
                                        <td>
                                            @if($transaction->success) <span class="text-success">{{__('Success')}}</span> @else <span class="text-warning">{{__('Pending')}}</span> @endif
                                        </td>
                                        <td>
                                            {{date('Y-m-d', strtotime($transaction->created_at))}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{$transactions->links()}}
                </div>
            </div>
        </div>
    </section>
@endsection
