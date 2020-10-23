<div class="panel-body">

    <div class="row">
        <div class="form-group col-md-4 col-xs-12 {{$errors->has('cod') ? 'has-error' : ''}}">
            <label for="cod">Código:</label>
            <span title="@lang('tips.projects-cod-field')" class="glyphicon glyphicon-question-sign black-tooltip"
                  aria-hidden="true" data-toggle="tooltip" data-placement="right"></span>

            <input type="text" class="form-control" name="cod" id="cod" maxlength="255" placeholder="Digite um código ou vazio para geração automática" value="{{$project->cod}}">
            <span class="help-block"><strong>{{$errors->first('cod')}}</strong></span>
        </div>

        <div class="form-group col-md-8 col-xs-12 {{$errors->has('description') ? 'has-error' : ''}}">
            <label for="description">Descrição:</label>
            <span title="@lang('tips.projects-desc-field')" class="glyphicon glyphicon-question-sign black-tooltip"
                  aria-hidden="true" data-toggle="tooltip" data-placement="right"></span>
            <input type="text" class="form-control" name="description" id="description" placeholder="Digite uma descrição ou vazio para geração automática" maxlength="255" value="{{$project->description}}">
            <span class="help-block"><strong>{{$errors->first('cod')}}</strong></span>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-4 col-xs-12 {{$errors->has('company_id') ? 'has-error' : ''}}">
            <label for="company_id">Empresa:</label>
            <span title="@lang('tips.projects-companies')" class="glyphicon glyphicon-question-sign black-tooltip"
                  aria-hidden="true" data-toggle="tooltip" data-placement="right"></span>

            <select name="company_id" id="company_id" class="form-control" required data-live-search="true" data-actions-box="true" title="Selecione uma empresa">
                @foreach($companies as $id => $company)
                    @if($id == $project->company_id)
                        <option selected value="{{$id}}">{{$company}}</option>
                    @else
                        <option value="{{$id}}">{{$company}}</option>
                    @endif
                @endforeach
            </select>
            <span class="help-block"><strong>{{$errors->first('company_id')}}</strong></span>
        </div>

        <div class="form-group col-md-4 col-xs-12 {{$errors->has('financial_rating_id') ? 'has-error' : ''}}">
            <label for="financial_rating_id">CF</label>
            <span title="@lang('tips.projects-financial-rating')"
                  class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true" data-toggle="tooltip"
                  data-placement="top"></span>

            <select name="financial_rating_id" id="financial_rating_id" class="form-control" required data-actions-box="true" title="Selecione uma classificação financeira">
                @foreach($frs as $id => $financialRating)
                    @if($id == $project->financial_rating_id)
                        <option selected value="{{$id}}">{{$financialRating}}</option>
                    @else
                        <option value="{{$id}}">{{$financialRating}}</option>
                    @endif
                @endforeach
            </select>
            <span class="help-block"><strong>{{$errors->first('financial_rating_id')}}</strong></span>
        </div>

        <div class="form-group col-md-4 col-xs-12 {{$errors->has('project_type_id') ? 'has-error' : ''}}">
            <label for="project_type_id">Tipo:</label>
            <span title="@lang('tips.projects-type')" class="glyphicon glyphicon-question-sign black-tooltip"
                  aria-hidden="true" data-toggle="tooltip" data-placement="right"></span>

            <select name="project_type_id" id="project_type_id" title="Selecione um tipo de projeto" class="selectpicker form-control" data-live-search="true" required>
                @foreach($projectTypes as $id => $projectType)
                    @if($id == $project->project_type_id)
                        <option selected value="{{$id}}">{{$projectType}}</option>
                    @else
                        <option value="{{$id}}">{{$projectType}}</option>
                    @endif
                @endforeach
            </select>
            <span class="help-block"><strong>{{$errors->first('project_type_id')}}</strong></span>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-4 col-xs-12 {{$errors->has('owner_id') ? 'has-error' : ''}}">
            <label for="owner_id">Líder:</label>
            <select name="owner_id" id="owner_id" title="Selecione um líder" class="selectpicker form-control" data-live-search="true" required>
                @foreach($users as $id => $user)
                    @if($id == $project->owner_id)
                        <option selected value="{{$id}}">{{$user}}</option>
                    @else
                        <option value="{{$id}}">{{$user}}</option>
                    @endif
                @endforeach
            </select>
            <span class="help-block"><strong>{{$errors->first('owner_id')}}</strong></span>
        </div>

        <div class="form-group col-md-4 col-xs-12 {{$errors->has('co_owner_id') ? 'has-error' : ''}}">
            <label for="co_owner_id">Co-líder:</label>
            <select name="co_owner_id" id="co_owner_id" class="selectpicker form-control" data-live-search="true">
                <option value="">Selecione um co-líder</option>
                @foreach($users as $id => $user)
                    @if($id == $project->co_owner_id)
                        <option selected value="{{$id}}">{{$user}}</option>
                    @else
                        <option value="{{$id}}">{{$user}}</option>
                    @endif
                @endforeach
            </select>
            <span class="help-block"><strong>{{$errors->first('co_owner_id')}}</strong></span>
        </div>

        <div class="form-group col-md-4 col-xs-12 {{$errors->has('client_id') ? 'has-error' : ''}}">
            <label for="client_id">Cliente responsável:</label>
            <span title="@lang('tips.projects-client')" class="glyphicon glyphicon-question-sign black-tooltip"
                  aria-hidden="true" data-toggle="tooltip" data-placement="right"></span>

            <select name="client_id" id="client_id" class="selectpicker form-control" data-live-search="true" title="Selecione um cliente">
                @if(!$usersRoleClient->count())
                    <option value="">Você não possui usuários com perfil cliente</option>
                @endif
                @foreach($usersRoleClient as $id => $userRoleClient)
                    @if($id == $project->client_id)
                        <option selected value="{{$id}}">{{$userRoleClient}}</option>
                    @else
                        <option value="{{$id}}">{{$userRoleClient}}</option>
                    @endif
                @endforeach
            </select>
            <span class="help-block"><strong>{{$errors->first('client_id')}}</strong></span>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-4 col-xs-12">
            <label for="group_id">Grupo:</label>
            <select name="group_id" id="group_id" title="Selecione um grupo" class="selectpicker form-control groups-select" data-actions-box="true" data-live-search="true" required>
                @foreach($groups as $id => $group)
                    @if($id == $selectedGroup)
                        <option selected value="{{$id}}">{{$group}}</option>
                    @else
                        <option value="{{$id}}">{{$group}}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-8 col-xs-12 {{$errors->has('clients') ? 'has-error' : ''}}">
            <label for="clients[]">Cliente:</label>
            <span title="@lang('tips.projects-customer')" class="glyphicon glyphicon-question-sign black-tooltip"
                  aria-hidden="true" data-toggle="tooltip" data-placement="right"></span>

            <select name="clients[]" id="clients[]" title="Selecione os clientes do projeto" class="form-control clientes-select selectpicker" multiple data-actions-box="true" data-live-search="true" required>
                @foreach($clients as $id => $client)
                    @if(in_array($id, $selectedClients))
                        <option selected value="{{$id}}">{{$client}}</option>
                    @else
                        <option value="{{$id}}">{{$client}}</option>
                    @endif
                @endforeach
            </select>
            <span class="help-block"><strong>{{$errors->first('clients')}}</strong></span>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-6 col-xs-12 {{$errors->has('seller_id') ? 'has-error' : ''}}">
            <label for="seller_id">Comercial:</label>
            <select name="seller_id" id="seller_id" class="form-control" data-live-search="true">
                <option value="">Selecione o comercial</option>
                @foreach($users as $id => $user)
                    @if($project->seller_id == $id)
                        <option selected value="{{$id}}">{{$user}}</option>
                    @else
                        <option value="{{$id}}">{{$user}}</option>
                    @endif
                @endforeach
            </select>

            <span class="help-block">
                <strong>{{$errors->first('seller_id')}}</strong>
            </span>
        </div>

        <div class="form-group col-md-6 col-xs-12 {{$errors->has('commission') ? 'has-error' : ''}}">
            <label for="commission">Comissão:</label>
            <input type="text" name="commission" id="commission" class="form-control" data-mask="##0.00" data-mask-reverse="true" value="{{$project->commission}}"/>
            <span class="help-block">
                <strong>{{$errors->first('commission')}}</strong>
            </span>
        </div>

    </div>

    <div class="row">
        <div class="form-group col-md-3 col-xs-12 {{$errors->has('budget') ? 'has-error' : ''}}">
            <label for="budget">Orçamento (horas):</label>
            <span title="@lang('tips.projects-budget')" class="glyphicon glyphicon-question-sign black-tooltip"
                  aria-hidden="true" data-toggle="tooltip" data-placement="top"></span>
            <input type="text" name="budget" id="budget" class="form-control" required value="{{$project->budget}}" data-mask="0#">
            <span class="help-block"><strong>{{$errors->first('budget')}}</strong></span>
            @if(isset($project))
                @can('edited-hours-per-task-project')
                    <a href="#" onclick="$('#tasks_modal').modal('show');">Visualizar orçamento de tarefa</a>
                @endcan
            @endif
        </div>

        <div class="form-group col-md-3 col-xs-12 {{$errors->has('extended_budget') ? 'has-error' : ''}}">
            <label for="extended_budget">Orçamento Prorrogado (horas):</label>
            <input type="text" name="extended_budget" id="extended_budget" class="form-control" value="{{$project->extended_budget}}" data-mask="0#">
            <span class="help-block"><strong>{{$errors->first('extended_budget')}}</strong></span>
        </div>

        <div class="form-group col-md-3 col-xs-12 {{$errors->has('proposal_number') ? 'has-error' : ''}}">
            <label for="proposal_number">Número da proposta:</label>
            <span title="@lang('tips.projects-proposal')" class="glyphicon glyphicon-question-sign black-tooltip"
                  aria-hidden="true" data-toggle="tooltip" data-placement="top"></span>
            <input type="text" name="proposal_number" id="proposal_number" class="form-control" value="{{$project->proposal_number}}">
            <span class="help-block"><strong>{{$errors->first('proposal_number')}}</strong></span>
        </div>

        <div class="form-group col-md-3 col-xs-12 {{$errors->has('proposal_value') ? 'has-error' : ''}}">
            <label for="proposal_value">Valor da proposta:</label>
            <span title="@lang('tips.projects-value')" class="glyphicon glyphicon-question-sign black-tooltip"
                  aria-hidden="true" data-toggle="tooltip" data-placement="top"></span>

            <div class="input-group">
                <div class="input-group-addon">R$</div>
                <input type="text" name="proposal_value" id="proposal_value" class="form-control" data-mask="##0.00" data-mask-reverse="true" required value="{{ $project->proposal_value }}" >
            </div>
            <span class="help-block"><strong>{{$errors->first('proposal_value')}}</strong></span>
        </div>

    </div>

    <div class="row">

        <div class="form-group col-md-3 col-xs-12 {{$errors->has('extra_expenses') ? 'has-error' : ''}}">
            <label for="extra_expenses">Despesas Orçadas:</label>
            <span title="@lang('tips.projects-extra-expenses')" class="glyphicon glyphicon-question-sign black-tooltip"
                  aria-hidden="true" data-toggle="tooltip" data-placement="top"></span>

            <div class="input-group">
                <div class="input-group-addon">R$</div>
                <input type="text" name="extra_expenses" id="extra_expenses" class="form-control" data-mask="##0.00" data-mask-reverse="true" value="{{ $project->extra_expenses }}">
            </div>
            <span class="help-block"><strong>{{$errors->first('extra_expenses')}}</strong></span>
        </div>
        <div class="form-group col-md-3 col-xs-12 {{$errors->has('start') ? ' has-error' : ''}}">
            <label for="start">Início:</label>
            <input type="text" name="start" id="start" class="form-control start_datetimepicker_1" required placeholder="Digite a data de início do projeto" value="{{$project->start->format('d/m/Y')}}">
            @if($errors->has('start'))
                <span class="help-block">
                <strong>{{$errors->first('start')}}</strong>
            </span>
            @endif
        </div>

        <div class="form-group col-md-3 col-xs-12 {{$errors->has('finish') ? ' has-error' : ''}}">
            <label for="finish">Data Estimada Orçada:</label>
            <input type="text"
                    name="finish"
                   id="finish"
                   placeholder="Digite a data de encerramento do projeto"
                   class="form-control finsh_datetimepicker_1"
                   required
                   value="{{$project->finish->format('d/m/Y')}}"
                   {{ !$accepted ? 'readonly' : '' }}
            />
            @if($errors->has('finish'))
                <span class="help-block">
                    <strong>{{$errors->first('finish')}}</strong>
                </span>
            @endif
        </div>

       
        <div class="form-group col-md-3 col-xs-12" style='display:none'>
            <label>Finalização Real</label>
            <input type="text"
                   class="form-control"
                   value="{{!isset($project->deleted_at)?'Não Finalizado':$project->deleted_at->format('d/m/Y')}}"
                  readonly
            />
        </div>

        <div class="form-group col-md-3 col-xs-12">
            <label>Data de Prorrogação</label>
            <input {{!$project->id ? "disabled":""}} type="text" name="extension" autocomplete='off' id="extension" class="form-control extension_datetimepicker_1" placeholder="Digite a data de prorrogação do projeto" value="{{$project->extension ? $project->extension->format('d/m/Y'): ''}}">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-xs-12 {{$errors->has('notes') ? ' has-error' : ''}}">
            <label for="text">Observação</label>
            <textarea name="notes" id="text" class="form-control" rows="3" maxlength="255">{{$project->notes}}</textarea>
            <span class="pull-right label label-default count_message"></span>
            <span class="help-block"><strong>{{$errors->first('notes')}}</strong></span>
        </div>
    </div>
