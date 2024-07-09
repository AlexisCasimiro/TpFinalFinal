$(document).ready(function() {
    $('.btnActualizarRoles').click(function() {
        var formId = $(this).closest('form').attr('id');
        var formData = $('#' + formId).serialize();
        
        $.ajax({
            type: 'POST',
            url: $('#' + formId).attr('action'),
            data: formData,
            success: function(response) {
                // Puedes manejar la respuesta aquí si deseas mostrar un mensaje o actualizar la interfaz de usuario
                console.log(response);
                location.reload();
            },
            error: function(xhr, status, error) {
                // Manejar errores si es necesario
                console.error(xhr.responseText);
                alert('Hubo un error al actualizar los roles.');
            }
        });
    });
});
