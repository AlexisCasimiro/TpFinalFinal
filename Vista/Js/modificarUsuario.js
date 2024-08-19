function confirmarBaja(userId) {
    $('#modalActionText').text('dar de baja');
    $('#confirmActionButton').off('click').on('click', function() {
        // Enviar solicitud AJAX para dar de baja
        $.ajax({
            type: 'POST',
            url: '../Accion/darBajaUsuario.php',
            data: {
                idusuario: userId
            },
            success: function(response) {
                console.log(response)
                location.reload();
            },
            error: function(xhr, status, error) {
                // Manejar errores de la solicitud AJAX
                console.error('Error en la solicitud AJAX:', error);
                // Puedes mostrar un mensaje de error al usuario aquí si lo deseas
            }
        });
        $('#confirmModal').modal('hide');
    });
    $('#confirmModal').modal('show');
}

// Función para abrir el modal de confirmación y habilitar al usuario
function habilitarUsuario(userId) {
    $('#modalActionText').text('habilitar');
    $('#confirmActionButton').off('click').on('click', function() {
        // Enviar solicitud AJAX para habilitar
        $.ajax({
            type: 'POST',
            url: '../Accion/habilitarUsuario.php',
            data: {
                idusuario: userId
            },
            success: function(response) {
                console.log(response)
                location.reload();
            },
            error: function(xhr, status, error) {
                // Manejar errores de la solicitud AJAX
                console.error('Error en la solicitud AJAX:', error);
            }
        });
        $('#confirmModal').modal('hide');
    });
    $('#confirmModal').modal('show');
}