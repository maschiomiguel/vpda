<div id="flash-message" class="col-lg-12">
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br/>
            @endforeach
        </div>
    @endif
</div>
