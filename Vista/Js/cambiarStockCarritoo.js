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
                        location.reload();
            }
        });
    }

    // Logica al hacer click en el boton de sumar
    $('.sumarCantidad').click(function() {
        var idproducto = $(this).data('idproducto');
        var inputCantidad = $('.cantidad-input[data-idproducto="' + idproducto + '"]');
        var maxCantidad = parseInt(inputCantidad.attr('max')); 
        var nuevaCantidad = parseInt(inputCantidad.val()) + 1;

        if (nuevaCantidad <= maxCantidad) {
            inputCantidad.val(nuevaCantidad);
            actualizarCantidad(idproducto, nuevaCantidad);
        }
    });

    // Logica al hacer click en el boton de restar
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
