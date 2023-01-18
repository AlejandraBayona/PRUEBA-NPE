<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page {margin:0;padding:0; width: 100%!important;}
        body { margin:0;padding:0; width: 100%!important;}
        html {
            margin:0;padding:0;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-style: normal;
            font-variant: normal;
            width: 100%!important;
            
        }
        .container-table {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
        }
        .tr-width .td-1 {
            width: 20%;
        }
        .tr-width .td-2 {
            width: 35%;
        }
        .tr-width .td-3 {
            width: 45%;
        }

        .img-logo {
            display: block!important;
            margin-left: 54%!important;
            width: 70%;
        }
        .n-mh{
            text-align: center!important;
            font-size: 10.5px;
            margin-top: 20px!important;
        }
        .n-dgt{
            text-align: center!important;
            font-size: 9.3px;
            margin-top: 10px!important;
        }
        .n-cp{
            text-align: center!important;
            font-size: 9.3px;
            margin-top: 70px!important;
        }
        .info{
            font-size: 13px;
            margin-bottom: 20px!important;
            padding-left: 70px!important;
        }
        .info-detail{
            font-size: 14px;
            margin-bottom: 20px!important;
            font-weight: bold;
        }
        .info-detail-npe{
            margin-top: 50px!important;
        }
        .info-npe{
            margin-top: 50px!important;
        }
        #foo {
            position: absolute;
            bottom: 50;
            right: 80;
            z-index:1000;
            font-size: 14px;
        }
    </style>
    <title>Comprobante Pago</title>
</head>

<body style="padding-right:0px!important;margin-right:0px!important;">
    
    <table class="container-table" cellspacing="0" cellpadding="0">

        <tr class="logo tr-width">
            <td class="td-1"></td>
            <td class="td-2">
                <img class="img-logo" src="{{ storage_path() . '/images/logo-gobierno-el-salvador.png' }}" alt="logo">
            </td>
            <td class="td-3"></td>
        </tr>

        <tr class="nombre-ministerio tr-width">
            <td colspan=3 class="n-mh"><h1>Ministerio de Hacienda</h1></td>
        </tr>

        <tr class="nombre-direccion tr-width">
            <td colspan=3 class="n-dgt"><h1>Dirección General de Tesorería</h2></td>
        </tr>

        <tr class="nombre-titulo-comprobante tr-width">
            <td colspan=3 class="n-cp"><h1>COMPROBANTE DE PAGO</h1></td>
        </tr>

        <tr class="info-detalle tr-width">
            <td class="td-1"></td>
            <td class="td-2 info info-npe">NPE:</td>
            <td style="text-align:left;" class="td-3 info-detail info-detail-npe">{{ $data["npe"] }}</td>
        </tr>

        <tr class="info-detalle tr-width">
            <td class="td-1"></td>
            <td class="td-2 info">Fecha de Pago:</td>
            <td class="td-3 info-detail">{{ $data["fecha_pago"] }}</td>
        </tr>

        <tr class="info-detalle tr-width">
            <td class="td-1"></td>
            <td class="info td-2">Monto Total ($):</td>
            <td class="td-3  info-detail">{{ $data["monto_total"] }}</td>
        </tr>

        <tr class="info-detalle tr-width">
            <td class="td-1"></td>
            <td class="info td-2">Numero de Autorizacion:</td>
            <td class="td-3 info-detail">{{ $data["numero_autorizacion"] }}</td>
        </tr>

    </table>
    <div id="foo">{{ $data["current_date"] }}</div>
    <div style="width:100%!important;position:absolute;left:450px;top:0px;right:0px;bottom: 0px;z-index:-1000;padding-right:0px!important;margin-right:0px!important;">
        <img src="{{ storage_path() . '/images/logo-gobierno-el-salvador-mitad.png' }}" style="width:100%;padding-right:0px!important;margin-right:0px!important;margin-top:15%;opacity:0.04">
    </div>
    
</body>

</html>