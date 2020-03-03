@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">@lang('titles.show-audit')</h3>
            </div>
            <div class="panel-body">

                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <td><b>Id</b></td>
                            <td>{{$audit['data']['id']}}</td>
                        </tr>
                        
                        <tr>
                            <td><b>@lang('headers.group')</b></td>
                            <td>{{$audit['data']['group_name']}}</td>
                        </tr>
                        
                        <tr>
                            <td><b>@lang('headers.user')</b></td>
                            <td>{{$audit['data']['user_name']}}</td>
                        </tr>
                        
                        <tr>
                            <td><b>@lang('headers.type')</b></td>
                            <td>{{$audit['data']['event']}}</td>
                        </tr>
                        
                        <tr>
                            <td><b>@lang('headers.id-changed')</b></td>
                            <td>{{$audit['data']['auditable_id']}}</td>
                        </tr>

                        <tr>
                            <td><b>@lang('headers.entity')</b></td>
                            <td>{{$audit['data']['auditable_type']}}</td>
                        </tr>

                        <tr>
                            <td><b>@lang('headers.old-value')</b></td>
                            <td><pre>{{ $audit['data']['old_values'] }}</pre></td>
                        </tr>

                        <tr>
                            <td><b>@lang('headers.new-value')</b></td>
                            <td><pre><code>{{$audit['data']['new_values']}}</code></pre></td>
                        </tr>
                        
                        <tr>
                            <td><b>@lang('headers.date')</b></td>
                            <td>{{$audit['data']['created_at']}}</td>
                        </tr>

                    </tbody>
                </table>

            </div>
            <div class="panel-footer">
                <div class="text-right">
                    <a href="{{url()->previous() == url()->current() ? route('audits.index') : url()->previous()}}" class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        @lang('buttons.back')
                    </a>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection