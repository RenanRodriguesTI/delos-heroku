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
                                Existe um novo Projeto no Delos Project :)
                            </p>

                            <table class="table table-bordered table-striped" style="width: 100%;">
                                <tbody>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Código</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$project->compiled_cod}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Grupo</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$project->clients()->first()->group->name}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Cliente(s)</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$project->clients->implode('name' , ', ')}}</td>
                                </tr>

                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Tipo de Projeto</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$project->projectType->name}}</td>
                                </tr>

                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Descrição completa do Projeto</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$project->full_description}}</td>
                                </tr>

                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Líder</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{ $project->owner->name ?? null}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Co-líder</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$project->coOwner->name ?? null}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Horas orçadas</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$project->budget}}</td>
                                </tr>

                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Número da proposta</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$project->proposal_number}}</td>
                                </tr>

                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Data de criação do projeto</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$project->created_at->format('d/m/Y H:i')}}</td>
                                </tr>

                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Data de início do projeto</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$project->start->format('d/m/Y')}}</td>
                                </tr>

                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Data de encerramento do projeto</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$project->finish->format('d/m/Y')}}</td>
                                </tr>

                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Observação</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$project->notes ?? null}}</td>
                                </tr>

                                </tbody>
                            </table>

                            <br />

                            <p style="color:#666666; font-family:Segoe UI, Helvetica Neue, Arial, Verdana, Trebuchet MS, sans-serif; font-size:14px; line-height:24px; mso-line-height-rule:exactly;">
                                Acesse o <a href="{{route('home.index')}}" class="bold dct-color" style="font-weight: bold;color: #4AC355;">Delos Project</a> para saber mais.
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