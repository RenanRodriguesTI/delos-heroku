<div class="form-group col-xs-12 {{$errors->has('client_id') ? 'has-error' : ''}}">
    {!! Form::label('client_id[]', 'Clientes:') !!}
    {!! Form::select('client_id[]', $clients, isset($proposalValueDescription) ? $proposalValueDescription->clients->pluck('id') : null, ['title' => 'Selecione um ou mais clientes', 
    'class' => 'form-control', 
    'required', 'data-actions-box' => "true", 
    'multiple']) !!}
    <span class="help-block">
        <strong>{{$errors->first('client_id')}}</strong>
    </span>
</div>

<span class="form-group col-lg-2 col-md-10 col-sm-10 col-xs-12   {{$errors->has('month') ? 'has-error' : ''}}">
    {!! Form::label('month', 'Data de Criação:') !!}
    {!! Form::text('month', isset($proposalValueDescription) ? $proposalValueDescription->month->format('d/m/Y') : null, [
    'class' => 'form-control month', 'required','readonly']) !!}
    
    <span class="help-block"><strong>{{$errors->first('month')}}</strong></span>
</span>

<span class="form-group col-lg-2 col-md-10 col-sm-10 col-xs-12   {{$errors->has('expected_date') ? 'has-error' : ''}}">
    {!! Form::label('expected_date', 'Data prevista') !!}
    {!! Form::text('expected_date', isset($proposalValueDescription)  && ($proposalValueDescription->expected_date) ? $proposalValueDescription->expected_date->format('d/m/Y') : null, [
    'class' => 'form-control expected_date', '']) !!}
    
    <span class="help-block"><strong>{{$errors->first('expected_date')}}</strong></span>
</span>

<span class="form-group col-lg-2 col-md-10 col-sm-10 col-xs-12   {{$errors->has('date_change') ? 'has-error' : ''}}">
    {!! Form::label('date_change', 'Data de Alteracao') !!}
    {!! Form::text('date_change', isset($proposalValueDescription ) && ($proposalValueDescription->date_change) ? $proposalValueDescription->date_change->format('d/m/Y') : null, [
    'class' => 'form-control date_change', 'readonly']) !!}
    
    <span class="help-block"><strong>{{$errors->first('date_change')}}</strong></span>
</span>

<span class="form-group col-lg-2 col-md-10 col-sm-10 col-xs-12   {{$errors->has('date_nf') ? 'has-error' : ''}}">
    {!! Form::label('date_nf', 'Data da Nota') !!}
    {!! Form::text('date_nf', isset($proposalValueDescription) && ($proposalValueDescription->date_nf) ? $proposalValueDescription->date_nf->format('d/m/Y') : null, [
    'class' => 'form-control date_nf', '']) !!}
    
    <span class="help-block"><strong>{{$errors->first('date_nf')}}</strong></span>
</span>

<span class="form-group col-lg-2 col-md-10 col-sm-10 col-xs-12   {{$errors->has('date_received') ? 'has-error' : ''}}">
    {!! Form::label('date_received', 'Data de Recebimento') !!}
    {!! Form::text('date_received', isset($proposalValueDescription) && ($proposalValueDescription->date_received) ? $proposalValueDescription->date_received->format('d/m/Y') : null, [
    'class' => 'form-control date_received',]) !!}
    
    <span class="help-block"><strong>{{$errors->first('date_received')}}</strong></span>
</span>

<span class="form-group col-lg-2 col-md-10 col-sm-10 col-xs-12   {{$errors->has('date_nf') ? 'has-error' : ''}}">
    {!! Form::label('import_date', 'Data da Importação') !!}
    {!! Form::text('import_date', isset($proposalValueDescription) && ($proposalValueDescription->import_date) ? $proposalValueDescription->import_date->format('d/m/Y') : null, [
    'class' => 'form-control import_date', 'readonly']) !!}
    
    <span class="help-block"><strong>{{$errors->first('import_date')}}</strong></span>
</span>


