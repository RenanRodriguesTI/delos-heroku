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
                {{ $title }}: {{$project->full_description}}
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
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Líder</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{ $project->owner->name ?? null}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Co-líder</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$project->coOwner->name ?? null}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Membros atuais</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$project->members->implode('name', ', ')}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Horas orçadas</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$project->budget}}</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><b>Horas gastas</b></td>
                                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$project->getSpentHours()}}</td>
                                </tr>
                                </tbody>
                            </table>

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