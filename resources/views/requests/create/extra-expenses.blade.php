<div class="panel panel-dct">
    <div class="panel-heading">
        <h3 class="panel-title bold">Extras</h3>
    </div>

    <div class="panel-body" data-without-height="true">
        <input type="hidden" name="has_extras" value="true">
        <div class="row">
            <label class="col-xs-12">Alimentação</label>
            <br>
            {{--Data de início da alimentação das despesas extras--}}
            <div class="col-sm-6 col-xs-12">
                <div class="form-group {{$errors->has('extra[food][start]') ? ' has-error' : ''}}">
                    {!! Form::label('food_start', 'Início') !!}

                    {!! Form::text('extra[food][start]', null, ['class' => 'form-control', 'id' => 'food_start', 'placeholder' => '__/__/____', 'data-mask' => '00/00/0000']) !!}

                    <span class="help-block">
                        <strong>{{$errors->first('extra[food][start]')}}</strong>
                    </span>
                </div>
            </div>
            {{--/Data de início da alimentação das despesas extras--}}

            {{--Data de término da alimentação das despesas extras--}}
            <div class="col-sm-6 col-xs-12">
                <div class="form-group {{$errors->has('extra[food][finish]') ? ' has-error' : ''}}">
                    {!! Form::label('food_finish', 'Fim') !!}

                    {!! Form::text('extra[food][finish]', null, ['class' => 'form-control', 'id' => 'food_finish', 'placeholder' => '__/__/____', 'data-mask' => '00/00/0000']) !!}

                    <span>
                        <strong>{{$errors->first('extra[food][finish]')}}</strong>
                    </span>
                </div>
            </div>
            {{--/Data de término da alimentação das despesas extras--}}

            {{--Valor do táxi para despesas extras--}}
            <div class="col-sm-6 col-xs-12">
                <div class="form-group {{$errors->has('extra[taxi][value]') ? ' has-error' : ''}}">
                    <label for="taxi_value">Táxi</label>

                    <div class="input-group">
                        {!! Form::label('taxi_value', 'R$', ['class' => 'input-group-addon']) !!}

                        {!! Form::text('extra[taxi][value]', null, ['class' => 'form-control', 'id' => 'taxi_value', 'data-mask' => '#.##0,00', 'data-mask-reverse' => 'true', 'placeholder' => '0,00']) !!}
                    </div>
                    <span>
                        <strong>{{$errors->first('extra[taxi][value]')}}</strong>
                    </span>
                </div>
            </div>
            {{--/Valor do táxi para despesas extras--}}

            {{--Valor do pedágio para despesas extras--}}
            <div class="col-sm-6 col-xs-12">
                <div class="form-group {{$errors->has('extra[toll][value]') ? ' has-error' : ''}}">
                    <label for="toll_value">Pedágio</label>

                    <div class="input-group">
                        {!! Form::label('toll_value', 'R$', ['class' => 'input-group-addon']) !!}

                        {!! Form::text('extra[toll][value]', null, ['class' => 'form-control', 'id' => 'toll_value', 'data-mask' => '#.##0,00', 'data-mask-reverse' => 'true', 'placeholder' => '0,00']) !!}
                    </div>
                    <span>
                        <strong>{{$errors->first('extra[toll][value]')}}</strong>
                    </span>
                </div>
            </div>
            {{--/Valor do pedágio para despesas extras--}}

            {{--Valor do combustível para despesas extras--}}
            <div class="col-sm-6 col-xs-12">
                {{--Label para ajustar alinhamento entre combustível e outros--}}
                <label class="col-xs-12" style="opacity: 0;">Outros</label>
                <br>
                <div class="form-group {{$errors->has('extra[fuel][value]') ? ' has-error' : ''}}">
                    <label for="fuel_value">Combustível</label>

                    <div class="input-group">
                        {!! Form::label('fuel_value', 'R$', ['class' => 'input-group-addon']) !!}

                        {!! Form::text('extra[fuel][value]', null, ['class' => 'form-control', 'id' => 'fuel_value', 'data-mask' => '#.##0,00', 'data-mask-reverse' => 'true', 'placeholder' => '0,00']) !!}
                    </div>
                    <span>
                        <strong>{{$errors->first('extra[fuel][value]')}}</strong>
                    </span>
                </div>
            </div>
            {{--/Valor do combustível para despesas extras--}}

            <div>
                <div class="col-sm-6 col-xs-12">
                    <label class="col-xs-12">Outros</label>

                    <br>

                    {{--Valor para outros valores não listados antes--}}
                    <div class="form-group {{$errors->has('extra[other][value]') ? ' has-error' : ''}} col-md-4">
                        <label for="other_value">Valor</label>

                        <div class="input-group">
                            {!! Form::label('other_value', 'R$', ['class' => 'input-group-addon']) !!}

                            {!! Form::text('extra[other][value]', null, ['class' => 'form-control', 'id' => 'other_value', 'data-mask' => '#.##0,00', 'data-mask-reverse' => 'true', 'placeholder' => '0,00']) !!}
                        </div>
                        <span>
                            <strong>{{$errors->first('extra[other][value]')}}</strong>
                        </span>
                    </div>
                    {{--/Valor para outros valores não listados antes--}}

                    {{--Descrição do valor para outros valores não listados antes--}}
                    <div class="form-group {{$errors->has('extra[other][value]') ? ' has-error' : ''}} col-xs-8">
                        <label for="other_description">Descrição</label>

                        <input type="text" name="extra[other][description]" id="other_description" class="form-control" placeholder="---"/>
                        <span class="help-block">
                            <strong>{{$errors->first('extra[other][description]')}}</strong>
                        </span>
                    </div>
                    {{--/Descrição do valor para outros valores não listados antes--}}
                </div>
            </div>
        </div>
    </div>
</div>