$(document).ready(function () {

    buttonAddTask();

    if ( $('#form-allocation').length ) {
        //Caso haja projeto selecionado aplicar alterações para seus respectivos inputs
        if ( $('#project_id').val() ) {
            changeInputsOfProjects();
        }

        //Adiciona o valor do user_id no user_id_old
        $('#user_id').change(function () {
            $('#user_id_old').val($(this).val());
        });

        //Adiciona o valor do task_id no task_id_old
        $('#task_id').change(function () {
            $('#task_id_old').val($(this).val());
        });

        //Date picker início da alocação
        $('#start').datetimepicker({
            format: 'L',
        });

        //Date picker fim da alocação da alocação

        if($('#finish').val()){
            $('#finish').datetimepicker({
                format:        'L',
                useCurrent:    false,
            });
        } else{
            $('#finish').datetimepicker({
                format:        'L',
                useCurrent:    false,
                minDate:       moment().subtract(1, 'days'),
                disabledDates: [
                    moment().subtract(1, 'days')
                ]
            });
        }
       

        // A data de inicío será a data mínima
        $("#start").on("dp.change", function (e) {
            $('#finish').data("DateTimePicker").minDate(e.date);
            calcHours();
            buttonAddTask();
        });

        // A data de fim será a data máxima
        $("#finish").on("dp.change", function (e) {
            $('#start').data("DateTimePicker").maxDate(e.date);
            calcHours();
            buttonAddTask();
        });

        // Scripts quando o select de projeto for alterado o valor
        $('#project_id').change(function (event) {
            changeInputsOfProjects(event);
            buttonAddTask();
        });

        $('#hourDay').keyup(function(){
            calcHours();
            buttonAddTask();
        });

        $('#jobWeekEnd').change(function(){
            calcHours();
        });

        $('#hours').bind('input',function(){
            buttonAddTask();
        })

        // // Exibe modal para detalhamento das alocações diárias
        // $('#form-allocation').submit(function (event) {

        //     if ( !$("#daily-allocation-details").is(':visible') ) {
        //         event.preventDefault();
                
        //         $('.info').hide();

        //         var data = {
        //             'start':      $('#start').val(),
        //             'finish':     $('#finish').val(),
        //             'user_id':    $('#user_id').val(),
        //             'project_id': $('#project_id').val(),
        //             'hours':      $('#hours').val(),
        //             'jobWeekEnd': $('#jobWeekEnd').prop('checked')
        //         };

        //         var query = $.param(data);
        //         $('#preloader').show();
        //         $('body').delay(350).css({'overflow-y':'hidden'});
        //         $('#status').show();
        //         $.getJSON('/allocations/check-period-hours?' + query)
        //         .done(function (response) {

        //             $('.modal-result').empty();

        //             $.each(response.possibles, function (key, item) {
        //                 var checkDailyHours = (item.actual_hours + item.hours_to_add) > 24;

        //                 if(window.location.href.indexOf('edit') >-1){
        //                     checkDailyHours = (item.hours_to_add) > 24;
        //                 }

        //                 var html = "<tr>" +
        //                     "<td>" + response.user.name + "</td>" +
        //                     "<td>" + item.date + "</td>" +
        //                     "<td>" + response.project.full_description + "</td>" +
        //                     "<td class='text-center'>" + item.actual_hours + "</td>" +
        //                     "<td class='text-center'>" + item.hours_to_add + "</td>" +
        //                     "</tr>";

        //                 $('.modal-result').append(html);

        //                 if ( checkDailyHours ) {
        //                     $('.modal-result tr td:last-child').addClass('alert-danger');
        //                     $('.info').show();
        //                     $('.daily-submit-form').attr('disabled', true);
        //                 } else {
        //                     $('.daily-submit-form').attr('disabled', false);
        //                 }
        //             });
        //             $('#preloader').delay(350).fadeOut('slow');
        //             $('body').delay(350).css({'overflow':'visible'});
        //             $("#daily-allocation-details").modal('toggle');
                    
        //         });
        //     }
        // });

        // $('.daily-submit-form').click(function () {
        //     var count      = 8;
        //     var button     = $(this);

        //     button.html('Habilitará em ' + count);
        //     button.attr('disabled', true);

        //     var timeOut = setInterval(function () {
        //         button.html('Habilitará em ' + count);
        //         button.attr('disabled', true);
        //         count--;
        //     }, 1000);

        //     setTimeout(function () {
        //         button.html(beforeHtml);
        //         button.removeAttr('disabled');
        //         window.clearTimeout(timeOut);
        //     }, 9000);
            
        //     $('#form-allocation').submit();
        // });

        // $('#add-tasks-allocation').click(function(){
        //     $('#form-allocation').append('<input type="hidden" name="addTasks" value="clicked">');
        //     $('#form-allocation').submit()
        // });
    }
});

