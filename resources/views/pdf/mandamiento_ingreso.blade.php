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
            font-size: 15.5px;
            font-style: normal;
            font-variant: normal;
            font-weight: 700;
            line-height: 10px;
        }

        .number-ref {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 13.3px;
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

        .descriptions-firmas{
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 9px;
            font-weight: bold;
            font-style: normal;
            font-variant: normal;
        }
        .descriptions-datetime{
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 9.5px;
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
            margin-top: 23px;
            border-collapse: collapse;
            /* border: black 1px solid; */
            table-layout: fixed;
        }

        ._two_header-table {
            width: 100%;
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

        .description-service{
            width: 100% !important;
            border-collapse: separate;
            border: 1px solid;
            border-top: none !important;
            table-layout: fixed;
            border-spacing: 0;
            text-align: center;
            font-size: 12px;
        }

        .description-service td {
            border-top: 1px solid black;
        }

        td.name-service {
            text-align: justify;
            border-right: 1px solid black;
            border-left: 1px solid black;
            padding: 2px;
        }
        td.name-service-title{
            text-align: center;
            border-right: 1px solid black;
            border-left: 1px solid black;
            padding: 2px;
        }
        td.value-service, td.amount-service {
            border-right: 1px solid black;
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
            padding-right: 180px;
        }
        .titulo-mandamiento{
            font-size: 18.2px;
        }

        .logo {
            
        }
        .version{
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 9px;
            font-weight: bold;
            font-style: normal;
            font-variant: normal;
            vertical-align: top;
            padding-top: 0px;
            margin-top: 0px;
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
        .name-service{
            text-transform: lowercase;
        }
    </style>
</head>

<body>

@for ($i = 0; $i <= 1; $i++)
    <div> 
        @if($i == 0)
            <table class="header-table" style="width: 100%;">
        @else
            <table class="_two_header-table" style="width: 100%;">
        @endif
        <tbody>
            <tr style="min-height:250px;">
                <td class="td-1 version">v0.2</td>
                <td class="text-center contenedor-logo td-2" style="padding-top:0;margin-top:0;" style="vertical-align:top;">
                    <div style="padding-top:0;margin-top:0;">
                        <div>
                            <img style="padding-top:0;margin-top:0;" class="logo" src="{{ storage_path() . '/images/logo.png' }}" width="27%" alt="logo" alt="">
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
                            <h1 class="titulo-mandamiento">MANDAMIENTO DE INGRESO</h1>
                        </div>
                        <div>
                            <h2>No.{{$data_merge['referencia']}}{{ $last_correlative->correlativo }}</h2>
                        </div>
                    </div>

                </td>
            </tr>
        </tbody>
    </table>

    <table class="container-table" style="width: 100%;">
        <tbody>
            <tr>
                <td rowspan="3" class="td-1" style="margin-top:0!important;padding-top:0!important;">
                    <div class="codebar" style="margin-top:0!important;padding-top:0!important;padding-bottom:61px!important;">
                        <img src="{{ public_path() }}/barcode_{{ $data_merge['id_transaction'] }}.png" alt="">
                    </div>   
                </td>
                <td style="width: 90%;">
                    <table class="main-table" width="100%" style="border-top-left-radius:10px;border-top-right-radius:10px;margin-top:0!important;padding-top:0!important;margin-bottom:0!important;padding-bottom:0!important;">
                        <tbody>
                            <tr>
                                <td style="width:50%!important;border:none;margin-bottom:0!important;padding-bottom:0!important;margin-top:0!important;padding:0!important;">
                                    <p style="text-decoration:underline;margin-top:0!important;padding-top:0!important;">Apellidos, Nombre o Razón Social</p>
                                </td>
                                <td rowspan="2" style="width:50%!important;border:none;position:relative;">
                                    <table class="nit-table" width="100%">
                                        <thead>
                                            <tr>
                                                <td style="text-decoration:underline;width:50%!important;text-align:right!important;">
                                                    <p style="padding-bottom:7px;margin-right:2px!important;" class="nit-number">NIT: </p>
                                                </td>
                                                <td style="margin-bottom:0!important;padding-bottom:0!important;">
                                                    <h1 style="padding-bottom:10px;">{{ $data_merge['nit_format'] }}</h1>
                                                </td>
                                            </tr>
                                        </thead>
                                    </table>
                                </td>
                            </tr>
                            <tr style="border-bottom:1px solid!important;margin-bottom:0!important;padding-bottom:0!important;">
                                <td style="width:50%!important;border:none;margin-bottom:0!important;padding-bottom:0!important;">
                                    <h2>{{ mb_strtoupper($data_merge['inputFirstName']) }} {{ mb_strtoupper($data_merge['inputLastName']) }}</h2>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="width:95%!important;border:none;margin-top:0!important;padding-top:0!important;">
                    <table class="container-personal-table" cellspacing="0" cellpadding="0">
                        <td style="width: 47%;border-right:1px solid;">
                            <table class="personal-table" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td style="padding-bottom:17px;padding-left:6px;padding-top:9px;" class="descriptions-pago">Origen de Pago:</td>
                                        <td class="number-ref" style="text-align:right;padding-right:22px;padding-bottom:17px;padding-top:9px;">{{ $data_merge['origen_pago'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom:17px;padding-left:6px;" class="descriptions-pago">Correlativo:</td>
                                        <td class="number-ref" style="text-align:right;padding-right:22px;padding-bottom:17px;">{{ $last_correlative->correlativo }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom:17px;padding-left:6px;" class="descriptions-pago">Ultima fecha de pago:</td>
                                        <td class="number-ref" style="text-align:right;padding-right:22px;padding-bottom:17px;">{{ $data_merge['fecha_vencimiento'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom:17px;padding-left:6px;" class="descriptions-pago">Total a Pagar (US $):</td>
                                        <td class="number-ref" style="text-align:right;padding-right:22px;padding-bottom:19px;">{{ number_format($data_merge['montoPagar'], 2,'.','') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan=2 style="padding-left:6px;padding-bottom:9px;" class="descriptions-npe">NPE:</td>
                                    </tr>
                                    <tr>
                                        <td colspan=2 style="padding-bottom:10px;padding-left:17px;" class="number-npe">{{ $data_merge['npe_with_space'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td style="width: 53%;">
                            <div>
                                <p style="padding:6px;padding-right:4px;text-align:center;padding-bottom:10px;" class="descriptions-servicio">41202 MINISTERIO DE SALUD PUBLICA Y ASISTENCIA SOCIAL</p>
                            </div>
                            <div>
                                <table class="personal-table" cellspacing="0" cellpadding="0">
                                    <tbody style="vertical-align: sub;">
                                        <tr>
                                            <td></td>
                                            <td class="descriptions-right-zone" style="text-align:right;padding-top:10px;">41250853004</td>
                                            <td class="descriptions-right-zone" style="text-align:right;padding-right:5px;padding-top:10px;">{{ number_format($data_merge['montoPagar'],2,'.','') }}</td>                    
                                        </tr>
                                        <tr>
                                            <td colspan=3 style="margin-top:15px!important;padding-left:10px;" class="descriptions-right-zone">U. {{ $data_merge['usuario']  }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan=3 style="padding-bottom:7px;padding-top:10px;padding-left:10px;" class="descriptions-right-zone">Tipo Documento. {{ $data_invoice['tipoFactura'] }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan=3 style="padding-bottom:7px;padding-left:10px;" class="descriptions-right-zone">Despacho Documento en. {{ $colector_send_fact->nombre }}</td>
                                        </tr>
                                        <tr>
                                            @if($flag_retencion == 1)
                                                <td colspan=3 style="padding-bottom:7px;padding-left:10px;" class="descriptions-right-zone">N.Serie Comprobante Retencion. {{ $data_invoice['nSerieRetencion'] }}</td>
                                            @endif
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="width:95%!important;border:none;">
                    <table class="container-personal-table" cellspacing="0" cellpadding="0" style="border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
                        <td style="width:35%;border-right:1px solid;">
                            <table class="personal-table" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td style="padding-bottom:97px;padding-left:6px;padding-top:7px;text-align:center;" class="descriptions-juramento">
                                            DECLARO BAJO JURAMENTO QUE LOS DATOS CONTENIDOS EN EL <br>
                                            PRESENTE MANDAMIENTO DE INGRESO SON EXPRESION FIEL DE <br>
                                            LA VERDAD POR LO QUE ASUMO LA RESPONSABILIDAD LEGAL <br>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td style="padding-bottom:1px;padding-left:40px;padding-right:40px;padding-top:12px;text-align:center;">
                                            <div style="border-bottom: 1px solid;">

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom:8px;padding-top:2px;text-align:center;" class="descriptions-firmas">
                                                FIRMA DEL CONTRIBUYENTE
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:6px;text-align:center;border-top:1px solid;" class="descriptions-datetime">
                                            Fecha y hora de emision: {{ $data_time_now }}
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
                                        <td style="padding-bottom:150px;padding-top:7px;text-align:center;" class="descriptions-juramento">
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
        <hr style="display: block; height: 2px; border: 0;border-top: 1.5px dashed #000;margin-top:1.9em;margin-bottom:1.6em;margin-left:0;margin-right:0;padding:0!important;"> 
    @endif
    
@endfor

<div class="page_break"></div>

<div> 
    <table class="header-table" style="width: 100%;">
        <tbody>
            <tr style="min-height:250px;">
                <td class="text-center contenedor-logo td-2">
                    <div>
                        <div>
                            <img class="logo" src="{{ storage_path() . '/images/logo.png' }}" width="27%" alt="logo" alt="">
                        </div>
                        <div>
                            <p>República de El Salvador</p>
                        </div>
                        <div>
                            <p></p>
                        </div>
                        <div>
                </td>
                <td class="contenedor-titulo">
                    <div>
                        <div>
                            <h1>DETALLE SERVICIOS</h1>
                        </div>
                        <div>
                            <h2>No.{{$data_merge['referencia']}}{{ $last_correlative->correlativo }}</h2>
                        </div>
                    </div>

                </td>
            </tr>
        </tbody>
    </table>

    <table class="container-table" style="width: 100%;">
        <tbody>
            <tr>
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
                                                <td style="text-decoration: underline;width:50%!important;text-align:right!important;">
                                                    <p class="nit-number">NIT: </p>
                                                </td>
                                                <td>
                                                    <h1>{{ $data_merge['nit_format'] }}</h1>
                                                </td>
                                            </tr>
                                        </thead>
                                    </table>
                                </td>
                            </tr>
                            <tr style="border-bottom:1px solid!important;">
                                <td style="width:50%!important;border:none;">
                                    <h2>{{ mb_strtoupper($data_merge['inputFirstName']) }} {{ mb_strtoupper($data_merge['inputLastName']) }}</h2>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="width:95%!important;border:none;">
                    <table class="container-personal-table" cellspacing="0" cellpadding="0">
                        <td style="width: 47%;border-right:1px solid;">
                            <table class="personal-table" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td style="padding-bottom:12px;padding-left:6px;padding-top:7px;" class="descriptions-pago">Origen de Pago:</td>
                                        <td class="number-ref" style="text-align:right;padding-right:20px;padding-bottom:10px;padding-top:9px;">{{ $data_merge['origen_pago'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom:12px;padding-left:6px;" class="descriptions-pago">Correlativo:</td>
                                        <td class="number-ref" style="text-align:right;padding-right:20px;padding-bottom:10px;">{{ $last_correlative->correlativo }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom:12px;padding-left:6px;" class="descriptions-pago">Ultima fecha de pago:</td>
                                        <td class="number-ref" style="text-align:right;padding-right:20px;padding-bottom:10px;">{{ $data_merge['fecha_vencimiento'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom:12px;padding-left:6px;" class="descriptions-pago">Total a Pagar (US $):</td>
                                        <td class="number-ref" style="text-align:right;padding-right:20px;padding-bottom:10px;">{{ number_format($data_merge['montoPagar'],2,'.','') }}</td>
                                    </tr>
                                    @if($flag_retencion == 1)
                                    <tr>
                                        <td style="padding-bottom:12px;padding-left:6px;" class="descriptions-pago">Retención (US $):</td>
                                        <td class="number-ref" style="text-align:right;padding-right:20px;padding-bottom:10px;">{{ number_format($retencion, 2) }}</td>
                                    </tr> 
                                    @endif 
                                </tbody>
                            </table>
                        </td>
                        <td style="width: 53%;">
                                <div>
                                    <p style="padding:6px;padding-right:4px;text-align:center;padding-bottom:10px;" class="descriptions-servicio">41202 MINISTERIO DE SALUD PUBLICA Y ASISTENCIA SOCIAL</p>
                                </div>
                                <div>
                                    <table class="personal-table" cellspacing="0" cellpadding="0">
                                        <tbody style="vertical-align: sub;">
                                            <tr>
                                                <td></td>
                                                <td class="descriptions-right-zone" style="text-align:right;padding-top:10px;">41250853004</td>
                                                <td class="descriptions-right-zone" style="text-align:right;padding-right:5px;padding-top:10px;">{{ number_format($data_merge['montoPagar'],2,'.','') }}</td>                    
                                            </tr>
                                            <tr>
                                                <td colspan=3 style="margin-top:15px!important;padding-left:10px;" class="descriptions-right-zone">U. {{ $data_merge['usuario']  }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan=3 style="padding-bottom:7px;padding-top:10px;padding-left:10px;" class="descriptions-right-zone">Tipo Documento. {{ $data_invoice['tipoFactura'] }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan=3 style="padding-bottom:7px;padding-left:10px;" class="descriptions-right-zone">Despacho Documento en. {{ $colector_send_fact->nombre }}</td>
                                            </tr>
                                            <tr>
                                                @if($flag_retencion == 1)
                                                    <td colspan=3 style="padding-bottom:7px;padding-left:10px;" class="descriptions-right-zone">N.Serie Comprobante Retencion. {{ $data_invoice['nSerieRetencion'] }}</td>
                                                @endif
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                        </td>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="width:95%!important;border:none;">
                    <table class="description-service" cellspacing="0" cellpadding="0" style="border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
                        <tr>
                            <td class="code-service" style="width: 7.5%;">Codigo</td>
                            <td class="name-service-title" style="width: 70%;">Nombre</td>
                            <td class="value-service" style="width: 7.5%;">Valor</td>
                            <td class="amount-service" style="width: 7.5%;">Cant</td>
                            <td class="total-service" style="width: 7.5%;">Total</td>
                        </tr>
                        

                        @foreach($insert_service_transaction as $servicedetail)

                            <tr class="list-service">
                                <td class="code-service" style="width: 7.5%;">{{ $servicedetail['codigo'] }}</td>
                                <td class="name-service" style="width: 70%;">{{ $servicedetail['nombre'] }}</td>
                                <td class="value-service" style="width: 7.5%;">$ {{ number_format($servicedetail['valor'],2) }}</td>
                                <td class="amount-service" style="width: 7.5%;">{{ $servicedetail['cantidad'] }}</td>
                                <td class="total-service" style="width: 7.5%;">$ {{ number_format($servicedetail['total'],2) }}</td>
                            </tr>

                        @endforeach
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <div style="text-align:center!important;font-size: 10px;">
        <i>*Esta pagina no es un mandamiento de pago y no tiene ninguna validez</i><br>
        <i>*Su mandamiento de pago tiene una validez de 10 días para ser pagado, transacurridos tales días, debera generar uno nuevo*</i><br>
        <i>*Por favor NO presentar esta pagina en Bancos*</i>

    </div>
</div>


</body>

</html>