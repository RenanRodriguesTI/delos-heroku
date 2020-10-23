@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-dct">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="panel-title bold">Aprovar Horas</h3>
                </div>
            </div>
        </div>
        @include("allocations.manager-approved-hours.search")
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered" id='manager-approve-hours'>
                    <thead>
                        <tr>
                            <th>Projeto</th>
                            <!-- <th style="min-width: 125px;" >Tarefa</th> -->
                            <th>Descrição</th>
                            <th>De</th>
                            <th>Até</th>
                            {{--
                                <th>Horas Orçadas</th>
                                <th>Horas Utilizadas</th>
                                <th>Horas Programadas</th>
                                --}}
                            <th>Horas Restante</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $key =>$project)
                        <tr class="{{$project->has_pending_activities ? 'has_pending_activities': ''}}">
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
                            {{--
                                <td>100</td>
                                <td>30</td>
                                <td>20</td>
                                --}}
                            <td>{{$project->remaining_budget}}</td>
                            <td>
                                <button class="btn {{$project->has_pending_activities ? 'btn-warning':'btn-dct'}}" style='{{$project->has_pending_activities ?"width:100%":""}}' data-user-project="{{$project->id}}">
                                    {{$project->has_pending_activities? 'Horas pendentes': 'Sem horas pendentes' }}
                                </button>
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
@include('allocations.manager-approved-hours.activities')
@include('allocations.manager-approved-hours.users')
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var elements = $('table#manager-approve-hours tbody tr');
        elements = elements.sort(function(a, b) {
            if ($(a).attr('class') == '' && $(b).attr('class') == 'has_pending_activities') {
                return 1;
            } else {
                if ($(a).attr('class') == 'has_pending_activities' && $(b).attr('class') == '') {
                    return -1;
                }
            }
            return 0;
        });

        $('table#manager-approve-hours tbody').html('');

        $.each(elements, function(index, value) {
            $('table#manager-approve-hours tbody').append(value)
        });

        $('button[data-user-project]').click(function() {
            $('#preloader').show();
            $('#status').show();
            var project = $(this).attr('data-user-project');
            getUsersByProject(project);
        });
    });

    function getUsersByProject(project) {
        $.ajax({
            type: 'GET',
            url: '/allocations/users-by-project/' + project,
            success: function(res) {

                renderUsers(res.users, res.project);
                $('#user-approved-hours').modal('show');
                $('#preloader').hide();
                $('#status').hide();
            },
            error: function() {
                $('#preloader').hide();
                $('#status').hide();
            }
        });
    }

    function renderActivities(activities,user) {
        var row = '';

        $('.user-name').html(user.name);
        $.each(activities, function() {

            var dropdown = `<div class="btn-group dropdown"> 
            <button type="button" class="btn btn-default dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    @lang('buttons.options') <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                        <li class="divider"></li>
                                                        @can('reprove-activity')
                                                        <li>
                                                            <a class='reprove-activity activity-${this.id}'>
                                                                Reprovar
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        @endcan

                                                        @can('approve-activity')
                                                            ${!this.approved ? 
                                                                `<li>
                                                                    <a class='approve-activity activity-${this.id}'>
                                                                        @lang('buttons.approve')
                                                                    </a>
                                                                </li>
                                                                <li class="divider"></li>
                                                            `:''}
                                                        @endcan
                                                </ul>
                                        </div>`;
            row += `<tr>
                                <td>${moment(this.date,'Y-MM-DD H:m:s').format('DD/MM/Y')}</td>
                                <td>${this.hours}</td>
                                <td>${this.task.name}</td>
                                <td>${this.place.name}</td>
                                <td>${this.note? this.note: ''}</td>
                                <td>${moment(this.created_at,'Y-MM-DD H:m:s').format('DD/MM/Y')}</td>
                                <td>${this.approved ? "Aprovado":"Aguardando Aprovação"}</td>
                                <td>${dropdown}</td>
            </tr>`;
        });

        $('#manager-activities-table tbody').html(row);

        $('.reprove-activity').click(function() {
            $('#preloader').show();
            $('#status').show();
            var id = $(this).attr('class').split(' ')[1].replace("activity-", "");
            remove(id);

        });
        $('.approve-activity').click(function() {
            $('#preloader').show();
            $('#status').show();
            var id = $(this).attr('class').split(' ')[1].replace("activity-", "");
            approve(id);
        });
        $('#manager-activities').modal('show');
        $('#preloader').hide();
        $('#status').hide();
    }

    function approve(id) {
        $.ajax({
            type: "GET",
            dataType: 'JSON',
            url: `/activities/${id}/approve`,
            success: function(res) {
                if (res.activity) {
                    callByProject(res.activity.project_id, res.activity.user_id)
                }
            },
            error: function(err) {
                console.log(err);
                $('#preloader').hide();
                $('#status').hide();
            }
        });
    }

    function remove(id) {
        $('button.reprove-activity-modal').attr('disabled', true)
       
        $('#reprove-activity').css('z-index', 1000002);
        $('#reprove-activity').modal('show');

        $('#reprove-activity').on('hidden.bs.modal', function() {
           $('#reason_activity_reprove').val('')
           $('button.reprove-activity-modal').attr('disabled', true)
        });

        setTimeout(function(){
            $('#preloader').hide();
            $('#status').hide();
        },800);

        $('#reason_activity_reprove').bind('input', function() {
            var text = $(this).val();
            if (text.length >= 3) {
                $('button.reprove-activity-modal').attr('disabled', false)
            } else {
                $('button.reprove-activity-modal').attr('disabled', true)
            }
        });

        $('button.reprove-activity-modal').click(function() {
            $('#preloader').show();
            $('#status').show();
            $.ajax({
                type: "GET",
                dataType: 'JSON',
                url: `/activities/${id}/reprove?reason=${$('#reason_activity_reprove').val()}`,
                success: function(res) {
                    callByProject(res.activity.project_id, res.activity.user_id);
                    $('#reason_activity_reprove').val('')
                    $('#reprove-activity').modal('hide');
                },
                error: function(err) {
                    console.log(err);
                    $('#preloader').hide();
                    $('#status').hide();
                }
            });
        });

    }

    function callByProject(project, user) {


        $.ajax({
            type: 'GET',
            url: '/activities/get-by-project/' + project + '/user/' + user,
            data: {
                approved: $('[name="approved[]"]').selectpicker('val')
            },
            success: function(res) {
                renderActivities(res.activities,res.user);
            },
            error: function(err) {
                console.log(err);
                $('#preloader').hide();
                $('#status').hide();
            }
        });
    }


    function renderUsers(users, project) {

        users = users.sort(function(a, b) {
            if (!a.has_pending_activities && b.has_pending_activities) {
                return 1;
            } else {
                if (a.has_pending_activities && !b.has_pending_activities) {
                    return -1;
                }
            }

            return 0;
        });
        $('.project-description').html(project.compiled_cod + ' - ' + project.description)
        var rows = '';
        for (i = 0; i < users.length; i++) {
            var button = '<button class="btn ' + (users[i].has_pending_activities ? ' btn-warning' : ' btn-dct') + '"   data-project="' + project.id + '" data-user-id="' + users[i].id + '" data-target="#manager-activity" type="button">Atividades</button>';
            rows += '<tr><td>' + users[i].name + '</td>';
            rows += '<td>' + button + '</td></tr>';
        }
        $('#user-approved-hours-project').val(project.id)


        $('#users-table-approve tbody').html(rows);

        $("button[data-project]").click(function() {
            $('#preloader').show();
            $('#status').show();
            var user = $(this).attr('data-user-id')
            var project = $(this).attr('data-project');
            callByProject(project, user);
            $('#manager-activities').css('z-index', 1000002);
        });
    }
</script>
@endpush