function calcHours(){
   
        var hour = $('#hourDay').val();
    if(hour && hour >= 2 && !isNaN(hour) && hour % 2 == 0 && hour <=24){
        var data = {
            'start':      $('#start').val(),
            'finish':     $('#finish').val(),
            'user_id':    $('#user_id').val(),
            'project_id': $('#project_id').val(),
            'hourDay':      $('#hourDay').val(),
            'jobWeekEnd': $('#jobWeekEnd').prop('checked')
        };

        var query = $.param(data);

        if(data['start'] && data['finish']){
            $('div.circle').css('display','block');
        $.getJSON('/allocations/calc-hours?' + query).done(function(response){
            $('#hours').val(response.hours);
            buttonAddTask();
            $('div.circle').css('display','none');
        });
        }
    }
}

function checkHours(id){
    $('.hoursQtd').removeClass('has-error');
    $('.hoursQtd .help-block > strong').html('');
    $('div.circle').css('display','block');
    $.ajaxSetup({
        headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
     });
  
    $.ajax({
        type:'POST',
        url:'/allocations/'+id+'/check-hours',
        dataType:'JSON',
        data:{
            hours:$('#hours').val()
        },
        success: function(res){
            console.log(res);

            if(!res.check.check){
                $('.hoursQtd').addClass('has-error')
                $('.hoursQtd .help-block > strong').html('Quantidade de horas não deve ser maior que ' +res.check.hours);
            }

            $('div.circle').css('display','none');
        },
        error: function(){
            $('div.circle').css('display','none');
        }
      });
}

