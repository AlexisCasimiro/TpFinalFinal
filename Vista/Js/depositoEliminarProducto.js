$(document).ready(function() {
    $('.eliminarProducto').on('click', function() {
        var form = $(this).closest('form');
        var idcompra = $(this).data('idcompra');
        var idproducto = form.find('select[name="idproducto"]').val();
        $.ajax({
            url: '../Accion/depositoEliminarProducto.php',
            type: 'POST',
            data: { idcompra: idcompra, idproducto: idproducto },
            dataType: 'text',
            success: function(response) {
                var jsonResponse;
                try {
                    var jsonStartIndex = response.indexOf('{');
                    var jsonEndIndex = response.lastIndexOf('}') + 1;
                    var jsonString = response.substring(jsonStartIndex, jsonEndIndex);
                    jsonResponse = JSON.parse(jsonString);
        
                    if (jsonResponse.success) {
                        location.reload();
                    }
                } catch (e) {
                    console.error("Error parsing JSON response: ", e);
                }
            }
        });
    });
});
