/**
 * Funcion para validar nit en backend
 */
function ajax_validate_nit(numberNit) {
    $.ajax({
        type: "POST",
        url: 'npe/validate_nit',
        contentType: "application/json",
        dataType: "json",
        data: {
            "nit": numberNit
        },
        success: function (response) {

        },
        error: function (response) {
            
        }
    }); /** End .ajax validate nit */
}


/**
 * Funcion para obtener servicios por colector
 */

function ajax_get_services(id_colector) {



    $.ajax({
        type: "GET",
        url: 'npe/get_services_colector',
        dataType: "json",
        data: {
            "value_colector": id_colector
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Cargando Datos...',
                html: 'Por favor Espere...',
                allowEscapeKey: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        },
        success: function (response) {
            if (response.success == true) {
                let string_option_services = "<option></option>";
                $.each(response.services, function (index, value) {
                    string_option_services += `<option data-value="${value.valor.toPrecision(4)}" value="${value.codigo}">${value.nombre}</option>`
                });
                var mySelect = $(".select-services").html(string_option_services);
                mySelect.trigger("change");
            }
            swal.close();
        },
        error: function (response) {
            Swal.fire({
                type: 'error',
                title: 'Lo sentimos',
                text: 'No se pudo recuperar los servicios'
            });

        }
    }); /** End .ajax get service by manifold */
}


/**
 * Funcion para obtener municipios por departamento
 */

function ajax_get_municipalities(id_departamento) {

    $.ajax({
        type: "POST",
        url: 'npe/get_municipios_departamento',
        dataType: "json",
        data: {
            "value_departamento": id_departamento
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Cargando Datos...',
                html: 'Por favor Espere...',
                allowEscapeKey: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        },
        success: function (response) {
            if (response.success == true) {

                let string_option_municipios = "<option></option>";
                $.each(response.services, function (index, value) {
                    string_option_municipios += `<option value="${value.id}">${value.nombre}</option>`
                });
                var mySelect = $(".select-municipios").html(string_option_municipios);
                mySelect.trigger("change");

            }
            swal.close();
        },
        error: function (response) {
            Swal.fire({
                type: 'error',
                title: 'Lo sentimos',
                text: 'No se pudo obtener los municipios'
            });
        }
    }); /** End .ajax get service by manifold */
}

function ajax_create_mandamiento(send_data) {
    $.ajax({
        type: "POST",
        url: 'npe/create_mandamiento',
        dataType: "json",
        data: send_data,
        beforeSend: function () {
            $("#app").hide();
            $("#page-loader").show();
        },
        success: function (response) {

            if (response.error == true) {
                $("#section-personal-data").html(`
                    <div class="alert alert-danger text-center" role="alert">
                        <h4 class="alert-heading">No pudimos generar su NPE, ${response.message} intentelo nuevamente!</h4>
                        <p>Si los problemas persisten contacte a soporte tecnico.</p>
                        <hr>
                    </div>`);
            } else {
                $("#section-personal-data").html(`<div class="success-checkmark">
                                                        <div class="check-icon">
                                                            <span class="icon-line line-tip"></span>
                                                            <span class="icon-line line-long"></span>
                                                            <div class="icon-circle"></div>
                                                            <div class="icon-fix"></div>
                                                        </div>
                                                   </div>
                                                <div class="alert alert-success text-center" role="alert">

                                                    <h4 class="alert-heading">NPE Creado con exito!</h4>
                                                    <h6>Opción 1</h6>
                                                    <p>Puedes descargar en pdf tu mandamiento de pago y pagarlo en Ventanillas o Medios Digitales exclusivamente de Banco Agricola</p> <br>
                                                    <a class="btn btn-primary" href="${response.url}/print_pdf/${response.data}"  title="Descargue PDF de mandamiento de pago, para realizar su pago en ventanillas y medios digitales exclusivamente de Banco Agricola">Descargar PDF de Mandamiento</a><br>
                                                    <hr>
                                                    <h6>Opción 2</h6>
                                                    <p>Pagar Mandimiento en linea con tarjetas VISA y MasterCard</p>
                                                    <a class="btn btn-primary pago-mandamiento" data-value="${response.npe}" data-id="${response.data}" href="${response.url}/pago?npe=${response.npe}" target="_blank" title="Pagar Mandimiento en linea con tarjetas VISA y MasterCard">Pagar Mandamiento En Linea</a>
                                                    <p style="font-size:12px;font-style: italic;">*Al pagar con tarjetas internacionales, tendra un recargo del 7% del valor total de la transaccion*</p>
                                                </div>`);
            }
            $("#page-loader").hide();
            $("#app").show();
            $("#btn-back-home").show();

        },
        error: function (response) {
            console.log(response);
            $("#page-loader").hide();
            $("#app").show();
            $("#section-personal-data").html(`
            <div class="alert alert-danger text-center" role="alert">
                <h4 class="alert-heading">No pudimos generar su NPE, intentelo nuevamente!</h4>
                <p>Si los problemas persisten contacte a soporte tecnico.</p>
                <hr>
            </div>`);
            $("#btn-back-home").show();
        }
    }); /** End .ajax post create mandamiento */
}


