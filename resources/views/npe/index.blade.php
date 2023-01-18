@extends('layouts.app')

@section('content')
@if(isset($_SESSION['msg_nit']))
<div class="alert alert-danger" role="alert">
    @php
        echo $_SESSION['msg_nit'];
        $_SESSION['msg_nit'] = null;
    @endphp
</div>
@endif

{{-- Abrire section container--}}
<div class="section-form" id="section-validate-nit">
    <div class="form-row">
        <div class="col-lg-6 col-sm-12 text-center d-flex justify-content-center" style="margin-top: 50px;">
            <div class="container-form">
                <h5>Generación de Nuevo Mandamiento de Pago</h1>
                <div class="">
                    <form id="formValidateNit" name="postNit" action="/validate_nit"  method="POST">
                        <input type="hidden" name="_token" value="">
                        <div class="form-group">
                            <label for="nit-request">Digite numero de NIT <span style="font-style: italic;">(Sin guiones)</span></label>
                            <input type="text" class="nit-input form-control" name="nitRequest" value="{{ $_SESSION['nit'] }}" id="nitRequest" autocomplete="off" maxlength="14" placeholder="00000000000000" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" required="required" readonly="readonly">
                            <label id="nitRequest-error" class="error" for="nitRequest">Por favor escriba su nit</label>
                        </div>

                        <button type="submit" class="btn btn-primary" id="btnSubmitNitValidate">Validar NIT / Ir a formulario</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-sm-12 text-center d-flex justify-content-center" style="margin-top: 50px;">
            <div class="container-form" style="width: 90%;">
                
                <div class="">
                    <form id="formPago" name="postPago" action="/pago"  method="get">
                        <div class="form-group">
                            <label for="npe-request">Digite el número NPE de Mandamiento <span style="font-style: italic;">(Sin espacios)</span></label>
                            <input type="text" class="npe-input form-control"  placeholder="##################################" name="npe" id="npe" autocomplete="off" maxlength="34" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" required="required">
                            <!-- <label id="nitRequest-error" class="error" for="nitRequest">Por favor escriba su nit</label> -->
                        </div>

                        <button type="submit" class="btn btn-primary" id="btnSubmitNpePago">Pagar Mandamiento de Pago</button>
                    </form>
                </div>
                <p style="font-style: italic;">*Si ya posee un mandamiento de pago previamente generado y desea pagarlo en linea, digite el numero de NPE del mandamiento sin guiones y de click en el boton Pagar Mandamiento de Pago</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>


@endsection


@section('script')
    <script src="js/nit_valid.js"></script>
@endsection