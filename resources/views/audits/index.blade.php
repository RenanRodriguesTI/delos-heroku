@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Log</h3>
            </div>
            <div class="panel-body" style="padding: 16px 24px 0 24px;">
                @include('audits.search')
            </div>
            <div class="panel-body">
                @include('audits.med-and-up')
                @include('audits.small-only')
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    {!! $audits->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection