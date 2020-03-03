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
                                            Olá,
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


                            <p style="color:#666666; font-family:Segoe UI, Helvetica Neue, Arial, Verdana, Trebuchet MS, sans-serif; font-size:14px; line-height:24px; mso-line-height-rule:exactly;">
                                O Projeto abaixo foi alterado pelo usuário: {{$user->name}} em {{$editedProject->updated_at->format('d/m/Y')}} às {{$editedProject->updated_at->format('H:i:s')}}.
                            </p>

                            <table class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                <tr>
                                    <td style="border-bottom: 2px solid #66BB6A;"></td>
                                    <td style="border-bottom: 2px solid #66BB6A; font-weight: bold;">Atual</td>
                                    <td style="border-bottom: 2px solid #66BB6A; font-weight: bold;">Anterior</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Código</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$editedProject->compiled_cod}}</td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;{{$editedProject->compiled_cod != $originalProject->compiled_cod ? ' color: red' : ''}}">{{$originalProject->compiled_cod}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Grupo</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$editedProject->clients->first()->group->name}}</td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;{{$editedProject->clients->first()->group != $originalProject->clients->first()->group ? ' color: red' : ''}}">{{$originalProject->clients->first()->group->name}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Cliente(s)</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$editedProject->clients->implode('name' , ', ')}}</td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;{{$editedProject->clients->implode('name' , ', ') != $originalProject->clients->implode('name' , ', ') ? ' color: red' : ''}}">{{$originalProject->clients->implode('name' , ', ')}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Tipo de Projeto</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$editedProject->projectType->name}}</td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;{{$editedProject->projectType != $originalProject->projectType ? ' color: red' : ''}}">{{$originalProject->projectType->name}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Descrição do Projeto</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$editedProject->description}}</td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;{{$editedProject->description != $originalProject->description ? ' color: red' : ''}}">{{$originalProject->description}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Empresa</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$editedProject->company->name}}</td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;{{$editedProject->company != $originalProject->company ? ' color: red' : ''}}">{{!is_null($originalProject->company) ? $originalProject->company->name : null}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Início</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$editedProject->start->format('d/m/Y')}}</td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;{{$editedProject->start != $originalProject->start ? ' color: red' : ''}}">{{$originalProject->start->format('d/m/Y')}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Encerramento</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$editedProject->finish->format('d/m/Y')}}</td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;{{$editedProject->finish != $originalProject->finish ? ' color: red' : ''}}">{{$originalProject->finish->format('d/m/Y')}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Líder</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$editedProject->owner->name ?? null}}</td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;{{$editedProject->owner != $originalProject->owner ? ' color: red' : ''}}">{{ $originalProject->owner->name ?? null}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Co-líder</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$editedProject->coOwner->name ?? null}}</td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;{{$editedProject->coOwner != $originalProject->coOwner ? ' color: red' : ''}}">{{$originalProject->coOwner->name ?? null}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Horas orçadas</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$editedProject->budget}}</td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;{{$editedProject->budget != $originalProject->budget ? ' color: red' : ''}}">{{$originalProject->budget}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Número da proposta</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$editedProject->proposal_number}}</td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;{{$editedProject->proposal_number != $originalProject->proposal_number ? ' color: red' : ''}}">{{$originalProject->proposal_number}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Observação</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$editedProject->notes}}</td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;{{$editedProject->notes != $originalProject->notes ? ' color: red' : ''}}">{{$originalProject->notes ?? null}}</td>
                                </tr>
                                </tbody>
                            </table>

                            <br />

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