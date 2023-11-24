<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{getenv('APP_NAME')}} - @yield('page')</title>
    <link rel="stylesheet" href="{{asset('public/assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('public/assets/css/style.css')}}" />
    <link rel="icon" type="image/x-icon" href="{{asset('public/favicon.ico')}}">
</head>
<body class="bg-light">
<nav
    class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow"
>
    <div class="container">
        <a class="navbar-brand fw-bolder fs-3" href="{{url('/')}}">{{__('Trx')}} <span class="text-danger">{{__('Pay')}}</span> </a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul
                class="navbar-nav me-auto mb-2 mb-lg-0 w-100 justify-content-center"
            >
                <li class="nav-item">
                    <a class="nav-link {{isset($active) && $active == 'home' ? 'active' : ''}}" href="{{url('/')}}">{{__('Home')}}</a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/transactions')}}" class="nav-link {{isset($active) && $active == 'transactions' ? 'active' : ''}}">{{__('Transactions')}}</a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/settings')}}" class="nav-link {{isset($active) && $active == 'settings' ? 'active' : ''}}">{{__('Settings')}}</a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/cart')}}" class="nav-link active position-relative">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="22"
                            height="22"
                            fill="currentColor"
                            class="bi bi-cart-fill"
                            viewBox="0 0 16 16"
                        >
                            <path
                                d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"
                            />
                        </svg>
                        <span class="badge rounded-circle bg-danger position-absolute">
                            @if(session('products'))
                                {{count(session('products'))}}
                            @else
                                0
                            @endif
                </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@yield('content')
<section class="bg-light shadow mt-3">
    <footer class="w-100 bg-dark bottom-0 p-3 text-white text-center">
        &copy {{date('Y')}} {{__('Lakescripts')}}
    </footer>
</section>
<button
    id="back-to-top"
    class="btn btn-danger position-fixed shadow rounded-circle"
>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        width="16"
        height="16"
        fill="currentColor"
        class="bi bi-arrow-up"
        viewBox="0 0 16 16"
    >
        <path
            fill-rule="evenodd"
            d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"
        />
    </svg>
</button>
<script src="{{asset('public/assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('public/assets/js/easy.qrcode.min.js')}}"></script>
<script src="{{asset('public/assets/js/app.js')}}"></script>
@yield('page_scripts')
</body>
</html>
