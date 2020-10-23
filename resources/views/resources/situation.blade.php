<div class="modal fade" id="resource-situation">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Recurso</h5>
            </div>
            <div class="modal-body" style="min-height: 75vh;">
                <p class="resources-description text-center"></p>

                <div id="projects">
                    
                </div>

            </div>
        </div>
    </div>

</div>

<style>
    h2.accordion {
        font-size: 13px;
        border: 1px solid #0000005c;
        padding: 10px;
        background: #26852d;
        color: white;
        border-radius: 4px;

    }

    .table-responsive {
        min-height: auto !important;
    }
</style>


@push('scripts')
<script>
    // $(document).ready(function() {
    //     $('h2.accordion').click(function() {
    //         $(this).parent().find('div.accordion').slideToggle("slow");
    //     });
    // });

    $('#resource-situation').on('hidden.bs.modal', function() {
        $('#resource-situation #projects').html('');
        $('.resources-description').html('');
    });
</script>

@endpush