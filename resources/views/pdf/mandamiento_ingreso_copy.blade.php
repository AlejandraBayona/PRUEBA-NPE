<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0px;
            padding: 0px;
        }

        h1 {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 17.5px;
            font-style: normal;
            font-variant: normal;
            font-weight: 700;
            line-height: 10px;
        }

        .number-npe {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 15px;
            font-style: normal;
            font-variant: normal;
            font-weight: 700;
            line-height: 10px;
        }

        .number-ref {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 13px;
            font-style: normal;
            font-variant: normal;
            font-weight: 700;
            line-height: 10px;
        }

        .nit-number {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 14px;
            font-style: normal;
            font-variant: normal;
            line-height: 2px;
        }

        h3 {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 13px;
            font-style: normal;
            font-variant: normal;
            font-weight: 700;
            line-height: 20px;
        }

        h2 {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 13.5px;
            font-style: normal;
            font-variant: normal;
            font-weight: 700;
            line-height: 25px;
        }

        pre {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 15px;
            font-style: normal;
            font-variant: normal;
            font-weight: normal;
            line-height: 25px;
            text-decoration: underline;
        }

        p {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 14px;
            font-style: normal;
            font-variant: normal;
        }

        .descriptions-pago {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 12.5px;
            font-style: normal;
            font-variant: normal;
        }

        .descriptions-juramento {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 7px;
            font-style: normal;
            font-variant: normal;
        }

        .descriptions-firmas {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 8px;
            font-weight: bold;
            font-style: normal;
            font-variant: normal;
        }

        .descriptions-datetime {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 9px;
            font-style: normal;
            font-variant: normal;
        }

        .descriptions-npe {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 14px;
            font-style: normal;
            font-variant: normal;
        }

        .descriptions-servicio {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 11.5px;
            font-style: normal;
            font-variant: normal;
        }

        .descriptions-right-zone {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 13.5px;
            font-style: normal;
            font-variant: normal;
        }

        blockquote {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 21px;
            font-style: normal;
            font-variant: normal;
            font-weight: 400;
            line-height: 30px;
        }



        html {
            margin: 20px
        }

        .header-table {
            width: 100%;
            margin-top: 18px;
            border-collapse: collapse;
            /* border: black 1px solid; */
            table-layout: fixed;
        }

        .container-table {
            width: 100%;
            border-collapse: collapse;
            /* border: black 1px solid; */
            table-layout: fixed;
        }

        .main-table {
            width: 100% !important;
            border-collapse: separate;
            border: 1px solid;
            padding: 5px;
            table-layout: fixed;
        }

        .nit-table {
            width: 100% !important;
            border-collapse: separate;
            padding: 5px;
            table-layout: fixed;
        }

        .container-personal-table {
            width: 100% !important;
            border-collapse: separate;
            border: 1px solid;
            border-top: none !important;
            table-layout: fixed;
            border-spacing: 0;
        }

        .personal-table {
            width: 100% !important;
            border-collapse: collapse;
            border: none !important;
            table-layout: fixed;
            border-spacing: 0;
        }

        .td-1 {
            width: 7%;
        }

        .td-2 {
            width: 23%;
        }

        .td-3 {
            width: 70%;
        }

        .text-center {
            text-align: center;
        }

        .contenedor-titulo {
            margin-top: 0px;
            padding-top: 0px;
            vertical-align: top;
            text-align: center;
            padding-right: 175px;
        }

        .logo {}

        .version {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 10px;
            font-weight: bold;
            font-style: normal;
            font-variant: normal;
            vertical-align: top;
        }

        .page_break {
            page-break-before: always;
        }
        td[rowspan] {
            vertical-align: bottom!important;
            text-align: left!important;
            padding-left: 0px!important;
            margin-left: 0px!important;
        }
        .codebar {
            transform: rotate(270deg);
        }
    </style>
</head>

