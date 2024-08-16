<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../vendor/autoload.php';

//Create an instance; passing true enables exceptions

class Mailer{


    public function mandarMail($objCompra){

        try {
            $mail = new PHPMailer(true);
            // Configuración del servidor
            $mail->SMTPDebug = 0;                                       // Habilitar salida de depuración detallada
            $mail->isSMTP();                                            // Configurar el mailer para usar SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Servidor SMTP
            $mail->SMTPAuth   = true;                                   // Habilitar autenticación SMTP
            $mail->Username   = 'exequielcasimiro@gmail.com';                   // Tu usuario de SMTP
            $mail->Password   = 'vljtfrdhcqnveytw';                        // Tu contraseña SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Habilitar TLS
            $mail->Port       = 587;  // Puerto TCP al que se conecta

            // Instanciar las clases necesarias
            $objAbmCompraEstado = new AbmCompraEstado;
            $objAbmCompraItem = new AbmCompraItem;
            
            // Obtener todos los estados de la compra
            $estados = $objAbmCompraEstado->buscar(["idcompra" => $objCompra->getId()]);
            
            // Seleccionar el último estado
            $ultimoEstado = end($estados);
            if ($ultimoEstado != null) {
                $compraestadotipo = $ultimoEstado->getObjCompraEstadoTipo()->getId();
                // Obtener datos de la compra
                $listaCompraItem = $objAbmCompraItem->buscar(["idcompra" => $objCompra->getId()]);
                $totalMonto = 0;
                
                foreach ($listaCompraItem as $item) {
                    $totalMonto += $item->getObjProducto()->getPrecio() * $item->getCantidad();
                }
                
                // Configurar asunto y mensaje según el tipo de estado de la compra
                switch ($compraestadotipo) {
                    case 1:
                        $mensaje = "¡Su compra fue iniciada con exito!";
                        break;
                    case 2:
                        $mensaje = "¡Su compra fue aceptada, estamos preparando su pedido!";
                        break;
                    case 3:
                        $mensaje = "¡Su compra fue enviada, gracias por elegirnos!";
                        break;
                    case 4:
                        $mensaje = "Su compra ha sido cancelada";
                        break;
                }
        
                // Generar contenido del correo electrónico
                $emailContent = '<!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset="UTF-8">
                        <title>' . $mensaje . '</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                margin: 0;
                                padding: 0;
                                background-color: #ffffff;
                            }
                            .container {
                                max-width: 600px;
                                margin: 20px auto;
                                padding: 20px;
                                background-color: #ffffff;
                                border: 1px solid #ddd;
                            }
                            h1, p {
                                margin: 0 0 10px;
                            }
                            .table {
                                width: 100%;
                                border-collapse: collapse;
                                margin-top: 20px;
                            }
                            .table th, .table td {
                                border: 1px solid #ddd;
                                padding: 8px;
                                text-align: left;
                            }
                            .table th {
                                background-color: #f9f9f9;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <h1>' . $mensaje . '</h1>
                            <h3>Detalles de la compra #' . $objCompra->getId() . '</h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                                <tbody>';
        
                foreach ($listaCompraItem as $compraitem) {
                    $nombreProducto = $compraitem->getObjProducto()->getNombre();
                    $cantidad = $compraitem->getCantidad();
                    $precio = $compraitem->getObjProducto()->getPrecio();
                    $precioTotal = $precio * $cantidad;
                    $emailContent .= '<tr>
                        <td>' . $nombreProducto . '</td>
                        <td>' . $cantidad . '</td>
                        <td>$' . number_format($precioTotal, 2) . '</td>
                    </tr>';
                }
        
                $emailContent .= '</tbody>
                            </table>
                            <p><strong>Monto total:</strong> $' . number_format($totalMonto, 2) . '</p>
                        </div>
                    </body>
                    </html>';
            }
            // Destinatarios
            $mail->setFrom('exequielcasimiro@gmail.com', 'Mailer');
            // Configurar la dirección del destinatario
            $mail->addAddress($objCompra->getUsuario()->getMail());
            echo "<br>";

            echo $mensaje;
            echo "<br>";
            echo $emailContent;
            // Contenido
            $mail->isHTML(true);                                        // Configurar el formato del email como HTML
            $mail->Subject = $mensaje;
            $mail->msgHTML($emailContent);
    
            $mail->send();
            echo 'El mensaje ha sido enviado';
        } catch (Exception $e) {
            echo "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
        }
    }// fin function 



}// fin class