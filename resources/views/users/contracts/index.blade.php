<div class="panel-body">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
            @can('create-user')
                <button id="add-contracts" type="button" data-toggle="modal" data-target='#create-contracts' class="btn btn-dct">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Adicionar Contrato
                </button>
            @endcan
            
        </div>
    </div>
    <br>
    <div class="row">
        {{ Form::open(['route' =>['users.contracts','id'=>$user->id],'method'=>'GET']) }}
        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
            {!! Form::label('startfilter', 'Inicio') !!}
            {!! Form::text('startfilter', '', ['class' => 'form-control', 'required']) !!}
            <span class="help-block"><strong>{{$errors->first('startfilter')}}</strong></span>
       </div>

       <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        {!! Form::label('endfilter', 'Fim') !!}
        {!! Form::text('endfilter', '', ['class' => 'form-control', 'required']) !!}
        <span class="help-block"><strong>{{$errors->first('endfilter')}}</strong></span>
       </div>
   
       <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
           <div class="form-group">
               {!! Form::select('contracts', ['' => 'Todos Contratos','whereNotNull' => 'Finalizados', 'whereNull' => 'Ativos'], [
               'class' => 'nopadding selectpicker form-control',
               'data-live-search' => 'true',
               'data-actions-box' => 'true',
               ])!!}
           </div>
       </div>
   
       <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
           <div class="form-group">
               <button type="submit" class="btn btn-dct">
                   Pesquisar
               </button>
           </div>
       </div>
    </div>

    {{ form::close() }}
</div>

<div class="panel-body">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-details">
                <thead>
                    <tr>
                        <th>Data de Inicio</th>
                        <th>Data de Finalização</th>
                        <th>Valor</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>

                    
                    @foreach($user->contracts as $key => $contract)
                        <tr data-user='{{$contract->user_id}}' data-contract='{{$contract->id}}'>
                            <td data-start='{{ $contract->start }}'>{{ $contract->start->format('d/m/Y')}}</td>
                            <td data-end='{{   $contract->end }}'>{{ $contract->end->format('d/m/Y') }}</td>
                            <td data-value='{{ $contract->value }}'> R${{number_format($contract->value,2,',','.')}}</td>
                            <td class="has-btn-group">
                                <div class="btn-group dropdown">
                                    <button data-contract='{{$contract->id}}' type="button" class="btn btn-default btn-sm dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    id="btn-options-users-{{$key}}">
                                <span class="glyphicon glyphicon-cog"></span>
                                    @lang('buttons.options') &nbsp;<span class="caret"></span>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li class="divider"></li>
                                    <li><a href="javascript:void(0);" data-toggle="modal" data-target='#create-contracts'
                                        id="btn-edit-users-{{$key}}">
                                         <span class="glyphicon glyphicon-edit"></span>&nbsp; @lang('buttons.edit')
                                     </a></li>
                                 <li class="divider"></li>

                                 <li><a href="{{route('users.contracts.destroy', ['id' => $contract->id])}}"
                                    id="btn-edit-users-{{$key}}">
                                     <span class="glyphicon glyphicon-trash"></span>&nbsp; @lang('buttons.remove')
                                 </a></li>

                                 <li class="divider"></li>
                                </ul>
                                </div>    
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('users.contracts.form')