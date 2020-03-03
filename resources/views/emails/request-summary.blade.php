@include('emails.tables-styles')

    <table align="center" border="0" cellpadding="0" cellspacing="0" class="display-width-inner" width="600">
        <tr>
            <td height="50" style="mso-line-height-rule:exactly; line-height:50px;">
                &nbsp;
            </td>
        </tr>
        <tr>
            <!-- TITLE -->
            <td align="center" class="MsoNormal" style="color:#333333; font-family:Segoe UI, Helvetica Neue, Arial, Verdana, Trebuchet MS, sans-serif; font-weight:700; text-transform:uppercase; font-size:26px; line-height:34px; letter-spacing:1px;" data-color="Title" data-size="Title" data-min="15" data-max="46">
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
                        <td align="left">
                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="width:auto !important;">
                                <tr>
                                    <!-- GREETING -->
                                    <td align="left" class="MsoNormal" style="color:#333333; font-family:Segoe UI, Helvetica Neue, Arial, Verdana, Trebuchet MS, sans-serif; font-weight:700; font-size:18px; line-height:24px; letter-spacing:1px;">
                                        <span style="color:#333333; text-decoration:none;" data-color="Subheading" data-size="Subheading" data-min="10" data-max="34">
                                            Olá :),
                                        </span>
                                    </td>
                                    <!-- END GREETING -->
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="10" style="mso-line-height-rule:exactly; line-height:10px; font-size:0;">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td style="color:#666666; font-family:Segoe UI, Helvetica Neue, Arial, Verdana, Trebuchet MS, sans-serif; font-size:14px; line-height:24px; mso-line-height-rule:exactly;">
                        <!-- CONTENT -->

                            @if($requests->count() > 0)
                                <p>O Delos Project identificou solicitações referente a colaboradores em alguns projetos.</p>
                            @else
                                <p>O Delos Project identificou que não há solicitações no período informado acima.</p>
                            @endif
                                <!--- loop por solicitacao aqui --->
                            @foreach($requests as $request)

                            <table class="table table-bordered" style="width: 100%;">
                                <thead>
                                <tr>
                                    <th style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px; border: 1px solid #ddd; background-image: -webkit-linear-gradient(top,#fff 0,#FBFBFB 100%); background-image: -o-linear-gradient(top,#fff 0,#FBFBFB 100%); background-image: -webkit-gradient(linear,left top,left bottom,from(#fff),to(#FBFBFB)); background-image: linear-gradient(to bottom,#fff 0,#FBFBFB 100%); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe0e0e0', GradientType=0); filter: progid:DXImageTransform.Microsoft.gradient(enabled=false); background-repeat: repeat-x; vertical-align: middle;">N&#8304; da Solicitação: {{$request->id}}</th>
                                </tr>
                                <tr>
                                    <th style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px; border: 1px solid #ddd; background-image: -webkit-linear-gradient(top,#fff 0,#FBFBFB 100%); background-image: -o-linear-gradient(top,#fff 0,#FBFBFB 100%); background-image: -webkit-gradient(linear,left top,left bottom,from(#fff),to(#FBFBFB)); background-image: linear-gradient(to bottom,#fff 0,#FBFBFB 100%); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe0e0e0', GradientType=0); filter: progid:DXImageTransform.Microsoft.gradient(enabled=false); background-repeat: repeat-x; vertical-align: middle;">Projeto: {{$request->project->full_description}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="100%" style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">
                                        <span class="bold" style="font-weight: bold;">Criado em: {{$request->created_at->format('d/m/Y H:i')}}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            @foreach($request->children as $child)
                                <table class="table table-bordered" style="width: 100%;">
                                    <tbody>
                                    <tr>
                                        <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold" style="font-weight: bold;">Colaborador(es)</span></td>
                                        <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">
                                            <!--- loop dos colaboradores aqui --->
                                            {{$child->users->implode('name', ', ')}}
                                            <!--- /loop dos colaboradores aqui --->
                                        </td>
                                    </tr>

                                    <!--- loop extras aqui --->
                                    @foreach($child->extraExpenses as $extraExpense)
                                    <tr>
                                        <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold" style="font-weight: bold;">{{$extraExpense->description}}</span></td>
                                        <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold" style="font-weight: bold;">Valor:</span> {{$extraExpense->value}}</td>
                                    </tr>
                                    @endforeach
                                    <!--- /loop extras aqui --->
                                    <tr>
                                        <td colspan="100%" style="border: 1px solid #ddd;padding: 8px;vertical-align: middle; background-color: #bdbdbd;">
                                            <span class="bold" style="font-weight: bold;">Total: <span style="color:#c12e2a">{{$child->extraExpenses->sum('value')}}</span></span>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>

                                <p><br></p>
                                <p>
                                    <hr style="background-image: -webkit-linear-gradient(left, transparent, #1b5e20, transparent); background-image: linear-gradient(to right, transparent, #1b5e20, transparent); border: 0; height: 1px; margin-bottom: 1px; margin-top: 0;">
                                </p>
                            @endforeach
                                <!--- /loop por solicitacao aqui --->
                            @endforeach


                            <p style="color:#666666; font-family:Segoe UI, Helvetica Neue, Arial, Verdana, Trebuchet MS, sans-serif; font-size:14px; line-height:24px; mso-line-height-rule:exactly;">
                                Acesse já o <a href="{{route('home.index')}}" class="bold dct-color" style="font-weight: bold;color: #4AC355;">Delos Project</a> para saber mais.
                            </p>

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