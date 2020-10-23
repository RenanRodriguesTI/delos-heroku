<div id="curses" class="panel panel-dct  tab-pane fade">
    <div class="panel-heading">
        <h3 class="panel-title bold">Cursos</h3>
    </div>
    <div class="panel-body">

        <div class="pull-right">
            <button id="addCurse" class="btn btn-dct" data-toggle='modal' data-target="#curse-form">Adicionar</button>
        </div>

    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="table-curse">
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Data de Conclusão</th>
                        <th>Data de Renovação</th>
                        <th style="display: none;">Arquivo</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curses as $key=> $curse)
                    <tr class="curse-{{$curse->id}}">
                        <td>{{$curse->name}}</td>
                        <td>{{$curse->end_date ? $curse->end_date->format('d/m/Y') : "Não especificado"}}</td>
                        <td>{{$curse->renewal_date ? $curse->renewal_date->format('d/m/Y') : "Não especificado"}}</td>
                        <td style="display:none">{{$curse->filename}}</td>
                        <td>
                            <div class="btn-group {{$key<=3 ? 'dropdown':'dropup'}}">
                                <button type="button" class="btn {{$curse->expired? 'btn-warning':'btn-dct'}} btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="btn-options-users-{{$key}}">
                                    <span class="glyphicon glyphicon-cog"></span>
                                    @lang('buttons.options') &nbsp;<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">

                                    <li class="divider"></li>


                                    @if($curse->file_s3)
                                    <li>
                                        <a href="{{$curse->file_url}}" target="_blank">
                                            <span class="glyphicon glyphicon-eye-open"></span> Visualizar Termo
                                        </a>
                                    </li>

                                    <li class="divider"></li>
                                    @endif

                                    <li>
                                        <a class="edit" data-edit-curse='{{$curse->id}}' data-edit-curse-route="{{route('curses.update',['id'=>$curse->id])}}">
                                            <span class="glyphicon glyphicon-edit"></span>&nbsp; Editar
                                        </a>
                                    </li>

                                    <li class='divider'></li>
                                    <li>
                                        <a class="delete-curse" id="{{route('curses.destroy',['id'=>$curse->id])}}" style="cursor: pointer" onclick="getModalCurseDelete(this)">
                                            <span class="glyphicon glyphicon-trash"></span>&nbsp; @lang('buttons.remove')
                                        </a>
                                    </li>
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

    <div class="panel-footer">
        <div class="text-right">
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        if ($('#end_date ~ .help-block strong').html() ||
            $('#renewal_date ~ .help-block strong').html() ||
            $('#namecurse ~ .help-block strong').html()) {
            $('#curse-form').modal('show');
            $('#curse-form').attr('action', '/curses/' + $('#id').val() + '/update')
        }
    });

    $('a[data-edit-curse]').click(function() {
        var curse = $(this).attr('data-edit-curse');


        var renewal = $($('tr.curse-' + curse + ' td')[2]).html() == "Não especificado" ? '' : $($('tr.curse-' + curse + ' td')[2]).html();
        var end = $($('tr.curse-' + curse + ' td')[1]).html() == "Não especificado" ? '' : $($('tr.curse-' + curse + ' td')[1]).html();
        console.log($($('tr.curse-' + curse + ' td')[0]).html())
        $('#namecurse').val($($('tr.curse-' + curse + ' td')[0]).html());
        $('#end_date').val(end);
        $('#renewal_date').val(renewal);
        $('#filenamecurse').val($($('tr.curse-' + curse + ' td')[3]).html())
        $('#idcurse').val($(this).attr('data-edit-curse'));
        $('#curse-form').attr('action', $(this).attr('data-edit-curse-route'));
        $('#curse-form').modal('show');

    });

    $('#addCurse').click(function() {
        $('#curse-form').attr('action', '/curses/store');
    });


    $('#saveCurse').click(function() {
        $('#preloader').show();
        $('#status').show();
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: $('#curse-form').attr('action'),
            data: new FormData($('#curse-form')[0]),
            processData: false,
            contentType: false,
            success: function(res) {
                console.log(res);
                loadCurse(res.curse.user_id);


            },
            error: function(err) {
                console.log(err)
                switch (err.status) {
                    case 422:

                        Object.keys(err.responseJSON).forEach(function(item) {
                            switch (item) {
                                case "renewal_date":
                                    $(".renewalDateCurse").addClass('has-error')
                                    $("#renewal_date ~ .help-block strong").html(err.responseJSON[item][0]);
                                    break;
                                case "end_date":
                                    $(".endDateCurse").addClass('has-error');
                                    $("#end_date ~ .help-block strong").html(err.responseJSON[item][0]);
                                    break;

                                case "name":
                                    $('.nameCurse').addClass("has-error");
                                    $("#namecurse ~ .help-block strong").html(err.responseJSON[item][0]);
                                    break;
                            }
                        });

                        break;
                    case 403:
                        console.log(err)
                        break;
                    case 500:
                        console.log(err)
                        break;
                }


                $('#preloader').hide();
                $('#status').hide();
            }
        });
    });


    function loadCurse(user) {
        $.ajax({
            type: "GET",
            dataType: 'JSON',
            url: '/documents/user/' + user + '/list',
            success: function(res) {
                renderCurse(res.curses);
            }
        });
    }

    function renderCurse(data) {

        var row = "";
        var i = 0;
        $.each(data, function() {
            row += `
            <tr class="curse-${this.id}">
                        <td>${this.name}</td>
                        <td>${this.end_date?this.end_date: "Não especificado"}</td>
                        <td>${this.renewal_date ?this.renewal_date: "Não especificado"}</td>
                        <td style="display:none">${this.filename}</td>
                        <td>
                            <div class="btn-group ${i<=3 ? 'dropdown':'dropup'}">
                                <button type="button" class="btn ${this.expired? 'btn-warning':'btn-dct'} btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="btn-options-users-${i}}">
                                    <span class="glyphicon glyphicon-cog"></span>
                                    @lang('buttons.options') &nbsp;<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">

                                    <li class="divider"></li>

                                    ${this.file_s3 ? `
                                        <li>
                                        <a href="${this.file_url}" target="_blank">
                                            <span class="glyphicon glyphicon-eye-open"></span> Visualizar Termo
                                        </a>
                                    </li>

                                    <li class="divider"></li>
                                    `:''}
                                    <li>
                                        <a class="edit" data-edit-curse='${this.id}' data-edit-curse-route="/curses/${this.id}/update">
                                            <span class="glyphicon glyphicon-edit"></span>&nbsp; Editar
                                        </a>
                                    </li>

                                    <li class='divider'></li>
                                    <li>
                                        <a class="delete-curse" id="/curses/${this.id}/destroy" style="cursor: pointer" onclick="getModalCurseDelete(this)">
                                            <span class="glyphicon glyphicon-trash"></span>&nbsp; @lang('buttons.remove')
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                </ul>

                            </div>

                        </td>
                    </tr>
            `;
            i++;
        });

        $('#table-curse tbody').html(row);

        $(".delete-curse").click(getModalCurseDelete);

        $('a[data-edit-curse]').click(function() {
            var curse = $(this).attr('data-edit-curse');


            var renewal = $($('tr.curse-' + curse + ' td')[2]).html() == "Não especificado" ? '' : $($('tr.curse-' + curse + ' td')[2]).html();
            var end = $($('tr.curse-' + curse + ' td')[1]).html() == "Não especificado" ? '' : $($('tr.curse-' + curse + ' td')[1]).html();
            console.log($($('tr.curse-' + curse + ' td')[0]).html())
            $('#namecurse').val($($('tr.curse-' + curse + ' td')[0]).html());
            $('#end_date').val(end);
            $('#renewal_date').val(renewal);
            $('#filenamecurse').val($($('tr.curse-' + curse + ' td')[3]).html())
            $('#idcurse').val($(this).attr('data-edit-curse'));
            $('#curse-form').attr('action', $(this).attr('data-edit-curse-route'));
            $('#curse-form').modal('show');

        });

        $("#curse-form").modal("hide")
        $('#preloader').hide();
        $('#status').hide();
    }


    $(".delete-curse").click(getModalCurseDelete);

    function getModalCurseDelete(elem) {
        if ($('#modal-table-details').hasClass('in')) {
            $('#modal-table-details').modal('toggle');
        }

        var distroyitem = $(this).attr('id');

        if (this === this.window) {
            distroyitem = $(elem).attr('id');
        }

        var title = $("#modalAlert .modal-title");
        var menssage = $("#modalAlert .alertMessages");

        title.html("Atenção!");
        menssage.html("Deseja mesmo remover este Item?");

        $('#modalAlert .alert-footer').find('.btn-danger').remove();
        $('#modalAlert .alert-footer').append('<a class="btn btn-danger" href="' + 'javascript:void(0)' + '" id="btn-confirm-exclude"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Remover</a>');

        $("#modalAlert").modal("show");


        $('#btn-confirm-exclude').unbind();

        $('#btn-confirm-exclude').click(function(){
            $('#preloader').show();
            $('#status').show();
            $.ajax({
                type:'GET',
                dataType:'JSON',
                url:  distroyitem,
                success:function(res){
                    loadCurse(res.curse.user_id);
                    $("#modalAlert").modal("hide");
                },error:function(err){
                    $('#preloader').hide();
                    $('#status').hide();
                }
            });
        });
    }
</script>

@endpush