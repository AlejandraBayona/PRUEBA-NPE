@extends('layouts.app_auth')
@section('css')
<link rel="stylesheet" href="css/register.css">
@endsection
@section('content')
{{-- Abrire section container--}}

<div class="d-flex justify-content-center">
    <h3>Registro de Contribuyente</h3>
</div>
<br>
@php
if(session_status() === PHP_SESSION_NONE){
session_start();
}
@endphp

@if(isset($_SESSION['error_register']))
<div class="alert alert-danger" role="al<ert">
    @php
    echo $_SESSION['error_register'];
    session_unset();
    session_destroy();
    @endphp
</div>
@endif
@php

@endphp
<div class="section-form" id="section-validate-nit">
    <form id="formValidateRegister" name="form-register" action="/register_store" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 text-center justify-content-center">
                <div class="container-form">
                    <div class="form-register-container">


                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Tipo de Registro</label>
                            <select class="form-control" name="tipo_registro" id="tipo_registro" required1>
                                <option disabled value="" selected>-------- Seleccione ----------</option>
                                <option value="1">Persona Natural</option>
                                <option value="2">Sociedades</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nit-request">NIT<span class="text-md-right" style="font-size: 13px;"></span></label>
                            <input @if(isset( $request['nitRequest'] )) value="{{  $request['nitRequest']  }}" @endif type="text" class="form-control" name="nitRequest" id="nitRequest" autocomplete="off" maxlength="14" placeholder="00000000000000" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" required="required" aria-invalid="true">
                            <small id="passwordHelp" class="form-text text-muted">Ingrese su número de NIT sin guiones</small>
                        </div>

                        <div class="form-group">

                            <label for="firstname">Nombres o (nombre empresa)</label>
                            <input @if(isset( $request['firstname'] )) value="{{  $request['firstname']  }}" @endif type="text" class="form-control" name="firstname" id="firstname" maxlength="255" required="required">

                        </div>

                        <div class="form-group" id="input_apellido">

                            <label for="lastname">Apellidos</label>
                            <input @if(isset( $request['lastname'] )) value="{{  $request['lastname']  }}" @endif type="text" class="form-control" name="lastname" id="lastname" maxlength="255">

                        </div>

                        <div class="form-group">

                            <label for="username">Nombre de Usuario</label>
                            <input @if(isset( $request['username'] )) value="{{  $request['username']  }}" @endif type="text" class="form-control"  onKeypress="if (event.keyCode == 32 ) event.returnValue = false;" name="username" id="username" maxlength="30">

                        </div>

                        <div class="form-group">

                            <label for="email">Correo Electronico</label>
                            <input @if(isset( $request['email'] )) value="{{  $request['email']  }}" @endif type="email" class="form-control" name="email" id="email" placeholder="Correo Electronico" required="required">

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 text-center justify-content-center">

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" required="required" minlength="9">
                    <small id="passwordHelp" class="form-text text-muted">Su contraseña debe contener mas de 8 caracteres y acepta número, letras y caracteres especiales</small>
                </div>

                <div class="form-group">
                    <label for="confirm-password">Confirmar Contraseña</label>
                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirmar Contraseña" id="confirm-password" required="required" minlength="9">

                </div>

                <div class="form-group">
                    <label for="confirm-password">Copia de NIT*</label>
                    <input type="file" class="form-control" id='pdf_nit' name='pdf_nit' accept="application/pdf" required>
                    <small id="nitHelp" class="form-text text-muted">Copia escaneada del documento NIT, con extensión PDF, Maximo de tamaño 3MB.</small>

                </div>

                <div class="form-group" id="input-dui">
                    <label for="confirm-password">Copia de DUI*</label>
                    <input type="file" class="form-control" id='pdf_dui' name='pdf_dui' accept="application/pdf">
                    <small id="duiHelp" class="form-text text-muted">Copia escaneada del NIT, con extensión PDF, Maximo de tamaño 3MB.</small>
                </div>

                <div class="form-group" id="input-nrc" style="display:none;">
                    <label for="confirm-password">Copia de Tarjeta NRC*</label>
                    <input type="file" class="form-control" id='pdf_nrc' name='pdf_nrc' accept="application/pdf">
                    <small id="nrcHelp" class="form-text text-muted">Copia escaneada del documento NRC, con extensión PDF, Maximo de tamaño 3MB.</small>
                </div>


            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 text-center justify-content-center">
                <a class="btn btn-secondary" href="{{ url('/')}}"><i class="fa fa-arrow-circle-left" style="margin-right: 10px;"></i>Regresar</a>
                <button type="submit" class="btn btn-primary" id="btnSubmitNitValidate">Registrarse</button>
            </div>
        </div>
    </form>
</div>


@endsection

@section('script')
<script src="js/register.js"></script>
@endsection