$(document).ready(function() {
    $('#edit-producto').submit(function(event) {
        // Evitar el envío del formulario predeterminado
        event.preventDefault();
      
        // Resetear clases de validación
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').hide();
        var nombreValid=true;
        var detalleValid=true;
        var cantStockValid=true;
        var precioValid=true;
        var imagenInputValid=true;
        
        var nombre = $('#pronombre').val();
        if (nombre === ''){
            $('#pronombre').addClass('is-invalid');
            $('#pronombre').siblings('.invalid-feedback').show();
            event.preventDefault();
            nombreValid=false;
        }

        var detalle = $('#prodetalle').val();
        if (detalle === ''){
            $('#prodetalle').addClass('is-invalid');
            $('#prodetalle').siblings('.invalid-feedback').show();
            event.preventDefault();
            detalleValid=false;
        }

        var cantStock = $('#procantstock').val();
        if (cantStock === ''){
            $('#procantstock').addClass('is-invalid');
            $('#procantstock').siblings('.invalid-feedback').show();
            event.preventDefault();
            cantStockValid=false;
        }

        var precio = $('#proprecio').val();
        if (precio === ''){
            $('#proprecio').addClass('is-invalid');
            $('#proprecio').siblings('.invalid-feedback').show();
            event.preventDefault();
            precioValid=false;
        }

        var imagenInput = $('#proimagen');
        var  imagen= imagenInput[0].files;
        // Verificar si se seleccionó al menos un archivo
        if (imagen.length > 0) {
            var fileType = imagen[0].type; // Obtener el tipo de archivo del primer archivo
    
            // Verificar si el archivo es una imagen PNG o JPG
            if (fileType !== 'image/png' && fileType !== 'image/jpeg') {
                $('#proimagen').addClass('is-invalid');
                $('#proimagen').siblings('.invalid-feedback').show();
                event.preventDefault();
                imagenInputValid=false;
                imagenInput.val(''); // Borrar la selección de archivo no válido
            }
        }

        if(nombreValid && detalleValid && cantStockValid && precioValid && imagenInputValid){
            var formulario=document.getElementById('edit-producto');
            // Obtener los datos del formulario
            var formData = new FormData(formulario); 
            // Enviar los datos del formulario utilizando AJAX
            $.ajax({
                type: 'POST',
                url: '../Accion/modificarProducto.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response)
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Manejar errores de la solicitud AJAX
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        }
            

    });  
  });