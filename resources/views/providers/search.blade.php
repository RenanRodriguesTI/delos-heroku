<div class="row">
    {!! Form::open(['route'=>'providers.index','id'=>'form-search-providers','method' =>'GET']) !!}
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="form-group">
            {!! Form::text('search', Request::query('search'), ['class' => 'form-control', 'placeholder' => 'Pesquisar']) !!}
        </div>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-lg-3">
        <div class="form-group">
            {!! Form::select('searchfilter', ['social_reason' => 'Todos','social_reason' => 'Razão Social', 'cnpj' => 'CNPJ','email' => 'Email'], Request::get('searchfilter'), [
            'class' => 'nopadding selectpicker form-control',
            'data-live-search' => 'true',
            'data-actions-box' => 'true',
            ])!!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-lg-3">
        <div class="form-group">
            <button type="submit" class="btn btn-dct">
                Pesquisar
            </button>
        </div>
    </div>
    {!! Form::close() !!}
</div>