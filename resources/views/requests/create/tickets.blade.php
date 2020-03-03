<div class="panel panel-dct">
    <div class="panel-heading">
        <h2 class="panel-title bold">Passagem</h2>
    </div>
    <div class="panel-body" data-without-height="true">
        <input type="hidden" name="has_ticket" value="true">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <h4>Ida</h4>

                {{--Data de ida da passagem--}}
                <div class="form-group {{$errors->has('ticket[going_arrival_date]')  ? ' has-error' : ''}}">
                    {!! Form::label('going_arrival_date', 'Data') !!}

                    {!! Form::text('ticket[going_arrival_date]', null, ['class' => 'form-control', 'id' => 'going_arrival_date', 'placeholder' => '__/__/____', 'data-mask' => '00/00/0000','required']) !!}

                    <span class="help-block">
                        <strong>{{$errors->first('ticket[going_arrival_date]')}}</strong>
                    </span>
                </div>
                {{--/Data de ida da passagem--}}

                {{--Hora da ida da passagem--}}
                <div class="form-group {{$errors->has('ticket[going_arrival_time]') ? 'has-error' : ''}}">
                    {!! Form::label('going_arrival_time', 'Hora') !!}

                    {!! Form::text('ticket[going_arrival_time]', null, ['class' => 'form-control timepicker', 'id' => 'going_arrival_time', 'placeholder' => '__:__', 'data-mask' => '00:00','required']) !!}

                    <span class="help-block">
                        <strong>{{$errors->first('ticket[going_arrival_time]')}}</strong>
                    </span>
                </div>
                {{--/Hora da ida da passagem--}}

                {{--Aeroporto de origem da ida--}}
                <div class="form-group going-from-airport-group {{$errors->has('ticket[going_from_airport_id]') ? ' has-error' : ''}}">
                    <label for="going_from_airport_id">Aeroporto de Origem</label>
                    <select name="ticket[going_from_airport_id]" id="going_from_airport_id"
                            class="form-control going_from_airport_id selectpicker"
                            title="Selecione um aeroporto" data-live-search="true" required="required">
                        @foreach($airports as $airport)
                            <option value="{{$airport->id}}"
                                    data-subtext="{{$airport->state->name}}">{{$airport->initials}}
                                - {{$airport->name}}</option>
                        @endforeach
                    </select>
                    <span class="help-block">
                        <strong>{{$errors->first('ticket[going_from_airport_id]')}}</strong>
                    </span>
                </div>
                {{-- /Aeroporto de origem da ida--}}

                {{--Aeroporto de destino da ida--}}
                <div class="form-group going-to-airport-id-group {{$errors->has('ticket[going_to_airport_id]') ? ' has-error' : ''}}">
                    <label for="going_to_airport_id">Aeroporto de Destino</label>

                    <select name="ticket[going_to_airport_id]" id="going_to_airport_id"
                            class="form-control going_to_airport_id selectpicker" title="Selecione um aeroporto"
                            data-live-search="true" required="required">
                        @foreach($airports as $airport)
                            <option value="{{$airport->id}}">{{$airport->name}}
                                - {{$airport->state->name}}</option>
                        @endforeach
                    </select>
                    <span class="help-block">
                        <strong>{{$errors->first('ticket[going_to_airport_id]')}}</strong>
                    </span>
                </div>
                {{--/Aeroporto de destino da ida--}}
            </div>

            <div class="col-sm-6 col-xs-12">
                <h4>Volta</h4>

                {{--Data da volta da passagem--}}
                <div class="form-group {{$errors->has('ticket[back_arrival_date]') ? 'has-error' : ''}}">
                    {!! Form::label('back_arrival_date', 'Data') !!}

                    {!! Form::text('ticket[back_arrival_date]', null, ['class' => 'form-control', 'id' => 'back_arrival_date', 'placeholder' => '__/__/____', 'data-mask' => '00/00/0000','required']) !!}

                    <span class="help-block">
                        <strong>{{$errors->first('ticket[back_arrival_date]')}}</strong>
                    </span>
                </div>
                {{--/Data da volta da passagem--}}

                {{--Hora da volta da passagem--}}
                <div class="form-group {{$errors->has('ticket[back_arrival_time]') ? 'has-error' : ''}}">
                    {!! Form::label('ticket[back_arrival_time]', 'Hora') !!}

                    {!! Form::text('ticket[back_arrival_time]', null, ['class' => 'form-control timepicker', 'id' => 'back_arrival_time', 'placeholder' => '__:__', 'data-mask' => '00:00','required']) !!}

                    <span class="help-block">
                        <strong>{{$errors->first('ticket[back_arrival_time]')}}</strong>
                    </span>
                </div>
                {{--/Hora da volta da passagem--}}

                {{--Aeroporto de origem da volta da passagem--}}
                <div class="form-group {{$errors->has('ticket[back_from_airport_id]') ? ' has-error' : ''}}">
                    <label for="back_from_airport_id">Aeroporto de Origem</label>
                    <select name="ticket[back_from_airport_id]" id="back_from_airport_id"
                            class="form-control back_from_airport_id selectpicker"
                            title="Selecione um aeroporto" data-live-search="true" required="required">
                        @foreach($airports as $airport)
                            <option value="{{$airport->id}}">{{$airport->name}} - {{$airport->state->name}}</option>
                        @endforeach
                    </select>
                    <span class="help-block">
                        <strong>{{$errors->first('ticket[back_from_airport_id]')}}</strong>
                    </span>
                </div>
                {{--/Aeroporto de origem da volta da passagem--}}

                {{--Aeroporto de destino da volta da passagem--}}
                <div class="form-group {{$errors->has('ticket[back_to_airport_id]') ? ' has-error' : ''}}">
                    <label for="back_to_airport_id">Aeroporto de Destino</label>

                    <select name="ticket[back_to_airport_id]" id="back_to_airport_id"
                            class="form-control back_to_airport_id selectpicker" title="Selecione um aeroporto"
                            data-live-search="true" required="required">
                        @foreach($airports as $airport)
                            <option value="{{$airport->id}}">{{$airport->name}} - {{$airport->state->name}}</option>
                        @endforeach
                    </select>
                    <span class="help-block">
                        <strong>{{$errors->first('ticket[back_to_airport_id]')}}</strong>
                    </span>
                </div>
                {{--/Aeroporto de destino da volta da passagem--}}
            </div>

            <div class="col-xs-12">
                <br>

                <div class="form-group">
                    {!! Form::checkbox('ticket[has_preview]', 1, false, ['id' => 'has_preview']) !!}

                    {!! Form::label('has_preview', 'Prévia', ['class' => 'pointer']) !!}
                </div>

                <div class="form-group">
                    {!! Form::checkbox('ticket[client_pay]', 1, false, ['id' => 'ticket_client_pay']) !!}

                    {!! Form::label('ticket_client_pay', 'Pago pelo cliente', ['class' => 'pointer']) !!}
                </div>
            </div>
        </div>
    </div>
</div>