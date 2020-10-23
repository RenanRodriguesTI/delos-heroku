@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-dct">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="panel-title bold">Aprovar Despesas</h3>
                </div>
            </div>
        </div>
        @include("allocations.manager-expenses.search")
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Projeto</th>
                            <!-- <th style="min-width: 125px;" >Tarefa</th> -->
                            <th>Descrição</th>
                            <th>De</th>
                            <th>Até</th>
                            <th>Horas Restante</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $key =>$project)
                        <tr>
                            <td>{{$project->compiled_cod}}</td>
                            <td>{{$project->description}}</td>
                            <td>{{$project->start->format('d/m/Y')}}</td>
                            @if($project->extension)
                            @if($project->extension->lessThan($project->finish))
                            <td>{{$project->finish->format('d/m/Y')}}</td>
                            @else
                            <td>{{$project->extension->format('d/m/Y')}}</td>
                            @endif
                            @else
                            <td>{{$project->finish->format('d/m/Y')}}</td>
                            @endif
                            <td>{{$project->remaining_budget}}</td>
                            <td>

                                <div class="btn-group {{$key<=3 ? 'dropdown':'dropup'}}">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="btn-options-users-{{$key}}">
                                        <span class="glyphicon glyphicon-cog"></span>
                                        @lang('buttons.options') &nbsp;<span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">

                                        <li class="divider"></li>
                                        <li>
                                            <a data-project="{{$project->id}}" data-target='#manager-expenses'>
                                                Despesas
                                            </a>
                                        </li>



                                        <li class='divider'></li>
                                    </ul>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel-footer text-right">
            {{$projects->render()}}
        </div>
    </div>
</div>

@include('allocations.manager-expenses.expenses')
@endsection

@push('scripts')
<script>
    $("a[data-project]").click(function() {
        $('#preloader').show();
        $('#status').show();
        var project = $(this).attr('data-project');
        callByProject(project);
    });

    function callByProject(project){
        $.ajax({
            type:'GET',
            url:'/expenses',
            dataType:'JSON',
            data:{
                approved: $('[name="approved[]"]').selectpicker('val'),
                manager:'1',
                project: project
            },
            success:function(res){
               renderExpenses(res.data);
            },
            error:function(err){
                console.log(err);
                $('#preloader').hide();
                $('#status').hide();
            }
        });
    }

    function renderExpenses(expenses){
        console.log(expenses);
        var row = '';
        $.each(expenses,function(){
            var dropdown = `<div class="btn-group dropdown"> 
            <button type="button" class="btn btn-default dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    @lang('buttons.options') <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                        <li class="divider"></li>
                                                        @can('manager-approve-expense')
                                                        ${this.approved == "Aprovado" ? 
                                                                ` <li>
                                                                    <a class='reprove-expense expense-${this.id}'>
                                                                        Reprovar
                                                                    </a>
                                                                  </li>
                                                                  <li class="divider"></li>
                                                            `:''}
                                                      
                                                        @endcan

                                                        @can('manager-reprove-expense')
                                                            ${this.approved == "Não Aprovado" ? 
                                                                `<li>
                                                                    <a class='approve-expense expense-${this.id}'>
                                                                        @lang('buttons.approve')
                                                                    </a>
                                                                </li>
                                                                <li class="divider"></li>
                                                            `:''}
                                                        @endcan
                                                </ul>
                                        </div>`;
            row += `<tr>
                                <td>${this.collaborator}</td>
                                <td>${this.issue_date}</td>
                                <td>${this.project.split(" - ")[0]}</td>
                                <td>${this.request}</td>
                                <td>${this.invoice}</td>
                                <td>R$ ${this.value}</td>
                                <td>${this.payment_type}</td>
                                <td>${this.description}</td>
                                <td>${this.approved}</td>
                                <td>${this.exported}</td>
                                <td>${dropdown}</td>
            </tr>`
        });

        $('#manager-expenses-table tbody').html(row);


        $('.reprove-expense').click(function(){
            $('#preloader').show();
            $('#status').show();
            var id = $(this).attr('class').split(' ')[1].replace("expense-","");
            reprove(id);
        });

        $('.approve-expense').click(function(){
            $('#preloader').show();
            $('#status').show();
            var id = $(this).attr('class').split(' ')[1].replace("expense-","");
            approve(id);
        });

        $('#preloader').hide();
        $('#status').hide();

        $('#manager-expenses').modal('show');
    }

    function approve(id){
        $.ajax({
                type:'GET',
                dataType:'JSON',
                url:'/expenses/'+id+'/manager-approve',
                success:function(res){

                    
                    callByProject(res.approved_expense.project_id)
                    $('#preloader').hide();
                    $('#status').hide();
                },
                error:function(err){
                    $('#preloader').hide();
                    $('#status').hide();
                }
            });
    }
    
    function reprove(id){
        $.ajax({
                type:'GET',
                dataType:'JSON',
                url:'/expenses/'+id+'/manager-reprove',
                success:function(res){
                    callByProject(res.reproved_expense.project_id)
                    $('#preloader').hide();
                    $('#status').hide();
                },
                error:function(err){
                    $('#preloader').hide();
                    $('#status').hide();
                }
            });
    }
</script>
@endpush