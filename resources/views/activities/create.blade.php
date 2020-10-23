@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Cadastro de Atividades</h3>
            </div>

            <div class="panel-body" style="min-height: 556px;">
                <form action="{{ route('activities.store') }}" method="POST" id="form-create-hours">
                    @csrf()
                    <div class="form-group col-md-10 col-xs-12 {{$errors->has('project_id') ? ' has-error' : ''}}">
                        <label for="activities-project_id">Projeto:</label>

                        <select name="project_id" id="activities-project_id" class="form-control selectpicker"
                                title="Selecione um projeto" data-live-search="true" required>
                            @foreach($projects as $id => $project)
                                <option {{ old('project_id') == $id ? 'selected': '' }} value="{{$id}}">{{$project}}</option>
                            @endforeach
                        </select>
                        <span class="help-block"><strong>{{$errors->first('project_id')}}</strong></span>
                    </div>

                    <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                        {!!
                            Form::label('all', 'Todos:')
                        !!}

                        <input type="checkbox" id='allProjectActivity' data-toggle="toggle" data-on="Sim" data-off="Não">
                    </div>


                    <div class="form-group col-md-6 col-xs-12 {{$errors->has('user_id') ? 'has-error' : ''}}">
                        <label for="user_id">
                            Colaborador:
                            <span title="@lang('tips.colaborator-field')"
                                  class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true"
                                  data-toggle="tooltip" data-placement="top"></span>
                        </label>

                        <select name="user_id[]" id="user_id" class="form-control selectpicker user_id"
                                title="Selecione um ou mais colaboradores" data-live-search="true" required multiple
                                data-actions-box="true">

                        </select>

                        <span class="help-block"><strong>{{$errors->first('user_id')}}</strong></span>
                    </div>

                    <div class="form-group col-md-6 col-xs-12 {{$errors->has('task_id') ? 'has-error' : ''}}">
                        <label for="task_id">
                            Tarefa:
                            <span title="@lang('tips.task-field')"
                                  class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true"
                                  data-toggle="tooltip" data-placement="top"></span>
                        </label>

                        <select name="task_id" id="task_id" class="form-control selectpicker task_id"
                                title="Selecione uma tarefa" data-live-search="true" required>
                        </select>
                        <span class="help-block"><strong>{{$errors->first('task_id')}}</strong></span>
                    </div>

                    <div class="form-group col-md-6 col-xs-12 {{$errors->has('start_date') ? 'has-error' : ''}}">
                        <label for="start_date">Data inicial:</label>

                        <input type="text" name="start_date" id="start_date" class="form-control start_datetimepicker"
                               required value="{{old('start_date', now()->format('d/m/Y'))}}">
                        <span class="help-block"><strong>{{$errors->first('start_date')}}</strong></span>
                    </div>

                    <div class="form-group col-md-6 col-xs-12 {{$errors->has('finish_date') ? 'has-error' : ''}}">
                        <label for="finish_date">Data final:</label>
                        <input type="text" name="finish_date" id="finish_date" class="form-control finsh_datetimepicker"
                               required value="{{old('finish_date', now()->format('d/m/Y'))}}">

                        <span class="help-block"><strong>{{$errors->first('finish_date')}}</strong></span>
                    </div>

                    <div class="form-group col-md-6 col-xs-12 {{$errors->has('hours') ? 'has-error' : ''}}">
                        <label for="hours">Horas:</label>

                        <input type="number" name="hours" id="hours" class="form-control hours" min="1" max="24" step="1"
                               required value="{{old('hours', 8)}}">
                        <span class="help-block"><strong>{{$errors->first('hours')}}</strong></span>
                    </div>

                    <div class="form-group col-md-6 col-xs-12 {{$errors->has('place_id') ? 'has-error' : ''}}">
                        <label for="place_id">Local:</label>

                        <select name="place_id" id="place_id" class="form-control place_id" required>
                            <option value="">Selecione um local</option>
                            @foreach($places as $id => $place)
                                <option {{old('place_id') == $id ? 'selected' : '' }} value="{{$id}}">
                                    {{$place}}
                                </option>
                            @endforeach
                        </select>
                        <span class="help-block"><strong>{{$errors->first('place_id')}}</strong></span>
                    </div>

                    <div class="form-group col-xs-12 {{$errors->has('note') ? 'has-error' : ''}}">
                        <label for="note">Observação:</label>
                        <textarea name="note" id="note" class="form-control" rows="2">{{old('note')}}</textarea>
                        <span class="help-block"><strong>{{$errors->first('note')}}</strong></span>
                    </div>
                </form>
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    <button class="btn btn-dct" onclick="$('#form-create-hours').submit()">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        Salvar
                    </button>

                    <a href="{{url()->previous() == url()->current() ? route('activities.index') . '?deleted_at=whereNull' : url()->previous()}}"
                       class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#hours').unbind();
        });

    </script>
@endpush