function validate_data_npe() {


    if ($("#select-contribuyente").val() == "5") {

        $('#inputNrc').rules('add', {  // dynamically declare the rules
            required: true,
            messages: {
                required: "Por favor escriba su numero de registro de contribuyente"
            }
        });

        $('#inputGiro').rules('add', {  // dynamically declare the rules
            required: true,
            messages: {
                required: "Por favor escriba el giro"
            }
        });

        let valores = 0;
        $("#tbl_services tr").find(".total-servicio").each(function () {
            valores += parseFloat($(this).html());
        });

        if (valores.toFixed(2) > 100) {
            $('#inputNSerie').rules('add', {  // dynamically declare the rules
                required: true,
                messages: {
                    required: "Es obligatorio que digite el Numero de Serie de su comprobante de retencion"
                }
            });

            $('#inputCorrelativo').rules('add', {  // dynamically declare the rules
                required: true,
                messages: {
                    required: "Es obligatorio que digite el correlativo de de su comprobante de retencion"
                }
            });
        } else {
            $("#inputNSerie").rules("remove");
            $("#inputCorrelativo").rules("remove");
        }
    }
}

function calculo_total(tipo_contributor) {
    /** Obtendre el valor de factura seleccionada */
    let tipo_factura = "";
    $('input[name="tipo_factura"]:checked').each(function () {
        tipo_factura = this.value;
        return true;
    });
    let valores = 0;
    let retencion = 0;

    $("#tbl_services tr").find(".total-servicio").each(function () {

        valores += parseFloat($(this).html());

    });

    $("#global-value-services").html(valores.toFixed(2));

    $("#valueService").val(valores.toFixed(2));

    if (tipo_contributor == 5 && tipo_factura === 'credito-fiscal') {

        if (valores.toFixed(2) > 100) {

            //recorrere el total de los servicios y les calculare su retencion indv.
            //y asi obtendre el global de retencion

            // $("#tbl_services tr").find(".total-servicio").each(function () {

            //     let precio_actual   = parseFloat($(this).html());
            //     let retencion_indv  = (precio_actual / 1.13) * 0.01;
            //     retencion += Math.round(retencion_indv * 100) / 100;


            // });


            //Primero le quitare el iva al valor total
            let valor_sin_iva = valores.toFixed(2) / 1.13;
            retencion = valor_sin_iva.toFixed(2) * 0.01;

            $("#section-retencion").css("display", "block");
            $("#section-monto-retencion").css("display", "block");
            $("#montoRetencion").val(retencion.toFixed(2));
            $("#valueService").val((valores - retencion).toFixed(2));

        } else {
            $("#section-retencion").css("display", "none");
            $("#section-monto-retencion").css("display", "none");
            $("#montoRetencion").val(retencion.toFixed(2));

        }
    } else if (tipo_contributor == 5 && tipo_factura === 'consumidor-final') {

        if (valores.toFixed(2) > 100) {

            let valor_select = $('#select-retencion').val();

            if (valor_select == 1) {
                //Primero le quitare el iva al valor total
                let valor_sin_iva = valores.toFixed(2) / 1.13;
                retencion = valor_sin_iva.toFixed(2) * 0.01;
                // $("#tbl_services tr").find(".total-servicio").each(function () {
                //     let precio_actual   = parseFloat($(this).html());
                //     let retencion_indv  = (precio_actual / 1.13) * 0.01;
                //     retencion += Math.round(retencion_indv * 100) / 100;
                // });
                
                $("#section-retencion").css("display", "block");
                $("#section-monto-retencion").css("display", "block");
                $("#montoRetencion").val(retencion.toFixed(2));
                $("#valueService").val((valores - retencion).toFixed(2));
            } else {
                $("#section-retencion").css("display", "none");
                $("#section-monto-retencion").css("display", "none");
                $("#montoRetencion").val(retencion.toFixed(2));
                $("#valueService").val(valores.toFixed(2));

            }

        } else {

            $("#section-retencion").css("display", "none");
            $("#section-monto-retencion").css("display", "none");
            $("#montoRetencion").val(retencion.toFixed(2));
            $("#valueService").val(valores.toFixed(2));

        }

    } else {
        $("#section-retencion").css("display", "none");
        $("#section-monto-retencion").css("display", "none");
        $("#montoRetencion").val(retencion.toFixed(2));
        $("#valueService").val(valores.toFixed(2));
    }
}

