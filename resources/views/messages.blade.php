@if(session('success') || session('error'))
    <div class="panel-body">
        @if(session('success'))
        <div class="{{session('success') ? 'alert alert-success' : ''}}">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{session('success')}}
        </div>
        @endif

        @if(session('error'))
        <div class="{{session('error') ? 'alert alert-danger' : ''}}">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{session('error')}}
        </div>
        @endif
    </div>
@endif