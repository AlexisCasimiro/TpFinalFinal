document.addEventListener('DOMContentLoaded', function() {
    let idcompraACancelar = null;

    // Manejar la acción de cancelar compra
    document.querySelectorAll('.cancelarCompra').forEach(function(button) {
        button.addEventListener('click', function() {
            idcompraACancelar = this.getAttribute('data-idcompra');
            $('#confirmCancelModal').modal('show'); // Mostrar el modal de confirmación
        });
    });

    // Confirmar cancelación de la compra
    document.getElementById('confirmCancelBtn').addEventListener('click', function() {
        if (idcompraACancelar) {
            cancelarCompra(idcompraACancelar);
            idcompraACancelar = null;
            $('#confirmCancelModal').modal('hide'); // Ocultar el modal
        }
    });

    // Función para cancelar la compra
    function cancelarCompra(idcompra) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../Accion/depositoCancelarCompra.php';

        const inputIdCompra = document.createElement('input');
        inputIdCompra.type = 'hidden';
        inputIdCompra.name = 'idcompra';
        inputIdCompra.value = idcompra;
        form.appendChild(inputIdCompra);

        document.body.appendChild(form);
        form.submit();
        
        // Esperar un momento para que el formulario se envíe antes de recargar la página
        setTimeout(function() {
            window.location.reload();
        }, 1000); 
    }
});
