<div class="panel-body" style="padding: 16px 24px 0 24px;">
        <form id='form-search-curses'>
            <div class='row'>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                    <input type="hidden" name="curses" id="tab-curses" />
                    <div class="form-group">
                        {!! Form::text('curseFilter', Request::query('curseFilter'), ['class' => 'form-control', 'placeholder' => 'Pesquisar']) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-lg-3">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-dct">
                            Pesquisar
                        </button>
                        <button type="button" class="btn btn-dct dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                           
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
</div>