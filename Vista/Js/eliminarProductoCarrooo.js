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
                        location.reload();
                    }
            
        });
    }
});