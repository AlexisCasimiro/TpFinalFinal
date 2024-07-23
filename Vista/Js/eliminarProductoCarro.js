$(document).ready(function() {
    $('.eliminarProducto').click(function() {
        var idproducto = $(this).data('idproducto');
        console.log(idproducto)
        eliminarProducto(idproducto);
    });

    function eliminarProducto(idproducto) {
        $.ajax({
            url: '../Accion/eliminarProductoCarrito.php', 
            type: 'POST',
            data: { idproducto: idproducto },
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
    }
});