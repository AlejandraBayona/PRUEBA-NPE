@extends('layouts.app')

@section('content')

<div class="success-checkmark">
    <div class="check-icon">
        <span class="icon-line line-tip"></span>
        <span class="icon-line line-long"></span>
        <div class="icon-circle"></div>
        <div class="icon-fix"></div>
    </div>
</div>
<div class="alert alert-success text-center" role="alert">

    <h4 class="alert-heading">Mandamiento de Pago, en estado Pagado!</h4>

    <hr>
    <a class="btn btn-primary" href="/download_comprobante_pago?npe={{ $number_npe }}" target="_blank">Descargar Comprobante de Pago</a>


</div>

@endsection


@section('script')

@endsection