@extends('layouts.app')
@section('content')
<div class="container">

    <div class="panel panel-dct">
        <div class="panel-heading">

            <div class="row">
                <div class="col-md-8">
                    <h3 class="panel-title bold">Documentos</h3>
                </div>
                <div class="col-md-4 text-right">
                    <span title="@lang('tips.whats-users')" class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true" data-toggle="tooltip" data-placement="left"></span>
                </div>
            </div>

        </div>
        @include('messages')
        <div class="panel-body" style="padding: 16px 24px 0 24px;">
            @include('documents.search')

           
        </div>

        <div class="panel-body">
            <div class="table-responsive" style="min-height: 390px;">
                <table class="table table-bordered table-hover" id="documents">
                    <thead>
                        <tr>
                            <th>@lang('headers.name')</th>
                            <th>@lang('headers.action')</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $key => $user)
                        <tr class="{{$user->have_expired_documents ? 'have_expired_documents':''}}">
                            <td><input type="checkbox" name="users[]"> {{$user->name}}</td>
                            <td>
                                <a href="{{route('documents.list',['user'=>$user->id])}}?epis=1" class="btn {{$user->have_expired_documents ?'btn-warning':'btn-dct'}}">Ver documentos</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>
        </div>
        <div class="panel-footer">
            <div class="text-right">
                {!! $users->render() !!}
            </div>
        </div>
    </div>
</div>
</div>
@endsection


@push('scripts')
<script>
    $(document).ready(function() {
        var elements = $('#documents tbody tr');

        elements = elements.sort(function(a, b) {
            if ($(a).attr('class').indexOf("have_expired_documents") == -1 && $(b).attr('class').indexOf("have_expired_documents") > -1) {
                return 1;
            } else {
                if ($(a).attr('class').indexOf("have_expired_documents") > -1 && $(b).attr('class').indexOf("have_expired_documents") == -1) {
                    return -1;
                }
            }
            return 0;
        });

        $('#documents tbody').html("");

        $.each(elements,function(){
            $('#documents tbody').append(this);
        });
    });
</script>
@endpush