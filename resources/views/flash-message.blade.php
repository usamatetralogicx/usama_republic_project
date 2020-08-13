@if ($message = Session::get('success'))
    <div class="alert alert-success mb-0 alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif


@if ($message = Session::get('error'))
    <div class="alert alert-danger mb-0 alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>{{ $message }}</strong>
    </div>
@endif


@if ($message = Session::get('warning'))
    <div class="alert alert-warning mb-0 alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>{{ $message }}</strong>
    </div>
@endif


@if ($message = Session::get('info'))
    <div class="alert alert-info mb-0 alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>{{ $message }}</strong>
    </div>
@endif


@if ($errors->any())
    <div class="alert alert-danger mb-0">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
