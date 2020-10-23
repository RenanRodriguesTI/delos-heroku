<div class="modal fade" id="user-approved-hours">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Colaboradores</h5>
                <input type="hidden" id="user-approved-hours-project" />
            </div>
            <div class="modal-body">
                <p class="project-description text-center"></p>
                <div class="table-responsive double-scroll modal-height-75vh">
                    <table class="table table-bordered" id="users-table-approve">
                        <thead>
                            <tr>
                                <th>Colaborador</th>
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

@include('allocations.tasks.form')


@push('scripts')
<script>
    $('#user-approved-hours').on('shown.bs.modal', function() {
        $('.table-responsive').doubleScroll();
        $('body').materialScrollTop();
    });

    $('#user-approved-hours').on('hidden.bs.modal', function() {
        window.location.reload();
        $('#preloader').show();
        $('#status').show();

    });
</script>
@endpush