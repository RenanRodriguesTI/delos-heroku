@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-sm-3 mail_list_column">
            @foreach($notifications as $key => $notification)
                <a href="javascript:;" id="related-{{$key}}">
                    <div class="mail_list">
                        <div class="right">
                            <h3> {{$notification[0]['title']}}</h3>
                            <p>{!! $notification[0]['message']!!}</p>
                        </div>
                    </div>
                </a>
                <br>
            @endforeach
        </div>

        <div class="col-sm-9 mail_view">
            <div class="inbox-body">
                @foreach($notifications as $key => $notification)
                    <div class="mail" id="related-view-{{$key}}">
                        <div class="mail_heading row">
                            <div class="col-md-12">
                                <h4>{{$notification[0]['title']}}</h4>
                            </div>
                        </div>
                        <div class="view-mail">
                            {!! $notification[0]['view'] ?? null !!}
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection