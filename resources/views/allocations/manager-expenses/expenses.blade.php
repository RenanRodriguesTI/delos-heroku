<div class="modal fade" id="manager-expenses">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Despesas</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive double-scroll">
                    <table class="table table-bordered" id='manager-expenses-table'>
                        <thead>
                            <tr>
                                <th>@lang('headers.collaborator')</th>
                                <th>@lang('headers.issue-date')</th>
                                <th class="th-project">@lang('headers.project')</th>
                                <th>@lang('headers.request-number')</th>
                                <th>@lang('headers.invoice')</th>
                                <th class="th-project">@lang('headers.value')</th>
                                <th>@lang('headers.payment-type')</th>
                                <th>@lang('headers.description')</th>
                                <th style="display: none;">@lang('headers.note')</th>
                                <th>Situação</th>
                                <th style="min-width: 111px">@lang('headers.status')</th>
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
        $('#manager-expenses').on('shown.bs.modal', function() {
            $('.table-responsive').doubleScroll();
            $('body').materialScrollTop();
        });

        $('#manager-expenses').on('hidden.bs.modal', function() {
            window.location.reload();
            $('#preloader').show();
            $('#status').show();

        });
    });
</script>
@endpush