$(document).ready(function() {
  $(document).ready(function() {
    $('#edit-perfil').submit(function(event) {
      // Evitar el envío del formulario predeterminado
      event.preventDefault();
      
      // Resetear clases de validación
      $('.form-control').removeClass('is-invalid');
      $('.invalid-feedback').hide();
    var userValid=true;
    var emailValid=true;
    var passActualValid=true;
      // Validar nombre de usuario
    var username = $('#username').val();
    if (username === ''){
      $('#username').addClass('is-invalid');
      $('#username').siblings('.invalid-feedback').show();
      event.preventDefault();
      userValid=false;
    }

    // Validar email
    var email = $('#email').val();
    if (!isValidEmail(email)) {
      $('#email').addClass('is-invalid');
      $('#email').siblings('.invalid-feedback').show();
      event.preventDefault();
      emailValid=false;
    }

    // Validar contraseña actual (se puede implementar una lógica más robusta aquí)
    var currentPassword = $('#current-password').val();
    if (currentPassword.trim() === '' || (md5(currentPassword) != passActual)) {
      $('#current-password').addClass('is-invalid');
      $('#current-password').siblings('.invalid-feedback').show();
      event.preventDefault();
      passActualValid=false;
    }

    if(userValid && emailValid && passActualValid){
      // Obtener los datos del formulario
      var formData =$("#edit-perfil").serialize();
      /*var formData = {
        username: $('#username').val(),
        email: $('#email').val(),
        currentPassword: $('#current-password').val(),
        newPassword: $('#new-password').val()
      };*/
  
      // Enviar los datos del formulario a través de Ajax
      $.ajax({
        type: 'POST',
        url: '../Accion/modificarPerfil.php',
        data: formData,
        success: function(response) {
            window.location.href=proyectoroot+"Vista/Cliente/editarPerfil.php?correcto=1";
        },
        error: function(xhr, status, error) {
          // Manejar errores de Ajax
          console.error('Error en la solicitud Ajax:', error);
        }
      });
    }
    });
    
    // Función para validar email con una expresión regular simple
    function isValidEmail(email) {
      var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
    }
  });
  });