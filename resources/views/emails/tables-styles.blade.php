<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>SmartProject - Gestão de Projeto</title>

        <style>
            .bold {
                font-weight: bolder;
            }
            .panel {
                margin-bottom: 20px;
                background-color: #fff;
                border: 1px solid transparent;
                border-radius: 4px;
                -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
                box-shadow: 0 1px 1px rgba(0,0,0,.05);
            }
            .panel-dct {
                border-color: #dddee0;
            }
            .panel-title {
                margin-top: 0;
                margin-bottom: 0;
                font-size: 24px;
                color: inherit;
            }
            .panel-heading {
                padding: 16px 24px;
                border-bottom: 1px solid transparent;
                border-radius: 3px 3px 0 0;
                border-bottom: 2px solid #66BB6A;
            }
            .panel-body {
                padding: 16px 24px;
            }
            .panel-footer {
                padding: 16px 8px;
                background-color: #f2f3f3;
                border-color: #eaebec;
                border-radius: 0 0 3px 3px;
            }
            .bold{
                font-weight: bold;
            }
            .dct-color {
                color: #1b5e20;
            }
            .table{
                width: 100%;
            }
            .table-bordered>thead>tr>th {
                border: 1px solid #ddd;
            }
            .table-bordered>tbody>tr>td {
                border: 1px solid #ddd;
            }
            .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
                border-bottom-width: 2px;
                border-bottom-color: #66BB6A;
            }

            .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
                padding: 13px;
            }
            .table>tbody>tr>td{
                padding: 8px;
                vertical-align: middle;
            }
            .table-striped>tbody>tr:nth-of-type(odd) {
                background-color: #f9f9f9;
            }
        </style>

    </head>

    <body style="margin: 12px;" bgcolor="#333333">

        <table align="center" bgcolor="#333333" border="0" cellpadding="0" cellspacing="0" width="100%" data-module="Menu" data-bgcolor="Main BG" class="currentTable">
            <tr>
                <td align="center">
                    <!-- ID:BG MENU -->

                    <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" class="display-width" width="800" data-bgcolor="Menu BG">
                        <tr">
                            <td align="center" class="res-padding">

                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="display-width-inner" width="600">
                                    <tr>
                                        <td height="10" class="height30" style="mso-line-height-rule:exactly; line-height:10px; font-size:0;">
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" class="display-width-child" width="25%" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:auto;">
                                                <tr>
                                                    <td align="center">
                                                        <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:auto !important;">
                                                            <tr>
                                                                <!-- ID:TXT MENU -->

                                                                <td align="center" valign="middle" style="line-height:50px; font-size:0;">
                                                                    <a href="#" style="color:#666666; text-decoration:none;" data-color="Menu"><img src="{{ asset('images/logo-dark.png') }}" alt="150x50" width="150" style="margin:9px 0 0 0; border:0; padding:0; display:block;" /></a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" class="display-width-child" width="1" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                                <tr>
                                                    <td height="10" width="1">
                                                    </td>
                                                </tr>
                                            </table>
                                            <table align="right" border="0" cellpadding="0" cellspacing="0" class="display-width-child" width="29%" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:auto;">
                                                <tr>
                                                    <td align="center">
                                                        <table align="center" border="0" cellspacing="0" cellpadding="0" style="width:auto !important">
                                                            <tr>
                                                                <td height="10" class="height-hidden" style="mso-line-height-rule:exactly; line-height:10px; font-size:0;">
                                                                    &nbsp;
                                                                </td>
                                                            </tr>
                                                            <tr style="opacity: 0;">
                                                                <!-- ID:TXT MENU -->

                                                                <td align="left" style="line-height:0; font-size:0;">
                                                                    <a href="#" style="color:#ffffff; text-decoration:none;" data-color="Menu"><img src="{{ asset('images/fb.png') }}" alt="32x32x1" width="32" height="32" style="margin:0; border:0; padding:0; display:block;" /></a>
                                                                </td>
                                                                <td width="15">
                                                                    &nbsp;
                                                                </td>
                                                                <td align="left" style="line-height:0; font-size:0;">
                                                                    <a href="#" style="color:#ffffff; text-decoration:none;" data-color="Menu"><img src="{{ asset('images/linkedin.png') }}" alt="32x32x2" width="32" height="32" style="margin:0; border:0; padding:0; display:block;" /></a>
                                                                </td>
                                                                <td width="15">
                                                                    &nbsp;
                                                                </td>
                                                                <td align="left" style="line-height:0; font-size:0;">
                                                                    <a href="#" style="color:#ffffff; text-decoration:none;" data-color="Menu"><img src="{{ asset('images/googleplus.png') }}" alt="32x32x3" width="32" height="32" style="margin:0; border:0; padding:0; display:block;" /></a>
                                                                </td>
                                                                <td width="15">
                                                                    &nbsp;
                                                                </td>
                                                                <td align="left" style="line-height:0; font-size:0;">
                                                                    <a href="#" style="color:#ffffff; text-decoration:none;" data-color="Menu"><img src="{{ asset('images/tweeter.png') }}" alt="32x32x4" width="32" height="32" style="margin:0; border:0; padding:0; display:block;" /></a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td height="10" class="height-hidden" style="mso-line-height-rule:exactly; line-height:10px; font-size:0;">
                                                                    &nbsp;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                </table>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table align="center" bgcolor="#333333" border="0" cellpadding="0" cellspacing="0" width="100%" data-module="Our Powerful Features" data-bgcolor="Main BG">
            <tr>
                <td align="center">
                    <!-- ID:BG SECTION-1 -->

                    <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" class="display-width" width="800" data-bgcolor="Section 1 BG">
                        <tr>
                            <td align="center" class="res-padding">