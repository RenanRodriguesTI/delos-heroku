<form class="form-inline">
    <div class="form-group">
        <div class="row">
            <div class="col-xs-12">
                {!!
                Form::text('search', Request::query('search'), ['class' => 'form-control', 'id' => 'form-search-audits'])
                !!}

                <div class="btn-group">
                    <button type="submit" class="btn btn-dct">
                        Pesquisar
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>