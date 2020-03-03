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
                {{ $project->full_description }}
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
                                            Olá {{$project->owner->name}},
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
                                O DGP identificou que há colaboradores que não atualizaram a alocação a Projetos, podem ser pendências em projetos que você lidera.
                            </p>

                            <p><span class="bold" style="font-weight: bold;">Horas totais pendentes:</span> {{$totalHours}}</p>
                            <p><span class="bold" style="font-weight: bold;">Dias sem atividade:</span> {{$totalDays}}</p>

                            <br>

                            <p>Abaixo a lista de colaboradores com pendências em seu(s) projeto(s):</p>

                            <table class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                <tr>
                                    <th style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">Colaborador</th>
                                    <th style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">Horas pendentes</th>
                                    <th style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">Dias pendentes</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($members as $member)
                                    @if($member->missingActivities->sum('hours') > 0)
                                        <tr>
                                            <td class="bold" style="font-weight: bold;border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$member->name}}</td>
                                            <td class="bold dct-color" style="font-weight: bold;color: #1b5e20;border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$member->missingActivities->sum('hours')}}</td>
                                            <td class="bold dct-color" style="font-weight: bold;color: #1b5e20;border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$member->missingActivities->count()}}</td>
                                        </tr>
                                    @endif
                                </tbody>
                                @endforeach
                            </table>

                            <p class="bold dct-color" style="font-weight: bold;color: #1b5e20;">OBS. Os colaboradores também receberam um e-mail de notificação de suas pendências.</p>


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