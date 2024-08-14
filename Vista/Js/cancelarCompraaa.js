$(document).ready(function() {
    let idcompraACancelar = null;

    $('.cancelarCompra').on('click', function() {
        idcompraACancelar = $(this).data('idcompra');
        $('#confirmCancelModal').modal('show');
    });

    $('#confirmCancelBtn').on('click', function() {
        if (idcompraACancelar) {
            cancelarCompra(idcompraACancelar);
            idcompraACancelar = null;
            $('#confirmCancelModal').modal('hide');
        }
    });

    function cancelarCompra(idcompra) {
        $.ajax({
            url: '../Accion/cancelarCompra.php',
            type: 'POST',
            data: { idcompra: idcompra },
            dataType: 'text',
            success: function(response) {
                        location.reload();
            }
        });
    }
});