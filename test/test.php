<html>
<form action="send_mail.php" method="post">
    <label for="to">Para:</label>
    <input type="email" id="to" name="to" required>
    <br>
    <label for="subject">Asunto:</label>
    <input type="text" id="subject" name="subject" required>
    <br>
    <label for="body">Cuerpo del mensaje:</label>
    <textarea id="body" name="body" required></textarea>
    <br>
    <input type="submit" value="Enviar">
</form>
</html>