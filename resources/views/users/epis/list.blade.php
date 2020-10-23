<div id="epis" class="panel panel-dct  tab-pane fade">
    <div class="panel-heading">
        <h3 class="panel-title bold">EPIs</h3>
    </div>
    <div class="panel-body">

        <div class="pull-right">
            <button id="addEpi" class="btn btn-dct" data-toggle='modal' data-target="#epis-form">Adicionar</button>
        </div>

    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="epis-table">
                <thead>
                    <tr>
                        <th>EPI</th>
                        <th>CA</th>
                        <th>Validade</th>
                        <th style="display: none;">Arquivo</th>
                        <th>Retirado</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($epis as $key=> $epi)
                    <tr class="epi-{{$epi->id}}">
                        <td>{{$epi->name}}</td>
                        <td>{{$epi->epi_user ? $epi->epi_user->ca :""}}</td>
                        <td>{{$epi->epi_user ? $epi->epi_user->shelf_life->format('d/m/Y') :""}}</td>
                        <td style="display:none">{{$epi->epi_user ? $epi->epi_user->filename :""}}</td>
                        <td>{{$epi->epi_user ? "Sim":"Não"}}</td>
                        <td>
                            <div class="btn-group {{$key<=3 ? 'dropdown':'dropup'}}">
                                <button type="button" class="btn {{$epi->epi_user? $epi->epi_user->expired?'btn-warning':'btn-dct':'btn-warning'}} btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="btn-options-users-{{$key}}">
                                    <span class="glyphicon glyphicon-cog"></span>
                                    @lang('buttons.options') &nbsp;<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">

                                    <li class="divider"></li>


                                    @if($epi->epi_user &&$epi->epi_user->file_s3)
                                    <li>
                                        <a href="{{$epi->epi_user->file_url}}" target="_blank">
                                            <span class="glyphicon glyphicon-eye-open"></span> Visualizar Termo
                                        </a>
                                    </li>

                                    <li class="divider"></li>
                                    @endif

                                    <li>
                                        <a class="edit" data-edit-epi='{{$epi->id}}' data-edit-epi-route="{{route('epis.withdraw')}}">
                                            <span class="glyphicon glyphicon-edit"></span>&nbsp; Retirar
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
        if ($('#ca ~ .help-block strong').html() ||
            $('#shelf_life ~ .help-block strong').html() ||
            $('#name ~ .help-block strong').html()) {
            $('#epis-form').modal('show');
            // $('#epis-form').attr('action', '/epis/' + $('#id').val() + '/update')
        }
    });

    $('a[data-edit-epi]').click(function() {
        var epi = $(this).attr('data-edit-epi');


        var date = $($('tr.epi-' + epi + ' td')[2]).html() == "Não especificado" ? '' : $($('tr.epi-' + epi + ' td')[2]).html();
        $('.nameEpis #name').val($($('tr.epi-' + epi + ' td')[0]).html());
        $('.nameEpis #name').attr('readonly',true);
        $('#ca').val($($('tr.epi-' + epi + ' td')[1]).html() == "Não especificado" ? '':$($('tr.epi-' + epi + ' td')[1]).html());
        $('#shelf_life').val(date);
        $('#filename').val($($('tr.epi-' + epi + ' td')[3]).html())
        $('#id').val($(this).attr('data-edit-epi'));
        $('#epis-form').attr('action', $(this).attr('data-edit-epi-route'));
        $('#epis-form').modal('show');

    });

    $('#epis-form').on('hidden.bs.modal', function() {
        $('.nameEpis #name').val('');
        $('.nameEpis #name').attr('readonly',false);
        $('#ca').val('');
        $('#shelf_life').val('');
        $('.help-block strong').html('');
        $(".nameEpis").removeClass('has-error');
        $(".caEpis").removeClass('has-error');
        $('#filename').val("");
        $('#epifile').val("");
        $('.shelfLifeEpis').removeClass('has-error');
    });

    $('#addEpi').click(function() {
        $('#epis-form').attr('action', "{{route('epis.withdraw')}}");
    });


    $('#saveEpis').click(function() {
        $('#preloader').show();
        $('#status').show();
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: $('#epis-form').attr('action'),
            data: new FormData($('#epis-form')[0]),
            contentType: false,
            processData: false,
            success: function(res) {
                loadEpis();
            },
            error: function(err) {
                switch (err.status) {
                    case 422:

                        Object.keys(err.responseJSON).forEach(function(item) {
                            switch (item) {
                                case "name":
                                    $(".nameEpis").addClass('has-error')
                                    $("#name ~ .help-block strong").html(err.responseJSON[item][0]);
                                    break;
                                case "ca":
                                    $(".caEpis").addClass('has-error');
                                    $("#ca ~ .help-block strong").html(err.responseJSON[item][0]);
                                    break;

                                case "shelf_life":
                                    $('.shelfLifeEpis').addClass("has-error");
                                    $("#shelf_life ~ .help-block strong").html(err.responseJSON[item][0]);
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


    function loadEpis() {
        $.ajax({
            type: "GET",
            dataType: 'JSON',
            url: '/epis/index?userId=' + $('#user_id').val(),
            success: function(res) {
                renderEpis(res);
            }
        });
    }

    function renderEpis(data) {
        var row = "";
        var i = 0;
        $.each(data, function() {
            row += `
            <tr class="epi-${this.id}">
                        <td>${this.name}</td>
                        <td>${this.epi_user ? this.epi_user.ca :""}</td>
                        <td>${this.epi_user ? this.epi_user.shelf_life ? moment(this.epi_user.shelf_life,'Y-MM-DD H:m:s').format('DD/MM/Y'): '' : ""}</td>
                        <td style="display:none">${ this.epi_user ? this.epi_user.filename: ''}</td>
                        <td>${this.epi_user ? "Sim":"Não"}</td>
                        <td>
                            <div class="btn-group ${i<=3 ? 'dropdown':'dropup'}">
                                <button type="button" class="btn ${this.epi_user? this.epi_user.expired? 'btn-warning':'btn-dct':'btn-dct'} btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="btn-options-users-${i}">
                                    <span class="glyphicon glyphicon-cog"></span>
                                    @lang('buttons.options') &nbsp;<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">

                                    <li class="divider"></li>

                                    ${this.epi_user ?
                                        this.epi_user.file_s3?  `
                                        <li>
                                        <a href="${this.epi_user.file_url}" target="_blank">
                                            <span class="glyphicon glyphicon-eye-open"></span> Visualizar Termo
                                        </a>
                                    </li>

                                    <li class="divider"></li>
                                    `:""
                                    :""}

                                    <li>
                                        <a class="edit" data-edit-epi='${this.id}' data-edit-epi-route="/epis/withdraw">
                                            <span class="glyphicon glyphicon-edit"></span>&nbsp; Retirar
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                </ul>

                            </div>

                        </td>
                    </tr>`;
            i++;
        });

        $('#epis-table tbody').html(row);
        $('a[data-edit-epi]').click(function() {
            var epi = $(this).attr('data-edit-epi');
            var date = $($('tr.epi-' + epi + ' td')[2]).html() == "Não especificado" ? '' : $($('tr.epi-' + epi + ' td')[2]).html();
            $('.nameEpis #name').val($($('tr.epi-' + epi + ' td')[0]).html());
            $('#ca').val($($('tr.epi-' + epi + ' td')[1]).html());
            $('#shelf_life').val(date);
            $('#filename').val($($('tr.epi-' + epi + ' td')[3]).html())
            $('#id').val($(this).attr('data-edit-epi'));
            $('#epis-form').attr('action', $(this).attr('data-edit-epi-route'));
            $('.nameEpis #name').attr('readonly',true);
            $('#epis-form').modal('show');
        });
        $(".delete-epi").click(getModalEpiDelete);
        $("#epis-form").modal("hide")
        $('#preloader').hide();
        $('#status').hide();
    }


    $(".delete-epi").click(getModalEpiDelete);


    function getModalEpiDelete(elem) {
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

        $('#btn-confirm-exclude').click(function() {
            $('#preloader').show();
            $('#status').show();
            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: distroyitem,
                success: function(res) {
                    loadEpis(res.epi.user_id);
                    $("#modalAlert").modal("hide");
                },
                error: function(err) {
                    $('#preloader').hide();
                    $('#status').hide();
                }
            });
        });
    }
</script>

@endpush