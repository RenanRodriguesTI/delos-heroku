@include('emails.tables-styles')

<table align="center" border="0" cellpadding="0" cellspacing="0" class="display-width-inner" width="600">
    <tr>
        <td height="50" style="mso-line-height-rule:exactly; line-height:50px;">
            &nbsp;
        </td>
    </tr>
    <tr>
        <!-- TITLE -->
        <td align="center" class="MsoNormal" style="color:#333333; font-family:Segoe UI, Helvetica Neue, Arial, Verdana, Trebuchet MS, sans-serif; font-weight:700; text-transform:uppercase; font-size:18px; line-height:24px; letter-spacing:1px;" data-color="Title" data-size="Title" data-min="15" data-max="46">
            {{ $title }}
        </td>
        <!-- END TITLE -->
    </tr>
    <tr>
        <td height="40" style="mso-line-height-rule:exactly; line-height:40px;">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td align="center">
            
            
            <table align="left" border="0" cellpadding="0" cellspacing="0" class="display-width-child" width="100%" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                <tr>
                    <td height="10" style="mso-line-height-rule:exactly; line-height:10px; font-size:0;">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td style="color:#666666; font-family:Segoe UI, Helvetica Neue, Arial, Verdana, Trebuchet MS, sans-serif; font-size:14px; line-height:24px; mso-line-height-rule:exactly;">
                        <!-- CONTENT -->
                        
                        <div class="panel-body" style="padding: 16px 24px;">
                            <table class="table table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">N&#8304; da Solicitação: {{$request->id}}</th>
                                        <th style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">Solicitante - {{$request->requester->name}} ({{$request->requester->email}})</th>
                                    </tr>
                                </thead>
                            </table>
                            <!--- Colaboradores --->
                            @foreach($request->children as $childRequest)
                            <table class="table table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">Observação </th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$request->notes ?? null}}</td>
                                    </tr>
                                </tbody>
                                <thead>
                                <tr>
                                    <th style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">Colaboradores</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$childRequest->users->implode('name', ', ')}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        
                        @if($childRequest->tickets->count() > 0)
                        <!--- Passagem --->
                        @include('requests.details.tickets', ['tickets' => $childRequest->tickets])
                        @endif
                        <br>
                        
                        <!--- Carros --->
                        @if($childRequest->car !== null)
                        @include('requests.details.cars', ['car' => $childRequest->car])
                        @endif
                        <br>
                        
                        <!--- Hospedagem --->
                        @if($childRequest->lodging !== null)
                        @include('requests.details.lodgings', ['lodging' => $childRequest->lodging])
                        @endif
                        <br>
                        
                        <!--- Extras --->
                        @if($childRequest->extraExpenses->count() > 0)
                        @include('requests.details.extra-expenses', ['extraExpenses' => $childRequest->extraExpenses])
                        @endif
                        @endforeach
                    </div>
                    
                    <br /><br />
                    
                    <font style="font-family:Verdana, Geneva, sans-serif; color:#333333; font-size:12px; line-height:20px;">
                        <a href="{{env('APP_URL')}}" style="color:#333333; text-decoration:none; margin-top: 30px;">
                            <strong>{{config('app.name')}}</strong>
                        </a>
                    </font>
                    
                    
                    <!-- END CONTENT -->
                </td>
            </tr>
        </table>
        
        
    </td>
</tr>
<tr>
    <td height="60" style="mso-line-height-rule:exactly; line-height:60px;">
        &nbsp;
    </td>
</tr>
</table>

@include('emails.footer')