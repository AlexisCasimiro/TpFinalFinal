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
            url: '../Accion/depositoCancelarCompra.php',
            type: 'POST',
            data: { idcompra: idcompra },
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