</div>
<div class="panel-footer">
    <div class="text-right">
        <a href="{{url()->previous() == url()->current() ? route('projects.index') . '?deleted_at=whereNull' : url()->previous()}}"
           class="btn btn-default">
            <span class="glyphicon glyphicon-arrow-left"></span>
            Voltar
        </a>
        <button name="save" type="submit" class="btn btn-dct">
            <span class="glyphicon glyphicon-floppy-disk"></span>
            Salvar
        </button>
    </div>
</div>

@if((isset($action) && ($action == 'created' || $action == 'edited')))
    @can("{$action}-hours-per-task-project")
@section('projects.tasks.total')
    <span class="bold bind-budget" style="color: #fff;">{{$project->budget}}</span>
@endsection
@section('projects.tasks.content')
    {!! Form::open(['route' => ['projects.tasks.store', 'id' => $project->id], 'method' => 'PUT', 'id' => 'form-project-tasks']) !!}
    <table class="table-responsive table-striped table">
        @foreach($tasks as $task)
            <tr>
                <td>
                    {!! Form::label("tasks-{$task->id}", $task->name, ['class' => 'bold']) !!}
                </td>
                <td>
                    {!! Form::number("hour_task[{$task->id}]", $task->pivot->hour ?? null, ['class' => 'form-control hour_task', 'min'=> '1', 'required', 'id' => "tasks-{$task->id}"]) !!}
                </td>
            </tr>
        @endforeach
    </table>
    <input type="hidden" name="hours-per-task" id="hours-per-task" value="{{$action}}">
    {!! Form::close() !!}
@endsection
@endcan
@cannot("{$action}-hours-per-task-project")
    <input type="hidden" id="cannot-add-hours-per-task" value="true">
@endcannot
@endif


@push('scripts')
    <script>
        $('.extension_datetimepicker_1').daterangepicker({
            locale: {
            format: 'DD/MM/YYYY'
        },
        "singleDatePicker": true,
        'minDate': '{{isset($minDateExtension->format) ? $minDateExtension->format('d/m/Y') :''}}'
        });

        @if(!$project->extension)
        $('.extension_datetimepicker_1').val('');
        @endif
    </script>
@endpush