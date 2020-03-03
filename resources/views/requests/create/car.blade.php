<div class="panel panel-dct">
    <div class="panel-heading">
        <h3 class="panel-title bold">Carros</h3>
    </div>

    <div class="panel-body" data-without-height="true" id="car-panel">
        <input type="hidden" name="has_car" value="true">
        <div class="row">
            {{--Tipo de carro--}}
            <div class="col-xs-12">
                <div class="form-group car-type-id-group {{$errors->has('car[car_type_id]') ? ' has-error' : ''}}">
                    {!! Form::label('car_type_id', 'Tipo de carro') !!}

                    {!! Form::select('car[car_type_id]', $carTypes, null, ['class' => 'form-control', 'id' => 'car_type_id', 'title' => 'Selecione o tipo de carro','required']) !!}

                    <span class="help-block">
                        <strong>{{$errors->first('car[car_type_id]')}}</strong>
                    </span>
                </div>
            </div>
            {{--/Tipo de carro--}}

            {{--Data de retirada do carro--}}
            <div class="col-sm-6 col-xs-12">
                <div class="form-group {{$errors->has('car[withdrawal_date]') ? ' has-error' : ''}}" id="withdrawal-date-group">
                    {!! Form::label('withdrawal_date', 'Data de retirada') !!}

                    {!! Form::text('car[withdrawal_date]', null, ['class' => 'form-control', 'id' => 'withdrawal_date', 'placeholder' => '__/__/____', 'data-mask' => '00/00/0000','required']) !!}

                    <span class="help-block">
                        <strong>{{$errors->first('car[withdrawal_date]')}}</strong>
                    </span>
                </div>
            </div>
            {{--/Data de retirada do carro--}}

            {{--Data de devolução do carro--}}
            <div class="col-sm-6 col-xs-12">
                <div class="form-group {{$errors->has('car[return_date]') ? ' has-error' : ''}}" id="return-date-group">
                    {!! Form::label('return_date', 'Data de devolução') !!}

                    {!! Form::text('car[return_date]', null, ['class' => 'form-control', 'id' => 'return_date', 'placeholder' => '__/__/____', 'data-mask' => '00/00/0000','required']) !!}
                    <span>
                        <strong>{{$errors->first('car[return_date]')}}</strong>
                    </span>
                </div>
            </div>
            {{--/Data de devolução do carro--}}

            {{--Hora de retirada do carro--}}
            <div class="col-sm-6 col-xs-12">
                <div class="form-group {{$errors->has('car[withdrawal_hour]') ? ' has-error' : ''}}" id="withdrawal-hour-group">
                    {!! Form::label('withdrawal_hour', 'Hora de retirada') !!}

                    {!! Form::text('car[withdrawal_hour]', null, ['class' => 'form-control timepicker', 'id' => 'withdrawal_hour', 'placeholder' => '__:__', 'data-mask' => '00:00','required']) !!}

                    <span class="help-block">
                        <strong>{{$errors->first('car[withdrawal_hour]')}}</strong>
                    </span>
                </div>
            </div>
            {{--/Hora de retirada do carro--}}

            {{--Hora da devolução do carro--}}
            <div class="col-sm-6 col-xs-12">
                <div class="form-group {{$errors->has('car[return_hour]') ? ' has-error' : ''}}" id="return-hour-group">

                    {!! Form::label('return_hour', 'Hora de devolução') !!}

                    {!! Form::text('car[return_hour]', null, ['class' => 'form-control timepicker', 'id' => 'return_hour', 'placeholder' => '__:__', 'data-mask' => '00:00','required']) !!}

                    <span class="help-block">
                        <strong>{{$errors->first('car[return_hour]')}}</strong>
                    </span>
                </div>
            </div>
            {{--Hora da devolução do carro--}}


            {{--Local de retirada do carro--}}
            <div class="col-sm-6 col-xs-12">
                <div class="form-group {{$errors->has('car[withdrawal_place]') ? ' has-error' : ''}}" id="withdrawal-place-group">
                    {!! Form::label('withdrawal_place', 'Local de retirada') !!}

                    {!! Form::text('car[withdrawal_place]', null, ['class' => 'form-control retirada', 'id' => 'withdrawal_place', 'required']) !!}

                    <span class="help-block">
                        <strong>{{$errors->first('car[withdrawal_place]')}}</strong>
                    </span>
                </div>
            </div>
            {{--/Local de retirada do carro--}}

            {{--Local de devolução--}}
            <div class="col-sm-6 col-xs-12">
                <div class="form-group {{$errors->has('car[return_place]') ? ' has-error' : ''}}" id="return-place-group">
                    {!! Form::label('return_place', 'Local de devolução') !!}

                    {!! Form::text('car[return_place]', null, ['class' => 'form-control retirada', 'id' => 'return_place', 'required']) !!}

                    <span class="help-block">
                        <strong>{{$errors->first('car[return_place]')}}</strong>
                    </span>
                </div>
            </div>
            {{--/Local de devolução--}}

            {{--Condutor do carro--}}
            <div class="col-xs-12">
                <div class="form-group first-driver-id-group {{$errors->has('car[first_driver_id]') ? ' has-error' : ''}}" id="first-driver-group">
                    <label for="first_driver_id">Condutor</label>

                    <select name="car[first_driver_id]" id="first_driver_id"
                            class="form-control"
                            title="Selecione o condutor" data-live-search="true" required="required">
                    </select>
                    <span class="help-block">
                        <strong>{{$errors->first('car[first_driver_id]')}}</strong>
                    </span>
                </div>
            </div>
            {{--/Condutor do carro--}}

            <br>

            <div class="col-xs-12">
                <div class="form-group" id="car-client-pay-group">
                    {!! Form::checkbox('car[client_pay]', 1, false, ['id' => 'car_client_pay']) !!}

                    {!! Form::label('car_client_pay', 'Pago pelo cliente', ['class' => 'pointer']) !!}
                </div>
            </div>
        </div>
    </div>
</div>