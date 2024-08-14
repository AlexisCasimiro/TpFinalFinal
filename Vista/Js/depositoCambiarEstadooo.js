$(document).ready(function() {
        // Manejar la acción de aceptar compra
        $('.aceptarCompra').on('click', function() {
            const idcompra = $(this).data('idcompra');
            cambiarEstadoCompra(idcompra, 2); // Estado 2 para "Aceptar"
        });

        // Manejar la acción de enviar compra
        $('.enviarCompra').on('click', function() {
            const idcompra = $(this).data('idcompra');
            cambiarEstadoCompra(idcompra, 3); // Estado 3 para "Enviar"
        });

        // Función para cambiar el estado de la compra
        function cambiarEstadoCompra(idcompra, nuevoEstado) {
            $.ajax({
                url: '../Accion/depositoCambiarEstado.php',
                type: 'POST',
                data: {
                    idcompra: idcompra,
                    nuevoEstado: nuevoEstado
                },
                dataType: 'text',
                success: function(response) {
                    location.reload();
                }
            });
        }
});