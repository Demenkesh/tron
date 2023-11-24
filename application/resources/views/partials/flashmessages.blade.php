@if(session('success_message'))
    <div class="alert alert-success">
        {{session('success_message')}}
    </div>
@endif
@if(session('failure_message'))
    <div class="alert alert-danger">
        {{session('failure_message')}}
    </div>
@endif
@if(session('warning_message'))
    <div class="alert alert-warning">
        {{session('warning_message')}}
    </div>
@endif
@if(session('info_message'))
    <div class="alert alert-info">
        {{session('info_message')}}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li><br>
            @endforeach
        </ul>
    </div>
@endif
