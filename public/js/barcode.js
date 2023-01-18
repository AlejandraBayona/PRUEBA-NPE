$(document).ready(function() {
    console.log('on ready bar');
                                 
    JsBarcode("#barcode", "415741970000463939020000004282962021032880206330059298", {
            format: "CODE128C",
            background: null
        });


    // JsBarcode("#barcode_two", "Ê", {format: "CODE128"});
    
});