$(document).ready(function() {
    let idcompraACancelar = null;

    $('.cancelarCompra').on('click', function() {
        idcompraACancelar = $(this).data('idcompra');
        $('#confirmCancelModal').modal('show');
    });

    $('#confirmCancelBtn').on('click', function() {
        if (idcompraACancelar) {
            // Crear y enviar un formulario dinámicamente
            cancelarCompra(idcompraACancelar);
            idcompraACancelar = null;
            $('#confirmCancelModal').modal('hide');
        }
    });

    function cancelarCompra(idcompra) {
        // Crear un formulario HTML
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../Accion/cancelarCompra.php';

        // Crear un campo de entrada oculto para el idcompra
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'idcompra';
        input.value = idcompra;

        // Añadir el campo de entrada al formulario
        form.appendChild(input);

        // Añadir el formulario al cuerpo del documento
        document.body.appendChild(form);

        // Enviar el formulario
        form.submit();
    }
});
