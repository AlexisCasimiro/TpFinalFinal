$(document).ready(function() {
    let selectedIdCompra = null;
    let selectedIdProducto = null;
    let formToSubmit = null;

    $('.eliminarProducto').on('click', function() {
        formToSubmit = $(this).closest('form');
        selectedIdCompra = $(this).data('idcompra');
        selectedIdProducto = formToSubmit.find('select[name="idproducto"]').val();

        if (selectedIdProducto) {
            $('#confirmEliminarProductoModal').modal('show');
        } else {
            alert('Selecciona un producto para eliminar.');
        }
    });

    $('#confirmEliminarProductoBtn').on('click', function() {
        if (selectedIdCompra && selectedIdProducto) {
            $.ajax({
                url: '../Accion/depositoEliminarProducto.php',
                type: 'POST',
                data: { idcompra: selectedIdCompra, idproducto: selectedIdProducto },
                dataType: 'text',
                success: function(response) {
                    location.reload();
                }
            });
        }
        $('#confirmEliminarProductoModal').modal('hide');
    });
});
