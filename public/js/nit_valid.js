/**
 * 
 * Document on ready
 */
/**
 * 
 * Inicializando validaciones plugin validate
 */

 var validator1 = $("#formValidateNit").validate({
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


var validatorNpe = $("#formPago").validate({
    rules: {
        npe: {
            required: true,
            minlength: 34,
            maxlength: 34
        }
    },
    messages: {
        npe: "Por favor escriba el numero NPE del mandamiento de pago"
    }
});
validatorNpe.resetForm();


 $(document).ready(function () {

    IMask(document.getElementById('nitRequest'), { mask: '00000000000000' });

    IMask(document.getElementById('npe'), { mask: '0000000000000000000000000000000000' });
}); /** End OnReady */