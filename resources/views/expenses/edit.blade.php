@extends('layouts.app')
@section('content')

    <div class="container">
        {!! Form::open(['route' => ['expenses.update', 'id' => $expense->id], 'method' => 'PUT', 'id' => 'form-expenses', 'files' => true]) !!}
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">@lang('titles.edit-expense')</h3>
            </div>
            <div class="panel-body">
                {!! Form::hidden('id', $expense->id)!!}
                @include('expenses.form')
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    <a href="{{url()->previous() == url()->current() ? route('expenses.index') . '?deleted_at=whereNull' : url()->previous()}}" class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        @lang('buttons.back')
                    </a>
                    <button type="submit" class="btn btn-dct" id="btn-save-expense">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        @lang('buttons.save')
                    </button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@include('expenses.modal')

@endsection