$(document).ready(function() {
    $('#roleForm').on('submit', function(event) {
      event.preventDefault(); // Evita que el formulario se envíe de forma predeterminada

      $.ajax({
        url: '../Accion/cambiarRol.php',
        method: 'POST',
        data: $(this).serialize(), // Serializa los datos del formulario para enviarlos
        dataType: 'text',
        success: function(response) {
                location.reload();
        }
      });
    });
  });