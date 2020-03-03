@extends('layouts.app')
@section('content')

<div class="container">
    <div class="panel panel-dct">
        <div class="panel-heading">
            <h3 class="panel-title bold">@lang('titles.change-password')</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(['route' => 'users.changePassUpdate', 'id' => 'change-pass-form']) !!}


            <div class="{{session('message') ? 'alert alert-success' : ''}}">
            @if(session('message'))
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            @endif
                {{session('message')}}
            </div>            <div class="form-group {{$errors->has('password') ? 'has-error' : ''}}">

                {!! Form::password('password', [
                'class' => 'form-control',
                'placeholder' => 'Digite sua nova senha'
                ]) !!}

                <span class="help-block"><strong>{{$errors->first('password')}}</strong></span>
            </div>

            <div class="form-group {{$errors->has('password_confirmation') ? 'has-error' : ''}}">
                {!! Form::password('password_confirmation', [
                'class' => 'form-control',
                'placeholder' => 'Confirme sua nova senha'
                ]) !!}
                <span class="help-block"><strong>{{$errors->first('password_confirmation')}}</strong></span>
            </div>

        </div>
        <div class="panel-footer">
            <div class="text-right">
                <button type="submit" class="btn btn-dct">
                    <span class="glyphicon glyphicon-floppy-disk"></span>
                    Salvar
                </button>
            </div>
        </div>
        {!! Form::close() !!}

    </div>
</div>
@endsection