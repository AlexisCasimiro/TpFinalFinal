document.addEventListener('DOMContentLoaded', function() {
    // Manejar la acción de aceptar compra
    document.querySelectorAll('.aceptarCompra').forEach(function(button) {
        button.addEventListener('click', function() {
            const idcompra = this.getAttribute('data-idcompra');
            cambiarEstadoCompra(idcompra, 2); // Estado 2 para "Aceptar"
        });
    });

    // Manejar la acción de enviar compra
    document.querySelectorAll('.enviarCompra').forEach(function(button) {
        button.addEventListener('click', function() {
            const idcompra = this.getAttribute('data-idcompra');
            cambiarEstadoCompra(idcompra, 3); // Estado 3 para "Enviar"
        });
    });

    // Función para cambiar el estado de la compra
    function cambiarEstadoCompra(idcompra, nuevoEstado) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../Accion/depositoCambiarEstado.php';

        const inputIdCompra = document.createElement('input');
        inputIdCompra.type = 'hidden';
        inputIdCompra.name = 'idcompra';
        inputIdCompra.value = idcompra;
        form.appendChild(inputIdCompra);

        const inputNuevoEstado = document.createElement('input');
        inputNuevoEstado.type = 'hidden';
        inputNuevoEstado.name = 'nuevoEstado';
        inputNuevoEstado.value = nuevoEstado;
        form.appendChild(inputNuevoEstado);

        document.body.appendChild(form);
        form.submit();
        setTimeout(function() {
            window.location.reload();
        }, 1000); 
    }
});
