@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">

                <div class="row">
                    <div class="col-md-8">
                        <h3 class="panel-title bold">@lang('titles.projects')</h3>
                    </div>
                    <div class="col-md-4 text-right">
                        <span title="@lang('tips.whats-projects')" class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true" data-toggle="tooltip" data-placement="left"></span>
                    </div>
                </div>

            </div>
            @include('messages')
            @can('create-project')
                <div class="panel-body">
                    <a href="{{route('projects.create')}}" class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        @lang('buttons.new-project')
                    </a>
                </div>
            @endcan

            @include('projects.search')

            <div class="panel-body project-content">
                @include('projects.med-and-up')
                @include('projects.small-only')
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    {!! $projects->render() !!}
                </div>
            </div>

        </div>
    </div>
@endsection