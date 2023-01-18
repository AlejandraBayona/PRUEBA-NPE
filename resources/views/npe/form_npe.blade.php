@extends('layouts.app')

@section('content')
{{-- Abrire section container--}}

<div class="section-form" id="section-personal-data">
    <form id="formSendGenerateNpe" name="formSendGenerateNpe" novalidate="novalidate">
        <div class="section-form" id="section-check-tipo-factura">
            <div class="form-row">
                <div class="form-group col-12 d-flex justify-content-center">
                <h6 class="titulos-secciones">Elige que tipo de factura deseas</h6>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-12 d-flex justify-content-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input tipo_factura" type="radio" name="tipo_factura" id="consumidor-final" value="consumidor-final" checked="checked">
                        <label class="form-check-label" for="consumidorFinal">Consumidor Final</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input tipo_factura" type="radio" name="tipo_factura" id="credito-fiscal" value="credito-fiscal">
                        <label class="form-check-label" for="creditoFiscal">Credito Fiscal</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input tipo_factura" type="radio" name="tipo_factura" id="factura-exportador" value="factura-exportacion">
                        <label class="form-check-label" for="facturaExportacion">Factura de Exportaci&oacute;n</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-form" id="section-check-tipo-persona">
            <div class="form-row">
                <div class="form-group col-12 d-flex justify-content-center">
                    <h6  class="titulos-secciones">Selecciona a que tipo de contribuyente se remitira factura y ubicaci&oacute;n de colecturia de retiro de factura</h6>
                </div>
            </div>

            <div class="form-row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="requestPersoneria">Tipo Persona <span style="color:red;">*</span></label>
                        <select class="select-personeria form-control" id="select-personeria" name="tipoPersoneria" required>
                            <option></option>
                            <option value="1">Persona Natural</option>
                            <option value="2">Persona Juridica</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="requestSelector">Seleccione la colecturia en la que desea retirar su factura <span style="color:red;">*</span></label>
                    <select class="select-colector-retiro form-control" id="select-colector-retiro" name="colectorRetiro" required>
                        <option></option>
                        @foreach($sites_collector as $site)
                        <option value="{{ $site->id }}">{{ $site->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="requestContribuyente">Tipo Contribuyente <span style="color:red;">*</span></label>
                        <select class="select-contribuyentes form-control" id="select-contribuyente" name="tipoContribuyente" required>
                            <option></option>
                            <option value="3">Pequeño Contribuyente</option>
                            <option value="4">Mediano Contribuyente</option>
                            <option value="5">Gran Contribuyente</option>
                            <option value="6">Otros Contribuyente</option>
                        </select>
                    </div>
                    
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    
                </div>
            </div>
        </div>

        <div class="section-form" id="section-comunes-data">
            <div class="form-row">
                <div class="col-12 d-flex justify-content-center">
                    <h6  class="titulos-secciones">Seleccione la direccion del establecimiento donde desea recibir los servicios</h6>
                </div>
            </div>
            <div class="form-row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="requestDepartamento">Departamento <span style="color:red;">*</span></label>
                        <select class="select-departamentos form-control" id="select-departamento" name="departamento" required>
                            <option></option>
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="requestMunicipio">Municipio <span style="color:red;">*</span></label>
                        <select class="select-municipios form-control" id="select-municipio" name="municipio" required>
                            <option></option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="form-row">
                <div class="form-group col-sm-12 col-md-6">
                    <label for="inputDireccion">Direccion <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="inputDireccion" name="inputDireccion" placeholder="Direccion" maxlength="700">
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="inputNSolicitud">Número de Solicitud SISAM (Si posee)</label>
                    <input type="text" class="form-control" id="inputSolicitud" name="inputSolicitud" maxlength="7" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" placeholder="Numero de Solicitud">
                </div>

            </div>
            <div class="form-row">
                <div class="col-sm-12 col-md-12">
                    <div class="container-form">

                        <div class="form-group">
                            <label for="requestService">Seleccione los servicio de los que desea generar NPE <span style="color:red;">*</span></label>
                            <select class="select-services form-control" id="select-service" name="servicio" required>
                                <option></option>
                                @foreach($services as $service)
                                <option data-value="{{ $service->valor }}" value="{{ $service->codigo }}">{{ $service->codigo }} - {{ $service->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group d-flex justify-content-end">
                            <div class="well clearfix">
                                <a class="btn btn-primary pull-right add-record" data-added="0"><i class="glyphicon glyphicon-plus"></i>Agregar Servicio</a>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-12">
                    <table class="table table-bordered" id="tbl_services">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Servicio</th>
                                <th>Valor</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_services_body">

                        </tbody>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Total:</th>
                                <th id="global-value-services"></th>
                                <th></th>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="form-row">
                <div class="col-12 d-flex justify-content-center">
                    <h6  class="titulos-secciones">Datos de facturaci&oacute;n</h6>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-12 col-md-6">
                    <label for="inputFirstName">Nombre <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="inputFirstName" name="inputFirstName" placeholder="Primer Nombre" maxlength="35">
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="inputLastName">Apellido o Nombre Juridico (Raz&oacute;n Social) <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="inputLastName" name="inputLastName" placeholder="Primer Apellido" maxlength="70" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-12 col-md-6"> 
                    <label for="numberNit">Numero de Nit <span style="color:red;">*</span></label>
                    <input type="text"  value="{{ $_SESSION['nit'] }}" class="form-control" id="numberNit" name="numberNit" maxlength="14" placeholder="00000000000000" pattern="^([0-9]{14})$" readonly="readonly" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" required>
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="valorService">Valor a cancelar en USD ($) <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="valueService" name="valueService" placeholder="Valor Servicio" readonly="readonly" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-sm-12 col-md-6">
                    <label for="telefono">Telefono <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="telefono" name="telefono" maxlength="8" placeholder="00000000" pattern="^([0-9]{8})$" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" required>
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="email">Correo Electronico <span style="color:red;">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
        </div>

        <div class="section-form" id="section-gran-contribuyente" style="display: none;">
            <div class="form-row">
                <div class="form-group col-12 d-flex justify-content-center">
                    <h6  class="titulos-secciones">Datos Grandes Contribuyente</h6>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-12 col-md-6">
                    <label for="inputNrc">NRC <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="inputNrc" name="inputNrc" placeholder="NRC">
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="inputGiro">Giro <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="inputGiro" name="inputGiro" placeholder="Giro">
                </div>
            </div>
            <div class="form-row" id="container-selector-retencion">
                <div class="form-group col-sm-12 col-md-6">
                    <label for="requestSelector">Desea aplicar retenci&oacute;n:</label>
                    <select class="select-retencion-cls form-control" id="select-retencion" name="selectRetencion" required>
                        <option value="-1" disabled>Seleccione una opcion ...</option>
                        <option value="0">No</option>
                        <option value="1">Si</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="section-form" id="section-retencion" style="display:none;">
            <div class="form-row">
                <div class="col-12 d-flex justify-content-center">
                    <h6  class="titulos-secciones">Datos Retenciones Grandes Contribuyente</h6>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <label for="retenciones">De su documento a declarar sobre comprobante de retencion</label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-sm-12 col-md-6">
                    <label for="inputNSerie">N. De Serie <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="inputNSerie" name="inputNSerie" placeholder="Numero de Serie">
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="inputCorrelativo">Correlativo <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="inputCorrelativo" name="inputCorrelativo" placeholder="Correlativo">
                </div>
            </div>
        </div>

        <div class="section-form" id="section-envio-factura">
            <div class="form-row">

                <div class="form-group col-sm-12 col-md-6" id="section-monto-retencion" style="display:none;">
                    <label for="valorService">Monto a retener en USD ($) <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="montoRetencion" name="montoRetencion" placeholder="Monto a retencion" readonly="readonly" required>
                </div>
            </div>
        </div>


        <input type="hidden" id="entidadId" name="entidadId" value="1">

        <button type="button" class="btn btn-primary my-1" id="btngenerateNpe">Generar NPE</button>
    </form>
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
<script src="js/app.js"></script>
@endsection