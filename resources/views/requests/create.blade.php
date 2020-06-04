@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" id="form-requests" action="{{route('requests.store')}}">
            {{csrf_field()}}
            <div class="panel panel-dct">
                <div class="panel-heading">
                    <h1 class="panel-title bold">Nova Solicitação</h1>
                </div>
                <div class="panel-body" data-without-height="true">
                    <div class="row">                       
                        <div class="col-sm-6 col-xs-12">
                            {{--Data de início da solicitação--}}
                            <div class="form-group {{$errors->has("request[start]")  ? ' has-error' : ''}}">
                                {!! Form::label("start", 'Data de início') !!}

                                {!! Form::text("request[start]", null, ['class' => 'form-control', 'id' => 'start', 'placeholder' => '__/__/____', 'data-mask' => '00/00/0000', 'required']) !!}

                                <span class="help-block">
                                    <strong>{{$errors->first("request[start]")}}</strong>
                                </span>
                            </div>
                            {{--/Data de início--}}
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            {{--Data de término da solicitação--}}
                            <div class="form-group {{$errors->has("request[finish]") ? 'has-error' : ''}}">
                                {!! Form::label("finish", 'Data de fim') !!}

                                {!! Form::text("request[finish]", null, ['class' => 'form-control', 'id' => 'finish','placeholder' => '__/__/____', 'data-mask' => '00/00/0000', 'required']) !!}

                                <span class="help-block">
                                    <strong>{{$errors->first("request[finish]")}}</strong>
                                </span>
                            </div>
                            {{--/Data de término da solicitação--}}
                        </div>

                        <div class="col-sm-10 col-xs-12">
                            {{--Projeto da solicitação--}}
                            <div class="form-group project-group {{$errors->has("request[project_id]") ? ' has-error' : ''}}">
                                <label for="project_id">Projeto</label>
                                <select name="request[project_id]" id="project_id" class="selectpicker form-control"
                                        data-live-search="true" data-actions-box="true" title="Selecione um projeto"
                                        required="required">
                                </select>
                                <span class="help-block"><strong>{{$errors->first("request[project_id]")}}</strong></span>
                            </div>
                            {{--/Projeto da solicitação--}}
                        </div>

                        <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                        {!!
                            Form::label('all', 'Todos:')
                        !!}

                        <input type="checkbox" id='allRequest' data-toggle="toggle" data-on="Sim" data-off="Não">
                    </div>

                        <div class="col-sm-6 col-xs-12">
                            {{--Colaboradores da solicitação--}}
                            <div class="form-group collaborators-group {{$errors->has("request[collaborators]") ? ' has-error' : ''}}">
                                <label for="collaborators">Colaboradores</label>
                                <select name="request[collaborators][]" id="collaborators"
                                        class="selectpicker form-control"
                                        title="Selecione os colaboradores" data-live-search="true" multiple="multiple"
                                        required>
                                </select>
                                <span class="help-block"><strong>{{$errors->first("request[collaborators]")}}</strong></span>
                            </div>
                            {{--/Projeto da solicitação--}}
                        </div>

                        <div class="col-xs-12">

                            {{--Observação da solicitação--}}
                            <div class="form-group {{$errors->has("request[notes]") ? ' has-error' : ''}}">
                                {!! Form::label("text", 'Observação:') !!}
                                {!! Form::textarea("request[notes]", null, ['class' => 'form-control', 'id' => 'text', 'rows' => '2', 'maxlength' => '255', 'placeholder' => '---']) !!}                                
                                <span class="pull-right label label-default count_message"></span>
                                <span class="help-block"><strong>{{$errors->first("request[notes]")}}</strong></span>
                            </div>
                            {{--/Observação da solicitação--}}
                        </div>
                    </div>
                </div>
            </div>

            {{--Aplica filtro para os campos caso haja--}}
            @if(app('request')->get('has-filter'))
                @if(app('request')->get('tickets'))
                    @include('requests.create.tickets')
                @endif

                @if(app('request')->get('lodgings'))
                    @include('requests.create.lodgings')
                @endif

                @if(app('request')->get('cars'))
                    @include('requests.create.car')
                @endif

                @if(app('request')->get('extras'))
                    @include('requests.create.extra-expenses')
                @endif
            @else
                @include('requests.create.tickets')
                @include('requests.create.lodgings')
                @include('requests.create.car')
                @include('requests.create.extra-expenses')
            @endif

            <div class="panel-footer">
                <div class="text-right">
                    <a href="{{route('requests.index')}}?deleted_at=whereNull" class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        Voltar
                    </a>

                    <button type="submit" class="btn btn-dct">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        Salvar
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
