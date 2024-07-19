$(document).ready(function() {
    // Función para actualizar el campo de cantidad
    function actualizarCantidad(idproducto, nuevaCantidad) {
        $.ajax({
            url: '../Accion/actualizarCantidad.php',
            type: 'POST',
            data: {
                idproducto: idproducto,
                cantidad: nuevaCantidad
            },
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
                    } else {
                        var inputCantidad = $('input[data-idproducto="' + idproducto + '"]');
                        inputCantidad.css('background-color', 'red');
                    }
                } catch (e) {
                    console.error("Error parsing JSON response: ", e);
                    alert("Hubo un error al procesar la solicitud.");
                }
            }
        });
    }

    // Manejar el clic en el botón de sumar
    $('.sumarCantidad').click(function() {
        var idproducto = $(this).data('idproducto');
        var inputCantidad = $('.cantidad-input[data-idproducto="' + idproducto + '"]');
        var maxCantidad = parseInt(inputCantidad.attr('max')); // Obtener el valor máximo del atributo max
        var nuevaCantidad = parseInt(inputCantidad.val()) + 1;

        // Asegúrate de que la nueva cantidad no exceda el valor máximo
        if (nuevaCantidad <= maxCantidad) {
            inputCantidad.val(nuevaCantidad);
            actualizarCantidad(idproducto, nuevaCantidad);
        }
    });

    // Manejar el clic en el botón de restar
    $('.restarCantidad').click(function() {
        var idproducto = $(this).data('idproducto');
        var inputCantidad = $('.cantidad-input[data-idproducto="' + idproducto + '"]');
        var nuevaCantidad = parseInt(inputCantidad.val()) - 1;

        if (nuevaCantidad > 0) {
            inputCantidad.val(nuevaCantidad);
            actualizarCantidad(idproducto, nuevaCantidad);
        }
    });
});
