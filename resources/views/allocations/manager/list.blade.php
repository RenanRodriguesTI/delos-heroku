<div class="modal fade" id="list-allocations">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Alocações</h5>
                <input type="hidden" name="sel_project_id" id="sel_project_id"/>
                <input type="hidden" name="sel_user_id" id="sel_user_id"/>
            </div>
            <div class="modal-body">
                <p class="project-description text-center"></p>
                <div class="table-responsive double-scroll modal-height-75vh">
                    <table class="table table-bordered" id="allocations-table">
                        <thead>
                            <tr>
                                <th>Colaborador</th>
                                <th>De</th>
                                <th>Até</th>
                                <th>Descrição</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>


@push('scripts')
    <script>

$('#list-allocations').on('shown.bs.modal', function() {
            $('.table-responsive').doubleScroll();
            $('body').materialScrollTop();
        });

$('#list-allocations').on('hidden.bs.modal', function () {
    var project =  $('#sel_project_id').val();
    $('#sel_project_id').val('');

    refreshUsers(project);
});
    </script>
@endpush