function manejo_select_retencion() {
    let factura_seleccionada = "";
    let type_contribuyente = $('#select-contribuyente').val();

    $('input[name="tipo_factura"]:checked').each(function () {
        factura_seleccionada = this.value;
        return true;
    });

    if (factura_seleccionada == 'credito-fiscal') {

        $("#container-selector-retencion").hide();

    } else if (factura_seleccionada == 'consumidor-final' && type_contribuyente == 5) {

        let valores = 0;
        $("#tbl_services tr").find(".total-servicio").each(function () {
            valores += parseFloat($(this).html());
        });

        if (valores > 100) {
            $("#container-selector-retencion").show();
        } else {
            $("#container-selector-retencion").hide();
        }

    }
}




var validator2 = $("#formSendGenerateNpe").validate({
    rules: {
        tipo_factura: "required"
    },
    messages: {
        tipo_factura: "Debes seleccionar un tipo de factura"
    }
});

validator2.resetForm();

/** 
 * Declarando reglas de validacion frontend form data npe and fact 
 * 
 */

$('#inputDireccion').rules('add', {  // dynamically declare the rules
    required: true,
    messages: {
        required: "Escriba la direccion especifica"
    }
});



$('#select-contribuyente').rules('add', {  // dynamically declare the rules
    required: true,
    messages: {
        required: "Selecciona un tipo de contribuyente"
    }
});

$('#select-personeria').rules('add', {  // dynamically declare the rules
    required: true,
    messages: {
        required: "Selecciona tipo de persona"
    }
});

$('#select-departamento').rules('add', {  // dynamically declare the rules
    required: true,
    messages: {
        required: "Selecciona un departamento"
    }
});

$('#select-municipio').rules('add', {  // dynamically declare the rules
    required: true,
    messages: {
        required: "Selecciona un municipio"
    }
});

$('#select-manifold').rules('add', {  // dynamically declare the rules
    required: true,
    messages: {
        required: "Selecciona un colector"
    }
});

$('#select-service').rules('add', {  // dynamically declare the rules
    required: true,
    messages: {
        required: "Debes agregar al menos un servicio, seleccionelo y de click en agregar servicio"
    }
});

$('#telefono').rules('add', {  // dynamically declare the rules
    required: true,
    messages: {
        required: "Digita tu numero de telefono"
    }
});

$('#email').rules('add', {  // dynamically declare the rules
    required: true,
    messages: {
        required: "Digita tu correo electronico",
        email: true
    }
});

$('#inputLastName').rules('add', {  // dynamically declare the rules
    required: true,
    messages: {
        required: "Por favor escriba su apellido"
    }
});
$('#valueService').rules('add', {  // dynamically declare the rules
    required: true,
    messages: {
        required: "Por favor agregue al menos un servicio"
    }
});

$('#select-colector-retiro').rules('add', {  // dynamically declare the rules
    required: true,
    messages: {
        required: "Por favor seleccione el colector donde retirara su factura"
    }
});

/**
 * 
 * Document on ready
 */

