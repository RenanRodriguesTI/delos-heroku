@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-dct">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="panel-title bold">Recursos</h3>
                </div>
            </div>
        </div>
        @include('resources.search')
        <div class="panel-body">

            <div class="table-responsive" style="min-height: 390px;">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Horas Disponíveis</th>
                            <th>Ação</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                        <tr class="resource-{{$user->id}}">
                            <td>{{$user->name}}</td>
                            <td>{{$user->getHours()}}</td>
                            <td>
                                @if($user->situation_resource == "avaliable")
                                    <a  class="btn btn-dct resources">
                                        Alocar
                                    </a>
                                    
                                    @else
                                        @if($user->situation_resource == "partial")
                                            <a class="btn btn-warning resources">
                                                Alocar
                                            </a>
                                            @else
                                            <button disabled   class="btn btn-danger">
                                                Alocar
                                            </button>
                                        @endif 
                                @endif

                                @if($user->has_details)
                                    <button  type="button" data-resource-id='{{$user->id}}' data-resource="{{route('resources.show',['id'=>$user->id])}}"  class="btn btn-dct">
                                        Detalhes
                                    </button>
                                @endif
                                
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel-footer">
            <div class="text-right">
                {{$users->render()}}
            </div>
        </div>
    </div>
</div>

@include("resources.situation")
@endsection


@push("scripts")
<script>
    $('button[data-resource-id]').click(function() {
        $('#preloader').show();
        $('#status').show();
        var id = $(this).attr('data-resource-id');
        var name = $($(`tr.resource-${id} td`)[0]).html();
        $('.resources-description').html(name);
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: $(this).attr('data-resource'),
            data: {
                start: $('#start').val(),
                finish: $('#finish').val()
            },
            success: function(res) {
                $.each(res,function(){
                    renderDetails(this);
                });
                $('#resource-situation').modal('show');
                $('#preloader').hide();
                $('#status').hide();
            }, error:function(err){
                console.log(err);
                $('#preloader').hide();
                $('#status').hide();
            }
        });
    });

    function renderDetails(project){
        var row = "";
        var element = `
                <h2 class="accordion">${project.compiled_cod} - ${project.description}</h2>
                <div class="table-responsive double-scroll">
                        <table class="table table-bordered project-${project.id}">
                            <thead>
                                <tr>
                                    <th>Tarefa</th>
                                    <th>De</th>
                                    <th>Até</th>
                                    <th>Horas</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                    </div>
            `;
        $.each(project.tasks,function(){
            
            row += `
                <tr>
                        <td>${this.name}</td>
                        <td>${moment(this.start,'Y-M-D').format('DD/MM/Y')}</td>
                        <td>${moment(this.finish,'Y-M-D').format('DD/MM/Y')}</td>
                        <td>${parseInt(this.hours)}</td>
                </tr>
            `;
        });

        $('#projects').html("");
        $('#projects').append(element);
        
        $(`.project-${project.id} tbody`).html(row);
    }

    $('a.resources').click(function(){
        swal({
            icon:'info',
            title:'Atenção',
            text:'A função selecionada em breve estará disponível.'
        });
    });
</script>
@endpush