@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-dct">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <h3 class="panel-title bold">Gerenciar Alocações</h3>
                </div>
            </div>
        </div>
        @include('allocations.manager.search')
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered" id='manager-allocations'>
                    <thead>
                        <tr>
                            <th style="min-width:180px;">Projeto</th>
                            <!-- <th style="min-width: 125px;" >Tarefa</th> -->
                            <th>Descrição</th>
                            <th>De</th>
                            <th>Até</th>
                            <th>Horas Orçadas</th>
                            <th>Horas Utilizadas</th>
                            <th>Horas Programadas</th>
                            <th>Horas Restante</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                        <tr class='{{$project->pending_allocations ?"pending_allocations":""}}'>
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
                            <td>{{$project->budget}}</td>
                            <td>{{$project->used_buget}}</td>
                            <td>{{$project->hours_programs}}</td>
                            <td>{{$project->remaining_budget}}</td>
                            <td>
                                <a class="btn open-allocation {{$project->pending_allocations ? 'btn-warning':'btn-dct'}}" data-user='{{route("allocations.usersByProject",["projectId"=>$project->id])}}?manager_task=1'>
                                    <i class="fa fa-plus"></i> Tarefas
                                </a>
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

@include('allocations.manager.list')
@include('allocations.manager.users')
@include('allocations.manager.allocation-tasks')
@include('allocations.tasks.form')
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var elements = $('table#manager-allocations tbody tr');
        elements = elements.sort(function(a, b) {
            if ($(a).attr('class') == '' && $(b).attr('class') == 'pending_allocations') {
                return 1;
            } else {
                if ($(a).attr('class') == 'pending_allocations' && $(b).attr('class') == '') {
                    return -1;
                }
            }
            return 0;
        });

        $('table#manager-allocations tbody').html('');

        $.each(elements, function(index, value) {
            $('table#manager-allocations tbody').append(value)
        });


        $('.open-allocation').click(function() {
            $('#preloader').show();
            $('#status').show();
            $.ajax({
                type: 'GET',
                url: $(this).attr('data-user'),
                success: function(res) {
                    renderUsers(res.users, res.project)
                    $('#user-allocations').modal('show');
                    $('#preloader').hide();
                    $('#status').hide();
                },
                error: function() {
                    $('#preloader').hide();
                    $('#status').hide();
                }
            });
        });
    });

    function renderUsers(users, project) {
        $('.project-description').html(project.compiled_cod + ' - ' + project.description)
        var rows = '';
        for (i = 0; i < users.length; i++) {
            rows += '<tr><td>' + users[i].name + '</td>';
            rows += '<td><button class="btn' + (!users[i].has_task_concludes ? ' btn-warning' : ' btn-dct') + ' show-allocations user-' + users[i].id + '" data-project="' + project.id + '" type="button">Tarefa</button></td></tr>';
        }



        $('#users-table tbody').html(rows);

        $('.show-allocations').click(function() {
            $('#preloader').show();
            $('#status').show();
            if ($(this).attr('class').indexOf("btn btn-warning show-allocations user-") > -1) {
                var user = $(this).attr('class').replace('btn btn-warning show-allocations user-', "")
            } else {
                var user = $(this).attr('class').replace('btn btn-dct show-allocations user-', "")
            }


            $('#sel_user_id').val(user);

            $.ajax({
                method: 'GET',
                dataType: 'JSON',
                url: '/allocations/listByProject/' + $(this).attr('data-project') + '/user/' + user,
                success: function(res) {
                    renderAllocation(res.allocations, res.project);
                    renderTasks(res.tasks);
                    $('#list-allocations').css('z-index', 1000000)
                    $('#list-allocations').modal('show');
                    $('#preloader').hide();
                    $('#status').hide();
                },
                err: function(err) {
                    console.log(err);
                    $('#preloader').hide();
                    $('#status').hide();
                }
            });
        });
    }

    function renderTasks(tasks) {
        var options = '';
        $('#task_id').html('');
        $.each(tasks, function(index, value) {
            options += '<option value="' + index + '">' + value + '</option>';
        });
        $('#task_id').html(options);
        $('#task_id').selectpicker('refresh')
    }

    function renderAllocation(allocations, project) {
        $('.project-description').html(project.compiled_cod + ' - ' + project.description);
        $('#sel_project_id').val(project.id);
        var row = '';
        for (i = 0; i < allocations.length; i++) {
            var budget = allocations[i].project.bugget;
            var extended_budget = allocations[i].extended_budget;
            var hours = 0;

            if (extended_budget) {
                hours = bugget > extended_budget ? bugget : extended_budget;
            } else {
                hours = budget;
            }

            var task = allocations[i].has_task ? '<span class="task-on">Com Tarefas</span>' : '<span class="task-of">Sem Tarefas</span>';
            row += '<tr  data-allocation="' + allocations[i].id + '">' + '<td>' + allocations[i].user.name + '</td><td>' + moment(allocations[i].start).format('DD/MM/Y') + '</td><td>' + moment(allocations[i].finish).format('DD/MM/Y') + '</td><td>' + allocations[i].description + '</td>';
            row += '<td><button class="btn ' + (!allocations[i].concludes ? ' btn-warning' : ' btn-dct') + ' add-tasks" data-allocation="' + allocations[i].id + '" type="button">Tarefa</button></td></tr>';
        }

        $('#allocations-table > tbody').html(row);
        $('.project-details').html('Projeto: ' + project.compiled_cod)


        $('.add-tasks').click(function() {
            var rowSelected = $('#allocations-table tr[data-allocation="' + $(this).attr('data-allocation') + '"] td');

            $('.user-details').html('Colaborador: ' + $(rowSelected[0]).html())
            $('.period-details').html('Período: ' + $(rowSelected[1]).html() + " - " + $(rowSelected[2]).html());
            $('#allocations-form').css('z-index', 1000004)


            $('#allocation-add-task').attr('action', '/allocations/' + $(this).attr('data-allocation') + '/add-tasks');
            $('#saveTasks').attr('type', 'button');

            $('#preloader').show();
            $('#status').show();
            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '/allocations/' + $(this).attr('data-allocation') + '/add-tasks',
                success: function(res) {
                    renderAllocationTasks(res.allocationTasks, res.allocation);
                    $('#preloader').hide();
                    $('#status').hide();
                },
                error: function(err) {
                    console.log(err);
                    $('#preloader').hide();
                    $('#status').hide();
                }
            });
        });

        $('#saveTasks').unbind();
        $('#saveTasks').click(function() {
            saveTask();
        });
    }

    function renderAllocationTasks(allocationsTasks, allocation) {
        var rows = '';
        $.each(allocationsTasks, function() {
            rows += `
                        <tr>
                                <td>${this.task.name}</td>
                                <td>${this.start}</td>
                                <td>${this.finish}</td>
                                <td>${parseInt(this.hours)}</td>
                            </tr>
            `;
            $('#sel_allocation_id').val(this.allocation_id);
            $('.user-name').html(allocation.user.name);

            if (this.concludes == 1) {
                $('.add-allocations-tasks').attr('class', 'btn btn-dct add-allocations-tasks')
            }
        });

        $('.add-allocations-tasks').unbind();
        $('.add-allocations-tasks').click(function() {
            $('#allocations-form').modal('show')
        });

        $('#hours').unbind();
        $('input[name="hours"]').bind('input', function() {
            if ($(this).val() != '' && $('.start').val() != "" && $('.finish').val() !== '') {
                $('#preloader').show();
                $('#status').show();
                $('#saveTasks').attr('disabled', true)
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    url: "/allocations/"+allocation.id+"/checkHoursTask",
                    data: new FormData($('#allocation-add-task')[0]),
                    success: function(res) {
                        if (res.checkHours) {
                            $('#allocations-form .alert-warning p').html(res.checkHours);
                            $('#allocations-form .alert-warning').show();
                        } else {
                            $('#allocations-form .alert-warning').hide();
                        }
                        $('#saveTasks').attr('disabled', false)
                        $('#preloader').hide();
                        $('#status').hide();
                    },
                    error: function(err) {
                        console.log(err);
                        $('#allocations-form .alert-warning').hide();
                        $('#saveTasks').attr('disabled', false);
                        $('#preloader').hide();
                        $('#status').hide();
                    },
                    contentType: false,
                    processData: false
                });
            } else {
                $('#allocations-form .alert-warning').hide();
            }
        });


        $('#allocations-task-table tbody').html(rows);
        $('#list-allocations-tasks').css('z-index', 1000003);
        $('#list-allocations-tasks').modal('show');
    }


    function saveTask() {
        $('#preloader').show();
        $('#status').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: $('#allocation-add-task').attr('action'),
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            data: new FormData($('#allocation-add-task')[0]),
            success: function(res) {
                if (res.allocation) {

                    $.ajax({
                        type: 'GET',
                        dataType: 'JSON',
                        url: '/allocations/' + $('#sel_allocation_id').val() + '/add-tasks',
                        success: function(res) {
                            renderAllocationTasks(res.allocationTasks, res.allocation);
                            $('#preloader').hide();
                            $('#status').hide();
                        },
                        error: function(err) {
                            console.log(err);
                            $('#preloader').hide();
                            $('#status').hide();
                        }
                    });
                }


                $('#allocations-form').modal('hide')
                clear();


            },
            error: function(err) {
                switch (err.status) {
                    case 422:
                        showErrors(err.responseJSON)
                        break;
                    case 500:
                        console.log(err)
                        break;
                    default:
                        console.log(err)
                }
                $('#preloader').hide();
                $('#status').hide();
            }
        });
    }

    function showErrors(errors) {
        if (errors.hours) {
            $('.hoursAllocation .help-block strong').html(errors.hours[0]);
            $('.hoursAllocation').addClass('has-error');
        }

        if (errors.task_id) {
            $('.taskAllocation .help-block strong').html(errors.task_id[0]);
            $('.taskAllocation').addClass('has-error');
        }
    }

    function refreshUsers(project) {
        $('#preloader').show();
        $('#status').show();
        $.ajax({
            type: 'GET',
            url: '/allocations/users-by-project/' + project + '?manager_task=1',
            success: function(res) {

                renderUsers(res.users, res.project)
                $('#user-allocations').modal('show');
                console.log(res)
                $('#preloader').hide();
                $('#status').hide();
            },
            error: function() {
                $('#preloader').hide();
                $('#status').hide();
            }
        });
    }

    function clear() {
        $('#allocation_task_id').val('');
        $('#task_id').selectpicker('val', '');
        $('#hours').val('');
        $('.taskAllocation .help-block strong').html('');
        $('.hoursAllocation .help-block strong').html('');
        $('#concludes').attr('checked', false);
    }


    $('.start').datetimepicker({
      format: 'L',
    });

    $('.finish').datetimepicker({
      format: 'L',
    });


    // A data de inicío será a data mínima
    $(".start").on("dp.change", function(e) {
      $('.finish').data("DateTimePicker").minDate(e.date);

    });

    // A data de fim será a data máxima
    $(".finish").on("dp.change", function(e) {
      $('.start').data("DateTimePicker").maxDate(e.date);
    });
</script>
@endpush