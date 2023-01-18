/**
 * 
 * Document on ready
 */

$(document).ready(function() {
    /** 
     * Declarando reglas de validacion frontend form data npe and fact 
     * 
     */

    var validator1 = $("#formValidateRegister").validate({
        rules: {
            nitRequest: {
                required: true,
                minlength: 14,
                maxlength: 14
            }
        },
        messages: {
            nitRequest: "Por favor escriba su nit"
        }
    });
    validator1.resetForm();

    $('#nitRequest').rules('add', { // dynamically declare the rules
        required: true,
        messages: {
            required: "Por favor, digite su numero de NIT"
        }
    });



    $('#firstname').rules('add', { // dynamically declare the rules
        required: true,
        messages: {
            required: "Por favor, escriba sus nombres o el nombre de la empresa que desea registrar"
        }
    });

    $('#username').rules('add', { // dynamically declare the rules
        required: true,
        maxlength: 30,
        messages: {
            required: "Por favor, escriba un nombre de usuario",
            maxlength: jQuery.validator.format("Por favor, no ingrese mas de 30 caracteres."),
        }
    });

    $('#email').rules('add', { // dynamically declare the rules
        required: true,
        messages: {
            required: "Por favor, digite su correo electronico"
        }
    });

    $('#password').rules('add', { // dynamically declare the rules
        required: true,
        minlength: 9,
        messages: {
            required: "Por favor, digite una contraseña con mas de 8 caracteres",
            minlength: jQuery.validator.format("Por favor, ingrese al menos 9 caracteres."),
        }
    });

    $('#confirm-password').rules('add', { // dynamically declare the rules
        required: true,
        messages: {
            required: "Por favor, digite la confirmación de su contraseña"
        }
    });

    $('#tipo_registro').rules('add', { // dynamically declare the rules
        required: true,
        messages: {
            required: "Por favor, seleccione su tipo de registro"
        }
    });

    $('#pdf_nit').rules('add', { // dynamically declare the rules
        required: true,
        messages: {
            required: "Por favor, suba su NIT escaneado en formato PDF"
        }
    });



    /** 
     * Event change tipo registro 
     * 
     * */
    $("#tipo_registro").change(function() {
        let tipo_registro = $(this).val();

        if (tipo_registro == 1) {

            $("#input-nrc").hide();
            $("#input_apellido").show();

            //Validaciones
            $("#pdf_nrc").rules("remove");
            $("#input-dui").show();

            //Reglas
            $('#pdf_dui').rules('add', { // dynamically declare the rules
                required: true,
                messages: {
                    required: "Por favor, suba su DUI escaneado en formato PDF"
                }
            });

            $('#lastname').rules('add', { // dynamically declare the rules
                required: true,
                messages: {
                    required: "Por favor, escriba sus apellidos"
                }
            });

        } else {


            $("#input_apellido").hide();
            $("#input-dui").hide();
            $("#pdf_dui").rules("remove");
            $("#lastname").rules("remove");

            $("#input-nrc").show();
            $('#pdf_nrc').rules('add', { // dynamically declare the rules
                required: true,
                messages: {
                    required: "Por favor, suba su tarjeta de NRC escaneado en formato PDF"
                }
            });
        }
    });


});