@push('scripts')
<script>
    $("#month").daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        },
        "singleDatePicker": true,
        'maxDate': '{{$project->finish->format('d/m/Y')}}',
        'minDate': '{{$project->start->format('d/m/Y')}}'
    });

    $("#month").data('daterangepicker').remove();

    $("#import_date").daterangepicker({
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY'
        },
        "singleDatePicker": true,
        'maxDate': '{{$project->finish->format('d/m/Y')}}',
        'minDate': '{{$project->start->format('d/m/Y')}}'
    });

    $("#import_date").data('daterangepicker').remove();

    $("#date_nf").daterangepicker({
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY',
        },
        "singleDatePicker": true,
        'minDate': '{{$project->start->format('d/m/Y')}}'
    });

    $("#date_received").daterangepicker({
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY'
        },
        "singleDatePicker": true,
        'minDate': '{{$project->start->format('d/m/Y')}}'
    });

    $("#date_change").daterangepicker({
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY'
        },
        "singleDatePicker": true,
        'minDate': '{{$project->start->format('d/m/Y')}}'
    });

    $("#date_change").data('daterangepicker').remove();

    $("#expected_date").daterangepicker({
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY'
        },
        "singleDatePicker": true,
        'minDate': '{{$project->start->format('d/m/Y')}}'
    });
   
</script>
@endpush

<span class="form-group col-lg-3 col-md-10 col-sm-10 col-xs-12 {{$errors->has('proposalValueDescription') ? 'has-error' : ''}}">
    {!! Form::label('invoice_number', 'Nº Nota Fiscal:') !!}
    {!! Form::text('invoice_number', isset($proposalValueDescription) ? $proposalValueDescription->invoice_number : null, ['class' => 'form-control','maxlength' => '15',]) !!}
    <span class="help-block"><strong>{{$errors->first('invoice_number')}}</strong></span>
</span>

<span class="form-group col-lg-5 col-md-10 col-sm-10 col-xs-12 {{$errors->has('value') ? 'has-error' : ''}}">
    {!! Form::label('value', 'Valor:') !!}
    <div class="input-group">
        <div class="input-group-addon">R$</div>
        {!! Form::text('value', isset($proposalValueDescription) ? number_format($proposalValueDescription->value, 2, ',', '.') : null, ['class' => 'form-control','required']) !!}
    </div>
    
    <span class="help-block"><strong>{{$errors->first('value')}}</strong></span>
</span>









<div class="form-group col-lg-3 col-md-10 col-sm-10 col-xs-12 {{$errors->has('os') ? 'has-error' : ''}}">
    {!! Form::label('os', 'Ordem de Serviço:') !!}
    {!! Form::text('os', isset($proposalValueDescription) && ($proposalValueDescription->os) ? $proposalValueDescription->os : null, ['class' => 'form-control', 'maxlength' => '255', 'required']) !!}
    <span class="help-block"><strong>{{$errors->first('os')}}</strong></span>
</div>

<div class="form-group col-xs-12 {{$errors->has('nf_nd') ? 'has-error' : ''}}">
    {!! Form::label('nf_nd', 'NF/ND:') !!}
    {!! Form::text('nf_nd', isset($proposalValueDescription) && ($proposalValueDescription->nf_nd) ? $proposalValueDescription->nf_nd : null, ['class' => 'form-control', 'maxlength' => '255']) !!}
    <span class="pull-right label label-default count_message notes"></span>
    
    <span class="help-block"><strong>{{$errors->first('nf_nd')}}</strong></span>
</div>


<div class="form-group col-xs-12 {{$errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Descrição:') !!}
    {!! Form::text('description', isset($proposalValueDescription) ? $proposalValueDescription->description : null, ['class' => 'form-control', 'maxlength' => '255', 'required']) !!}
    <span class="help-block"><strong>{{$errors->first('description')}}</strong></span>
</div>

<div class="form-group col-xs-12 {{$errors->has('notes') ? 'has-error' : ''}}">
    {!! Form::label('notes', 'Observação:') !!}
    {!! Form::text('notes', isset($proposalValueDescription) ? $proposalValueDescription->notes : null, ['class' => 'form-control', 'maxlength' => '255']) !!}
    <span class="pull-right label label-default count_message notes"></span>
    
    <span class="help-block"><strong>{{$errors->first('notes')}}</strong></span>
</div>


<input type="hidden" name="project_id" value="{{$project->id}}">