$(document).ready(function(){
    // Mostrar el modal de registro cuando se hace clic en el enlace de registro
    $("#registroLink").click(function(){
        $("#registroModal").modal("show");
    });

    // Validación del formulario de registro
    $("#registroForm").submit(function(event) {
        event.preventDefault(); // Evitar el envío convencional del formulario

        var password = $("#password").val();
        var confirm_password = $("#confirm_password").val();

        // Verificar si las contraseñas coinciden
        if (password != confirm_password) {
            // Mostrar un mensaje de error
            $("#error-password").text("Las contraseñas no coinciden");
        } else {
            // Si las contraseñas coinciden, enviar el formulario
            this.submit();
        }
    });
});