<body>

    @for ($i = 0; $i <= 1; $i++) 
    <div>
        <table class="header-table" style="width: 100%;">
            <tbody>
                <tr style="min-height:250px;">
                    <td class="td-1 version">v0.2</td>
                    <td class="text-center contenedor-logo td-2">
                        <div>
                            <div>
                                <img class="logo" src="{{ storage_path() . '/images/logo.png' }}" width="27%" alt="logo" alt="">
                            </div>
                            <div>
                                <p>República de El Salvador</p>
                            </div>
                            <div>
                                <p>Ministerio de Hacienda</p>
                            </div>
                            <div>
                    </td>
                    <td class="contenedor-titulo">
                        <div>
                            <div>
                                <h1>MANDAMIENTO DE INGRESO</h1>
                            </div>
                            <div>
                                <h2>No.</h2>
                            </div>
                        </div>

                    </td>
                </tr>
            </tbody>
        </table>

        <table class="container-table" style="width: 100%;">
            <tbody>
                <tr>
                    <td rowspan="3" class="td-1 ">
                        <div class="codebar" >
                            <img src="{{ public_path() }}/barcode.png" alt="">
                        </div>
                        
                    </td>
                    <td style="width: 90%;">
                        <table class="main-table" width="100%" style="border-top-left-radius: 10px;border-top-right-radius: 10px;">
                            <tbody>
                                <tr>
                                    <td style="width:50%!important;border:none;">
                                        <p style="text-decoration: underline;">Apellidos, Nombre o Razón Social</p>
                                    </td>
                                    <td rowspan="2" style="width:50%!important;border:none;position:relative;">
                                        <table class="nit-table" width="100%">
                                            <thead>
                                                <tr style:>
                                                    <td style="text-decoration: underline;width:50%!important;text-align: right;">
                                                        <p class="nit-number">NIT: </p>
                                                    </td>
                                                    <td>
                                                        <h1></h1>
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </td>
                                </tr>
                                <tr style="border-bottom:1px solid!important;">
                                    <td style="width:50%!important;border:none;">
                                        <h2></h2>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="width: 90%!important;border:none;">
                        <table class="container-personal-table" cellspacing="0" cellpadding="0">
                            <td style="width: 47%;border-right:1px solid;">
                                <table class="personal-table" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td style="padding-bottom:12px;padding-left:6px;padding-top:7px;" class="descriptions-pago">Origen de Pago:</td>
                                            <td class="number-ref" style="text-align:right;padding-right:20px;padding-bottom:10px;padding-top:9px;"> </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom:12px;padding-left:6px;" class="descriptions-pago">Correlativo:</td>
                                            <td class="number-ref" style="text-align:right;padding-right:20px;padding-bottom:10px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom:12px;padding-left:6px;" class="descriptions-pago">Ultima fecha de pago:</td>
                                            <td class="number-ref" style="text-align:right;padding-right:20px;padding-bottom:10px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom:12px;padding-left:6px;" class="descriptions-pago">Total a Pagar (US $):</td>
                                            <td class="number-ref" style="text-align:right;padding-right:20px;padding-bottom:10px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan=2 style="padding-left:6px;padding-bottom:10px;" class="descriptions-npe">NPE:</td>
                                        </tr>
                                        <tr>
                                            <td colspan=2 style="padding-bottom:12px;padding-left:10px;" class="number-npe"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td style="width: 53%;">
                                <div>
                                    <p style="padding:6px;padding-right:4px;text-align:center;padding-bottom:10px;" class="descriptions-servicio">41202 FONDOS VARIOS FONDO DE ACTIVIDADES ESPECIALES</p>
                                </div>
                                <div>
                                    <table class="personal-table" cellspacing="0" cellpadding="0">
                                        <tbody style="vertical-align: sub;">
                                            <tr>
                                                <td></td>
                                                <td class="descriptions-right-zone" style="text-align:right;"> :</td>
                                                <td class="descriptions-right-zone" style="text-align:right;padding-right:5px;"></td>
                                            </tr>

                                            <tr>
                                                <td style="padding-bottom:10px;padding-top:5px;padding-left:10px;" class="descriptions-right-zone">Periodo: </td>
                                                <td style="padding-bottom:10px;padding-top:5px;" class="descriptions-right-zone"></td>
                                                <td style="padding-bottom:10px;padding-top:5px;" class="descriptions-right-zone"></td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom:5px;padding-left:10px;" class="descriptions-right-zone">Num.Res.: 0</td>
                                                <td style="padding-bottom:5px;" class="descriptions-right-zone">Cuota: 0</td>
                                                <td style="padding-bottom:10px;" class="descriptions-right-zone">Num.Unic.: 0</td>
                                            </tr>
                                            <tr>
                                                <td class="descriptions-right-zone"></td>
                                                <td class="descriptions-right-zone">U.</td>
                                                <td class="descriptions-right-zone"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="width: 95%!important;border:none;">
                        <table class="container-personal-table" cellspacing="0" cellpadding="0" style="border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
                            <td style="width:35%;border-right:1px solid;">
                                <table class="personal-table" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td style="padding-bottom:95px;padding-left:6px;padding-top:7px;text-align:center;" class="descriptions-juramento">
                                                DECLARO BAJO JURAMENTO QUE LOS DATOS CONTENIDOS EN EL <br>
                                                PRESENTE MANDAMIENTO DE INGRESO SON EXPRESION FIEL DE <br>
                                                LA VERDAD POR LO QUE ASUMO LA RESPONSABILIDAD LEGAL <br>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td style="padding-bottom:1px;padding-left:40px;padding-right:40px;text-align:center;">
                                                <div style="border-bottom: 1px solid;">

                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom:12px;padding-top:4px;text-align:center;" class="descriptions-firmas">
                                                FIRMA DEL CONTRIBUYENTE
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom:3px;padding-left:6px;text-align:center;border-top:1px solid;" class="descriptions-datetime">
                                                Fecha y hora de emision: 27/01/2021 09:51:28 AM
                                            </td>
                                        </tr>
                                        <tr>
                                    </tbody>
                                </table>
                            </td>
                            <td style="width:65%;">
                                <table class="personal-table" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td style="padding-bottom:140px;padding-top:7px;text-align:center;" class="descriptions-juramento">
                                                USO EXCLUSIVO DE LA DIRECCION GENERAL DE TESORERIA O ENTIDAD AUTORIZADA
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom:1px;padding-left:100px;padding-right:100px;text-align:center;">
                                                <div style="border-bottom: 1px solid;">

                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom:0px;padding-top:2px;text-align:center;vertical-align:bottom;" class="descriptions-firmas">

                                                SELLO, FECHA Y FIRMA DE RECEPTOR AUTORIZADO
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

        <!-- Copia Mandamiento -->
        @if($i == 0)
        <hr style="display: block; height: 2px; border: 0; border-top: 1.5px dashed #000; margin: 2em 0; padding: 0;">
        @endif

        @endfor
</body>

</html>