@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {{ Form::open(array('url' => 'import/upload','method' => 'post','enctype'=>'multipart/form-data')) }}
                        {{ Form::label('file', 'Arquivo') }}
                        {{ Form::file('file', []) }}
                        {{ Form::submit('Enviar') }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
@endsection

