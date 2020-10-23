<div class="modal fade" id="manager-activities">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Atividades</h5>
            </div>
            <div class="modal-body">
                <p class="project-description text-center"></p>
                <p class="user-name text-center"></p>
                <div class="table-responsive double-scroll modal-height-75vh">
                    <table class="table table-bordered" id='manager-activities-table'>
                        <thead>
                            <tr>
                                <th style="min-width: 141px">@lang('headers.date')</th>
                                <th>@lang('headers.hours')</th>
                                <th>@lang('headers.task')</th>
                                <th>@lang('headers.place')</th>
                                <th>@lang('headers.note')</th>
                                <th>@lang('headers.created-at')</th>
                                <th>Status</th>
                                <th>@lang('headers.action')</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#manager-activities').on('shown.bs.modal', function() {
            $('.table-responsive').doubleScroll();
            $('body').materialScrollTop();
        });

        $('#manager-activities').on('hidden.bs.modal', function() {
            $('#preloader').show();
            $('#status').show();
            getUsersByProject($('#user-approved-hours-project').val())
        });
    });
</script>
@endpush