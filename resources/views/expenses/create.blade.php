@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">@lang('titles.create-expense')</h3>
            </div>
            {!! Form::open(['route' => ['expenses.store'], 'method' => 'POST','id' => 'form-expenses', 'files' => true]) !!}
            <div class="panel-body">
                @include('expenses.form')
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    <a href="{{url()->previous() == url()->current() ? route('expenses.index') . '?deleted_at=whereNull' : url()->previous()}}"
                       class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        @lang('buttons.back')
                    </a>
                    <button type="submit" class="btn btn-dct">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        @lang('buttons.save')
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    @include('expenses.modal')

@endsection