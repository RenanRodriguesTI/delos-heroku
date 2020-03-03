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
                                Existem Folgas a serem aprovadas no Delos Project
                            </p>

                            <table class="table table-bordered" style="width: 100%;">
                                <thead>
                                <tr>
                                    <th style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">Colaborador</th>
                                    <th style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">Data</th>
                                    <th style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">Qtde de horas</th>
                                    <th style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">Criado em</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rests as $rest)
                                    <tr>
                                        <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$rest->user->name}}</td>
                                        <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$rest->date->format('d/m/Y')}}</td>
                                        <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$rest->hours}}</td>
                                        <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">{{$rest->created_at->format('d/m/Y')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <br />

                            <p style="color:#666666; font-family:Segoe UI, Helvetica Neue, Arial, Verdana, Trebuchet MS, sans-serif; font-size:14px; line-height:24px; mso-line-height-rule:exactly;">
                                Acesse o <a href="{{route('rests.unapproved')}}" class="bold dct-color" style="font-weight: bold;color: #4AC355;">Delos Project</a> para saber mais.
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