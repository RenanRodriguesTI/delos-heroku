<div class="panel panel-dct">
    <div class="panel-heading">
        <h3 class="panel-title bold">Hospedagem </h3>
    </div>

    <div class="panel-body" data-without-height="true">
        <input type="hidden" name="has_lodging" value="true">
        <div class="row">
            {{--Data de checkin da hospedagem--}}
            <div class="col-sm-6 col-xs-12">
                <div class="form-group {{$errors->has('lodging[check_in]') ? ' has-error' : ''}}">
                    {!! Form::label('check_in', 'Checkin') !!}

                    {!! Form::text('lodging[check_in]', null, ['class' => 'form-control', 'id' => 'check_in', 'placeholder' => '__/__/____', 'data-mask' => '00/00/0000','required']) !!}

                    <span class="help-block">
                        <strong>{{$errors->first('lodging[check_in]')}}</strong>
                    </span>
                </div>
            </div>
            {{--/Data de checkin da hospedagem--}}

            {{--Data de checkout da hospedagem--}}
            <div class="col-sm-6 col-xs-12">
                <div class="form-group {{$errors->has('lodging[checkout]') ? ' has-error' : ''}}">
                    {!! Form::label('checkout', 'Checkout') !!}

                    {!! Form::text('lodging[checkout]', null, ['class' => 'form-control', 'id' => 'checkout', 'placeholder' => '__/__/____', 'data-mask' => '00/00/0000','required']) !!}

                    <span class="help-block">
                        <strong>{{$errors->first('lodging[checkout]')}}</strong>
                    </span>
                </div>
            </div>
            {{--/Data de checkout da hospedagem--}}

            {{--Estado da hospedagm--}}
            <div class="col-sm-4 col-xs-12">
                <div class="form-group state-group">
                    {!! Form::label('state_id', 'Estado') !!}

                    {!! Form::select('lodging[state_id]', $states, null, ['class' => 'form-control selectpicker', 'id' => 'state_id', 'title' => 'Selecione um estado', 'data-live-search' => 'true', 'required']) !!}
                </div>
            </div>
            {{--/Estado da hospedagm--}}

            {{--Cidade da hospedagm--}}
            <div class="col-sm-4 col-xs-12">
                <div class="form-group city-group {{$errors->has('lodging[city_id]') ? ' has-error' : ''}}">
                    <label for="city_id">Cidade</label>

                    <select name="lodging[city_id]" id="city_id" class="form-control selectpicker"
                            title="Selecione uma cidade" data-live-search="true" required="required">
                    </select>

                    <span class="help-block">
                        <strong>{{$errors->first('lodging[city_id]')}}</strong>
                    </span>
                </div>
            </div>
            {{--/Cidade da hospedagm--}}

            {{--Tipo de quarto da hospedagem--}}
            <div class="col-sm-4 col-xs-12">
                <div class="form-group hotel-room-id-group {{$errors->has('lodging[hotel_room_id]') ? ' has-error' : ''}}">
                    {!! Form::label('hotel_room_id', 'Tipo de quarto') !!}

                    {!! Form::select('lodging[hotel_room_id]', $hotelRooms, null, ['class' => 'form-control selectpicker', 'id' => 'hotel_room_id', 'title' => 'Selecione um tipo de quarto', 'data-live-search' => 'true', 'required']) !!}

                    <span class="help-block">
                        <strong>{{$errors->first('hotel_room_id')}}</strong>
                    </span>
                </div>
            </div>
            {{--/Tipo de quarto da hospedagem--}}

            {{--Observações da hospedagem--}}
            <div class="col-xs-12">
                <div class="form-group {{$errors->has('lodging[suggestion]') ? ' has-error' : ''}}">
                    {!! Form::label('description', 'Observação:') !!}
                    {!! Form::textarea('lodging[suggestion]', $project->lodging_notes ?? null, ['class' => 'form-control', 'id' => 'description', 'rows' => '2', 'maxlength' => '255', 'placeholder' => '---']) !!}
                    <span class="pull-right label label-default count_message description"></span>
                    <span class="help-block"><strong>{{$errors->first('lodging[suggestion]')}}</strong></span>
                </div>
            </div>
            {{--/Observações da hospedagem--}}

            <br>

            <div class="col-xs-12">
                <div class="form-group">
                    {!! Form::checkbox('lodging[client_pay]', 1, false, ['id' => 'lodging_client_pay']) !!}

                    {!! Form::label('lodging_client_pay', 'Pago pelo cliente', ['class' => 'pointer']) !!}
                </div>
            </div>
        </div>
    </div>
</div>