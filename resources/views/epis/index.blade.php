@extends('layouts.app')
@section('content')
<div class="panel panel-dct  tab-pane fade in active">
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
                        <th style="display: none;">Arquivo</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($epis as $key=> $epi)
                    <tr class="epi-{{$epi->id}}">
                        <td>{{$epi->name}}</td>
                        <td>
                            <div class="btn-group {{$key<=3 ? 'dropdown':'dropup'}}">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="btn-options-users-{{$key}}">
                                    <span class="glyphicon glyphicon-cog"></span>
                                    @lang('buttons.options') &nbsp;<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">

                                    <li class="divider"></li>

                                    <li>
                                        <a class="edit" data-edit-epi='{{$epi->id}}' data-edit-epi-route="{{route('epis.update',['id'=>$epi->id])}}">
                                            <span class="glyphicon glyphicon-edit"></span>&nbsp; Editar
                                        </a>
                                    </li>

                                    <li class='divider'></li>
                                    <li>
                                        <a class="delete-epi" id="{{route('epis.destroy',['id'=>$epi->id])}}" style="cursor: pointer" onclick="getModalEpiDelete(this)">
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

@include('epis.form')
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        if ($('#ca ~ .help-block strong').html()) {
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
            $('#name').val($($('tr.epi-' + epi + ' td')[0]).html());
            $('#id').val($(this).attr('data-edit-epi'));
            $('#epis-form').attr('action', $(this).attr('data-edit-epi-route'));
            $('#epis-form').modal('show');

        });
    });



    $('#epis-form').on('hidden.bs.modal', function() {
        $('#name').val('');
        $('.help-block strong').html('');
        $(".nameEpis").removeClass('has-error');
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

                window.location.reload(true);

               
            
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
                    window.location.reload();
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