function changeInputsOfProjects() {
    // Adicionar os membros do projeto no select
    if( $('#project_id').val()){
        $('#preloader').show();
        $('body').delay(350).css({'overflow-y':'hidden'});
        $('#status').show();
        $('#loadding-user').css('display','block');
        if(true){
            $.ajax({
                url:window.location.origin+'/projects/'+$('#project_id').val()+'/members-to-add'+'?allCollaborators=true',
                type:'GET',
                dataType:'JSON',
                success: function(res){
                    $.each(res,function(key, item){
                       
                            $('#user_id').append("<option value='" + key + "'>" + item + "</option>");
                        
                    });
                    $('#user_id').selectpicker('refresh');
                    $('#user_id').selectpicker('val',$('#user_id_old').val());
                    $('#loadding-user').css('display','none');
                   $('#preloader').delay(350).fadeOut('slow');
                     $('body').delay(350).css({'overflow':'visible'});
                },
                error: function(err){
                    console.log('All User',err)
                    $('#loadding-user').css('display','none');
                   $('#preloader').delay(350).fadeOut('slow');
                     $('body').delay(350).css({'overflow':'visible'});
                }
            });
        } else{
            $.getJSON('/projects/' + $('#project_id').val() + '/members', function (response) {
                $('#user_id').empty();
                $.each(response, function (key, item) {
                    if ( key == $('#user_id_old').val() ) {
                        $('#user_id').append("<option value='" + key + "' selected='selected'>" + item + "</option>");
                    } else {
                        $('#user_id').append("<option value='" + key + "'>" + item + "</option>");
                    }
                    $('#user_id').selectpicker('refresh');
                });
                $('#loadding-user').css('display','none');
               $('#preloader').delay(350).fadeOut('slow');
                 $('body').delay(350).css({'overflow':'visible'});
            });
        }
    }

    // Adicionar as tarefas do projeto no select
    $.getJSON('/projects/' + $('#project_id').val() + '/tasks', function (response) {
        $('#task_id').empty();
        $.each(response, function (key, item) {
            if ( key == $('#task_id_old').val() ) {
                $('#task_id').append("<option value='" + key + "' selected='selected'>" + item + "</option>");
            } else {
                $('#task_id').append("<option value='" + key + "'>" + item + "</option>");
            }
            $('#task_id').selectpicker('refresh');
        });
    });

    // Alterar a data máxima da alocação de acordo com a data de finalização do projeto
    $.getJSON('/projects/' + $('#project_id').val() + '/show', function (response) {
        if(response.extension){
            var date = moment(response.extension, 'YYYY-MM-DD');
        } else{
            var date = moment(response.finish, 'YYYY-MM-DD');
        }
        $('#finish').data("DateTimePicker").maxDate(date.add(1,'days').format('DD/MM/YYYY'));
        $('#finish').data("DateTimePicker").disabledDates([date.format('DD/MM/YYYY')]);
    });

    
    
}


$('#alluser').change(function(){

    if( $('#project_id').val() !=''){
        $('#loadding-user').css('display','block');
        $('#preloader').show();
        $('body').delay(350).css({'overflow-y':'hidden'});
        $('#status').show();
        if($('#alluser').prop('checked') ==true){
            $('#user_id').empty();
            $.ajax({
                url:window.location.origin+'/projects/'+$('#project_id').val()+'/members-to-add'+'?allCollaborators=true',
                type:'GET',
                dataType:'JSON',
                success: function(res){
                    $.each(res,function(key, item){
                       
                        $('#user_id').append("<option value='" + key + "'>" + item + "</option>");
                    
                    });
                    $('#user_id').selectpicker('refresh');
                    $('#loadding-user').css('display','none');
                   $('#preloader').delay(350).fadeOut('slow');
                     $('body').delay(350).css({'overflow':'visible'});
                },
                error: function(err){
                    console.log('All User',err)
                    $('#loadding-user').css('display','none');
                    $('#preloader').delay(350).fadeOut('slow');
                    $('body').delay(350).css({'overflow':'visible'});
                }
            });
        } else{
            $.getJSON('/projects/' + $('#project_id').val() + '/members', function (response) {
                $('#user_id').empty();
                $.each(response, function (key, item) {
                    if ( key == $('#user_id_old').val() ) {
                        $('#user_id').append("<option value='" + key + "' selected='selected'>" + item + "</option>");
                    } else {
                        $('#user_id').append("<option value='" + key + "'>" + item + "</option>");
                    }
                    $('#user_id').selectpicker('refresh');
                });

                $('#loadding-user').css('display','none');
               $('#preloader').delay(350).fadeOut('slow');
                 $('body').delay(350).css({'overflow':'visible'});
            });
        }
    }

  
});


