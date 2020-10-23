<div class="modal fade" id="list-allocations-tasks">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Tarefas</h5>
                <input type="hidden" name="sel_allocation_id" id="sel_allocation_id"/>
            </div>
            <div class="modal-body">
               
                <p class="project-description text-center"></p>
                <p class="user-name text-center"></p>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-flex-end">
                    <button class="btn btn-warning add-allocations-tasks" type="button">Tarefa</button></td>
                </div>
                <div class="table-responsive double-scroll modal-height-75vh">
                    <table class="table table-bordered" id="allocations-task-table">
                        <thead>
                            <tr>
                                <th>Tarefa</th>
                                <th>De</th>
                                <th>Até</th>
                                <th>Quantidade de Horas</th>
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

$('#list-allocations-tasks').on('shown.bs.modal', function() {
            $('.table-responsive').doubleScroll();
            $('body').materialScrollTop();
        });

$('#list-allocations-tasks').on('hidden.bs.modal', function () {
    var project = $('#sel_project_id').val()
    var user = $('#sel_user_id').val()

    $('#preloader').show();
    $('#status').show();

    $.ajax({
                method: 'GET',
                dataType: 'JSON',
                url: '/allocations/listByProject/' + project + '/user/' + user,
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
    </script>
@endpush
