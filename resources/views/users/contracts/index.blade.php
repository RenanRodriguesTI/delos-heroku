<div class="panel-body">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
            @can('create-user')
                <button id="add-contracts" data-user='{{ $user->id }}' type="button" data-toggle="modal" data-target='#create-contracts' class="btn btn-dct">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Adicionar Contrato
                </button>
            @endcan
            
        </div>
    </div>
    <br>
    <div class="">
        {{ Form::open(['route' =>['users.contracts','id'=>$user->id],'method'=>'GET','class' => 'display-flex-center-bottom']) }}
        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 startfilter">
            {!! Form::label('startfilter', 'Inicio') !!}
            {!! Form::text('startfilter', null, ['class' => 'form-control', 'required']) !!}
            <span class="help-block"><strong></strong></span>
       </div>

       <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 endfilter">
        {!! Form::label('endfilter', 'Fim') !!}
        {!! Form::text('endfilter', null, ['class' => 'form-control', 'required']) !!}
        <span class="help-block"><strong></strong></span>
       </div>
   
       <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12" style="display:none">
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
               <button id="search" type="button" class="btn btn-dct">
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
            <table id='table-contracts' class="table table-bordered table-hover table-details">
                <thead>
                    <tr>
                        <th>Data de Inicio</th>
                        <th>Data de Finalização</th>
                        <th>Valor</th>
                        <th>Observação</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->contracts as $key => $contract)
                        <tr data-project='{{$contract->projects->pluck("id")}}' data-user='{{ $contract->user_id }}' data-contract='{{$contract->id}}'>
                            <td data-start='{{ $contract->start }}'>{{ $contract->start->format('d/m/Y')}}</td>
                            <td data-end='{{   $contract->end }}'>{{ $contract->end->format('d/m/Y') }}</td>
                            <td data-value='{{ $contract->value }}'> R${{number_format($contract->value,2,',','.')}}</td>
                            <td>{{$contract->note  }}</td>
                            <td class="has-btn-group">
                                <div class="btn-group dropdown">
                                    <button  type="button" class="btn btn-default btn-sm dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    id="btn-options-users-{{$key}}">
                                <span class="glyphicon glyphicon-cog"></span>
                                    @lang('buttons.options') &nbsp;<span class="caret"></span>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li class="divider"></li>
                                    <li><a data-edit='{{$contract->id}}' data-contract='{{$contract->id}}' href="javascript:void(0);" data-toggle="modal" data-target='#create-contracts'
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
<div class="panel-footer">
    <div class="text-right">
        <a href="{{url()->previous() == url()->current() ? route('users.index') . '?deleted_at=whereNull' : url()->previous()}}"
           class="btn btn-default">
            <span class="glyphicon glyphicon-arrow-left"></span>
            Voltar
        </a>
    </div>
</div>

@include('users.contracts.form')


    <style>
        .display-flex-center-bottom{
            display: flex;
            justify-content: flex-start;
            align-items: flex-end;
        }
    </style>
@push('scripts')
    <script>
        $('#search').click(function(){
            $.ajax({
                type:'GET',
                url:'/users/{{$user->id}}/contracts',
                dataType:'JSON',
                data:{
                    startfilter: $('#startfilter').val(),
                    endfilter: $('#endfilter').val()
                },
                success: function(res){
                    $(".startfilter,.endfilter").removeClass('has-error');
                    $('#endfilter .help-block > strong').html("");
                    $('#startfilter .help-block > strong').html("");
                    var linha = '';
                    var locale = 'us';
                        var options = {style: 'currency', currency: 'BRL', minimumFractionDigits: 2, maximumFractionDigits: 2};
                        var formatter = new Intl.NumberFormat(locale, options);
                    if(res.contracts && res.contracts.length >0)
                    $.each(res.contracts,function(){
                       /* linha +='<tr><td>'+
                                '<div class="btn-group dropdown">'+
                                        '<button data-contract='+this.id+' type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
                                            '  <span class="glyphicon glyphicon-cog"></span>'+
                                            ' @lang("buttons.options") &nbsp;<span class="caret"></span>'+
                                            '<ul class="dropdown-menu dropdown-menu-right"><li class="divider"></li>'+
                                                ''+
                                            '<li class="divider"></li></ul>'+
                                            '  </button>'+
                                '</div></td>'
    
                            
                            '</tr>';*/
                        var start = moment(this.start.split(' ')[0],'Y-M-D').format('DD/MM/Y');
                        var end = moment(this.end.split(' ')[0],'Y-M-D').format('DD/MM/Y');
                        
                        linha +=`<tr data-user='${this.user_id}' data-contract='${this.id}'>
                            <td data-start='${start}'>${start}</td>
                            <td data-end='${end}'>${end}</td>
                            <td data-value='${this.value}'> ${formatter.format(this.value)}</td>
                            <td>${this.note}</td>
                            <td><div class="btn-group dropdown">
                            <button data-contract='${this.id}' type="button" class="btn btn-default btn-sm dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            id="btn-options-users-${this.id}">
                        <span class="glyphicon glyphicon-cog"></span>
                            @lang('buttons.options') &nbsp;<span class="caret"></span>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="divider"></li>
                            <li><a data-edit='${this.id}'  data-contract='${this.id}' href="javascript:void(0);" data-toggle="modal" data-target='#create-contracts'
                                id="btn-edit-users-${this.id}">
                                 <span class="glyphicon glyphicon-edit"></span>&nbsp; @lang('buttons.edit')
                             </a></li>
                         <li class="divider"></li>

                         <li><a href="${this.id}"
                            id="btn-edit-users-${this.id}">
                             <span class="glyphicon glyphicon-trash"></span>&nbsp; @lang('buttons.remove')
                         </a></li>

                         <li class="divider"></li>
                        </ul>
                        </div></td></tr>`;
                    });

                    $('#table-contracts > tbody').html(linha);
                },
                error: function(err){
                    console.log(err);

                    if(err.responseJSON.errors){
                        var errors = err.responseJSON.errors;
                        $(".startfilter,.endfilter").removeClass('has-error');
                        
                        $('#endfilter .help-block > strong').html("");
                        $('#startfilter .help-block > strong').html("");
                        Object.keys(errors).forEach(function(error){
                          if(errors[error][0]){
                            $(".startfilter,.endfilter").addClass('has-error');
                            $('#'+error+' ~ .help-block > strong').html(errors[error][0]);
                          }
                        });
                      }
                }
            });
        });
        

    
    $("#startfilter").daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        },
        "singleDatePicker": true,
    });

    $("#endfilter").daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        },
        "singleDatePicker": true,
    });
    $('#startfilter').val('');
    $('#endfilter').val('');
    </script>
@endpush