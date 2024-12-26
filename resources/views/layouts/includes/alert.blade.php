@if (session('success') || session('warning') || session('error'))
    <div class="alert @if (session('success')) alert-success @endif @if (session('warning')) alert-warning @endif @if (session('error')) alert-danger @endif  alert-dismissible fade show p-3 text-white"
        role="alert">
        {{ session('success') ?? (session('warning') ?? session('error')) }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show p-3 text-white" role="alert"">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