if(window.location.href.indexOf('allocations') >-1){
    $('#user_id').change(function(){
        $('#loadding-user').css('display','block');
        $('#preloader').show();
        $('body').delay(350).css({'overflow-y':'hidden'});
        $('#status').show();
        $.getJSON('/projects/' + $('#project_id').val() + '/members', function (response) {
            var isMember = false;
            $.each(response, function (key, item) {
                if(isMember == false){
                    isMember = (key == $('#user_id').val())
                }
            });
            console.log(isMember)
           if(!isMember){
               $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
               });
                $.ajax({
                    type:'POST',
                    url:window.location.origin+'/projects/'+$('#project_id').val() + '/members',
                    dataType:'JSON',
                    data:{
                        members:[$('#user_id').val()]
                    },
                    success: function(res){
                        console.log('Membro adicionado')
                        // if(  $('#user_id option[value="'+$('#user_id').val()+'"]').html().indexOf('PS') >-1){
                        //     getModalHoursProjectAllocations();
                        // }
                        $('#loadding-user').css('display','none');
                       $('#preloader').delay(350).fadeOut('slow');
                         $('body').delay(350).css({'overflow':'visible'});
                        
                    }, error:function(err){
                        console.log(err)
                        $('#loadding-user').css('display','none');
                       $('#preloader').delay(350).fadeOut('slow');
                         $('body').delay(350).css({'overflow':'visible'});
                    }
                });
           }else{
            $('#loadding-user').css('display','none');
            $('#preloader').delay(350).fadeOut('slow');
              $('body').delay(350).css({'overflow':'visible'});
           }
        });
    });
    
    
    
    
    function getModalHoursProjectAllocations() {
        if ($('#modal-table-details').hasClass('in')) {
            $('#modal-table-details').modal('toggle');
        }
    
        var updateitem = $(this).attr('id');
        var hoursstatus = $(this).attr('data-hours');
    
        updateitem = '';
        var title = $("#modalAlert .modal-title");
        var menssage = $("#modalAlert .alertMessages");
    
        title.html("Atenção!");
            $('#modalAlert .alert-footer').find('.btn-success').remove();
            menssage.html("Deseja mesmo permitir o prestador de serviço cadastrar horas?");
            $('#modalAlert .alert-footer').append('<a class="btn btn-success" href="javascript:void(0);' + '" id="btn-confirm-add"><span class="glyphicon glyphicon-check saving" aria-hidden="true"></span> Permitir</a>');
            $('#modalAlert .alert-footer').append('<a class="btn btn-danger" href="javascript:void(0);' + '" id="btn-remove-hours-permission"><span class="glyphicon glyphicon-trash deleting" aria-hidden="true"></span> Não Permitir</a>');
            $('#modalAlert .alert-footer .btn.btn-default').css('display','none')
        
            $('#btn-remove-hours-permission').click(function(){
                $('#preloader').show();
                $('body').delay(350).css({'overflow-y':'hidden'});
                $('#status').show();
                $('#loadding-user').css('display','block');
                $("#modalAlert").modal("hide");
                $.getJSON(window.location.origin+'/projects/'+$('#project_id').val()+'/members/'+$('#user_id').val()+'/addhours',function(response){
                    $('#loadding-user').css('display','none');
                    $('#modalAlert .alert-footer').html('');
                   $('#preloader').delay(350).fadeOut('slow');
                     $('body').delay(350).css({'overflow':'visible'});
                });
            });
    
            $('#btn-confirm-add').click(function(){
                $('#preloader').show();
                $('body').delay(350).css({'overflow-y':'hidden'});
                $('#status').show();
                $('#loadding-user').css('display','block');
                $('#modalAlert').modal('hide');
                $('#modalAlert .alert-footer').html('');
                setTimeout(function(){
                    $('#loadding-user').css('display','none');
                   $('#preloader').delay(350).fadeOut('slow');
                     $('body').delay(350).css({'overflow':'visible'});
                },1000);
            });
    
            $("#modalAlert").modal("show");
    }
}


function buttonAddTask(){
var empty = false;
var fields = ['#project_id','#user_id_old','#start','#finish'];

for(var i=0; i<fields.length;i++){
    if(!$(fields[i]).val() || $(fields[i]).val().trim() == ''){
        empty = true;
    }
}

if(!empty){
     $('#add-tasks-allocation').css('display','inline-block');
} else{
     $('#add-tasks-allocation').css('display','none');
}
}


