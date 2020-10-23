<div id="epis" class="panel panel-dct  tab-pane fade in active">
    <div class="panel-heading">
        <h3 class="panel-title bold">EPIs</h3>
    </div>
    <div class="panel-body">

        <a href="{{route('documents.index')}}?epis=1" class="btn btn-default">
            <span class="glyphicon glyphicon-arrow-left"></span>
            Voltar
        </a>

        <div class="pull-right">
            <!-- <button id="addEpi" class="btn btn-dct" data-toggle='modal' data-target="#epis-form">Adicionar</button> -->
        </div>

    </div>

    @include("documents.epis.search")

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="epis-table">
                <thead>
                    <tr>
                        <th>EPI</th>
                        <th>CA</th>
                        <th>Validade</th>
                        <th style="display: none;">Arquivo</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($epis as $key=> $epi)
                    <tr class="epi-{{$epi->id}} {{$epi->expired ? 'expired':''}}">
                        <td>{{$epi->name}}</td>
                        <td>{{$epi->epi_user ? $epi->epi_user->ca ? $epi->epi_user->ca :"Não especificado":"Não especificado"}}</td>
                        <td>{{$epi->epi_user ? $epi->epi_user->shelf_life ? $epi->epi_user->shelf_life->format('d/m/Y') : "Não especificado":"Não especificado"}}</td>
                        <td style="display:none">{{$epi->epi_user ? $epi->epi_user->filename : ""}}</td>
                        <td>
                            <div class="btn-group {{$key<=3 ? 'dropdown':'dropup'}}">
                                <button type="button" class="btn {{$epi->epi_user ? $epi->epi_user->expired? 'btn-warning':'btn-dct':'btn-warning'}} btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="btn-options-users-{{$key}}">
                                    <span class="glyphicon glyphicon-cog"></span>
                                    @lang('buttons.options') &nbsp;<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">

                                    <li class="divider"></li>


                                    @if($epi->epi_user && $epi->epi_user->file_s3)
                                    <li>
                                        <a href="{{$epi->epi_user->file_url}}" target="_blank">
                                            <span class="glyphicon glyphicon-eye-open"></span> Visualizar Termo
                                        </a>
                                    </li>

                                    <li class="divider"></li>
                                    @endif
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
            {{$epis->render()}}
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
            $('#epis-form').attr('action', '/epis/' + $('#id').val() + '/update')
        }

        var elements = $('table#epis-table tbody tr');
        elements = elements.sort(function(a, b) {
            if ($(a).attr('class').indexOf("expired") == -1 && $(b).attr('class').indexOf("expired") > -1) {
                return 1;
            } else {
                if ($(a).attr('class').indexOf("expired") > -1 && $(b).attr('class').indexOf("expired") == -1) {
                    return -1;
                }
            }
            return 0;
        });

        $('table#epis-table tbody').html("");

        $.each(elements, function() {
            $('table#epis-table tbody').append(this);
        });

        $('a[data-edit-epi]').click(function() {
            var epi = $(this).attr('data-edit-epi');


            var date = $($('tr.epi-' + epi + ' td')[2]).html() == "Não especificado" ? '' : $($('tr.epi-' + epi + ' td')[2]).html();
            $('#name').val($($('tr.epi-' + epi + ' td')[0]).html());
            $('#ca').val($($('tr.epi-' + epi + ' td')[1]).html());
            $('#shelf_life').val(date);
            $('#filename').val($($('tr.epi-' + epi + ' td')[3]).html())
            $('#id').val($(this).attr('data-edit-epi'));
            $('#epis-form').attr('action', $(this).attr('data-edit-epi-route'));
            $('#epis-form').modal('show');

        });
    });



    $('#epis-form').on('hidden.bs.modal', function() {
        $('#name').val('');
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
        $('#epis-form').attr('action', '/epis/store');
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

                if( $('a[data-redirect]').attr('data-redirect')){
                    window.location.href = $('a[data-redirect]').attr('data-redirect');
                }else{
                    window.location.reload(true);
                }

               
            
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
</script>

@endpush