$(document).ready(function () {



    let global_service = [];

    // IMask(document.getElementById('nitRequest'), { mask: '00000000000000' });

    /**
     * Inicializando Select2 en selectores servicios y colectores
     */

    $('.select-manifolds').select2({
        placeholder: 'Seleccione un colector'
    });

    $('.select-services').select2({
        placeholder: "Seleccione un servicio"
    });

    $('.select-departamentos').select2({
        placeholder: "Seleccione un departamento"
    });

    $('.select-municipios').select2({
        placeholder: "Seleccione un municipio"
    });

    $('.select-colector-retiro').select2({
        placeholder: "Seleccione la colecturia donde retirara su factura"
    });

    $('#select-contribuyente').select2({
        placeholder: "Seleccione tipo de contribuyente"
    });

    $('#select-personeria').select2({
        placeholder: "Seleccione tipo de persona"
    });

    /****
     * 
     * Funcion para validar NIT, se validara formato 
     * Se consultara API Minsal para verificar NIT valido
     * 
     */

    // $("#btnSubmitNitValidate").on("click", function (e) {

    //     //Verificando formato de nit introducido

    //     if ($("#formValidateNit").valid() == false) {
    //         return false;
    //     }
    //     const regex = /^([0-9]{14})$/g;

    //     let input_value_nit = $("#formValidateNit #nitRequest").val();
    //     let flag_validate_nit = regex.test(input_value_nit);

    //     if (!flag_validate_nit) {
    //         // alert('Error, nit invalido');
    //         return false;
    //     }


    //     $("#section-validate-nit").hide();
    //     $("#section-personal-data").css("display", "block");


    //     $("#numberNit").val(input_value_nit);

    //     // ajax_validate_nit(input_value_nit);


    // });



    /***
     * 
     * Funcion para conectarse a backend y generar NPE
     */

    $("#btngenerateNpe").on("click", function (e) {

        /** Primero hare una validacion de la data */
        validate_data_npe();

        if ($('#formSendGenerateNpe').valid() == false) {

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor, complete la información solicitada!'
            });
            return false;

        }
        let size = 0;
        size = $('#tbl_services >tbody >tr').length;
        if (size == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor, debe agregar al menos un servicio!'
            });
            return false;
        }
        let servicios = [];
        // let valores = 0;

        $("#tbl_services tr").find(".codigo-servicio").each(function () {
            servicios.push($(this).html());
        });
        // $("#valueService").val(valores.toFixed(2));

        let object_data_send = {
            "numberNit"         : $("#numberNit").val(),
            "inputLastName"     : $("#inputLastName").val(),
            "valueService"      : $("#valueService").val(),
            "servicio"          : $("#select-service").val(),
            "colector"          : $("#select-manifold").val(),
            "entidadId"         : $("#entidadId").val(),
            "inputFirstName"    : $("#inputFirstName").val(),
            "servicios"         : global_service,
            "tipoFactura"       : $("input[name='tipo_factura']:checked").val(),
            "departamento"      : $("#select-departamento").val(),
            "municipio"         : $("#select-municipio").val(),
            "direccion"         : $("#inputDireccion").val(),
            "telefono"          : $("#telefono").val(),
            "email"             : $("#email").val(),
            "tipoContribuyente" : $("#select-contribuyente").val(),
            "nrc"               : $("#inputNrc").val(),
            "giro"              : $("#inputGiro").val(),
            "nSerieRetencion"   : $("#inputNSerie").val(),
            "correlativoRetencion": $("#inputCorrelativo").val(),
            "montoRetencion"    : $("#montoRetencion").val(),
            "colectorRetiroFactura" : $("#select-colector-retiro").val(),
            "opcionalRetencion"     : $("#select-retencion").val(),
            "opcionalNSolicitud"    : $("#inputSolicitud").val(),
            "personeria"            : $("#select-personeria").val()
        };

        ajax_create_mandamiento(object_data_send);


    });


    /** 
     * Event change manifold and get service by manifold 
     * 
     * */
    $(".select-manifolds").change(function () {
        let value_colector_selected = $(this).val();

        ajax_get_services(value_colector_selected);
    });

    /** 
     * Event change departament and get municipalities by department 
     * 
     * */
    $(".select-departamentos").change(function () {
        let value_department_selected = $(this).val();

        ajax_get_municipalities(value_department_selected);
    });

    $("#select-personeria").change(function () {
        let value_personeria_selected = $(this).val();

        if(value_personeria_selected == 1){

            $("#inputFirstName").prop("readonly", false);
            $('#inputFirstName').rules('add', {  // dynamically declare the rules
                required: true,
                messages: {
                    required: "Por favor escriba su nombre"
                }
            });
        }else{
            $("#inputFirstName").rules("remove");
            $("#inputFirstName").val("");
            $("#inputFirstName").prop("readonly", true);
        }

    });

    $(".select-contribuyentes").change(function () {
        let value_contributor_selected = $(this).val();

        if (value_contributor_selected == 5) {

            $("#section-gran-contribuyente").css("display", "block");

        } else {
            $("#section-gran-contribuyente").css("display", "none");
        }
        manejo_select_retencion();
        calculo_total(value_contributor_selected);
    });




    $(document).on('click', 'a.add-record', function (e) {
        e.preventDefault();
        let cod_service = $(".select-services").find(':selected').val();
        if (cod_service == "") {
            alert('seleccione un servicio');
            return false;
        }
        let amount_service = $(".select-services").find(':selected').data('value');
        let nom_service = $(".select-services").find(':selected').text();

        size = $('#tbl_services >tbody >tr').length + 1;
        let flag_exists_service = 0;

        $("#tbl_services tr").find(".codigo-servicio").each(function () {
            if ($(this).html() == cod_service) {
                flag_exists_service = 1;
            }
        });

        if (flag_exists_service == 0) {

            var content = `<tr id="cod-${cod_service}">
                            <td class="codigo-servicio">${cod_service}</td>
                            <td>${nom_service}</td>
                            <td class="monto-servicio">${amount_service.toFixed(2)}</td>
                            <td class="cantidad-servicio"> <input type="number" data-id="${cod_service}" class="input-cantidad" name="cant-${cod_service}" min="1" max="50" value="1"></td>
                            <td class="total-servicio">${amount_service.toFixed(2)}</td>
                            <td><a class="btn btn-xs btn-danger delete-record" data-id="${cod_service}" ><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
                        </tr>`;
            $("#tbl_services_body").append(content);


            let insert_service = {
                "codigo": cod_service,
                "cantidad": 1
            };
            global_service.push(insert_service);

        } else {
            let cantidad = parseInt($(`#tbl_services tr#cod-${cod_service} td.cantidad-servicio input`).val());
            cantidad = cantidad + 1;
            $(`#tbl_services tr#cod-${cod_service} td.cantidad-servicio input`).val(cantidad);
            let total = amount_service.toFixed(2) * cantidad;
            $(`#tbl_services tr#cod-${cod_service} td.total-servicio`).html(`${total.toFixed(2)}`);

            let objIndex = global_service.findIndex((obj => obj.codigo == cod_service));
            global_service[objIndex].cantidad = cantidad;

        }

        manejo_select_retencion();
        let type_contribuyente = $('#select-contribuyente').val();

        calculo_total(type_contribuyente);


    }); /** End Function add service table */


    $(document).on('click', 'a.delete-record', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Estas seguro?',
            text: "Eliminar servicio!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminelo!'
        }).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).attr('data-id');
                $('#cod-' + id).remove();

                //regnerate index number on table
                $('#tbl_services_body tr').each(function (index) {
                    //alert(index);
                    $(this).find('span.sn').html(index + 1);
                });
                let type_contribuyente = $('#select-contribuyente').val();
                let objIndex = global_service.findIndex((obj => obj.codigo == id));
                global_service.splice(objIndex, 1);
                manejo_select_retencion();
                calculo_total(type_contribuyente);
                Swal.fire(
                    'Eliminado!',
                    'Su servicio ha sido eliminado.',
                    'Exito'
                )
            }
        })
    });


    $('.tipo_factura').change(function () {

        let type_contribuyente = $('#select-contribuyente').val();
        manejo_select_retencion();
        calculo_total(type_contribuyente);
        return true;

    });

    $("table#tbl_services").on('input', '.cantidad-servicio input', function () {

        let cod_service = $(this).data("id");
        let cantidad = parseInt($(`#tbl_services tr#cod-${cod_service} td.cantidad-servicio input`).val());
        let amount_service = $(`#tbl_services tr#cod-${cod_service} td.monto-servicio`).text();

        if (cantidad == 0) {

            var id = cod_service;
            $('#cod-' + id).remove();

            //regnerate index number on table
            $('#tbl_services_body tr').each(function (index) {
                //alert(index);
                $(this).find('span.sn').html(index + 1);
            });
            let objIndex = global_service.findIndex((obj => obj.codigo == id));
            global_service.splice(objIndex, 1);

        } else {

            amount_service = parseFloat(amount_service).toFixed(2);

            $(`#tbl_services tr#cod-${cod_service} td.cantidad-servicio input`).val(cantidad);
            let total = amount_service * cantidad;
            $(`#tbl_services tr#cod-${cod_service} td.total-servicio`).html(`${total.toFixed(2)}`);

            let objIndex = global_service.findIndex((obj => obj.codigo == cod_service));
            global_service[objIndex].cantidad = cantidad;
        }

        manejo_select_retencion();
        let type_contribuyente = $('#select-contribuyente').val();

        calculo_total(type_contribuyente);

    });


    

    $("#select-retencion").on('change', function () {

        let type_contribuyente = $('#select-contribuyente').val();


        calculo_total(type_contribuyente);

        return true;
    });


}); /** End OnReady */
