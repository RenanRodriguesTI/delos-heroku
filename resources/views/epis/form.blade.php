<form class="modal fade" id="epis-form" action="{{route("epis.store")}}" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="id" name="id" />
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="EPIsModalLabel">EPIs</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="nameEpis col-lg-12 col-md-12 col-sm-12 col-xs-12  {{$errors->has('name') ? 'has-error' : ''}}">
                        {!! Form::label('name', 'Nome:') !!}
                        {!! Form::text('name', '', ['class' => 'form-control']) !!}
                        <span class="help-block"><strong>{{$errors->first('name')}}</strong></span>
                    </div>
                </div> 
            </div>
            <div class="modal-footer">
                <button id="saveEpis" type="button" class="btn btn-primary">
                    <div class="circule-btn" style="display: none;"></div>
                    Salvar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</form>

@push('scripts')

<script>


</script>
@endpush

