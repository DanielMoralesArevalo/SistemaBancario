<?php ob_start();?>
<?php
include('../conexion.php');
include('../FrontEnd/CorreoRestClave.php');
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Restablecimiento Contraseña</title>
      <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>login</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
   <body>
      <div class="wrap">
         <header>
            <h3><b>RESTABLECIMIENTO DE CONTRASEÑA</b></h3>
         </header>
            <form method="post">
               <div class="campos">
                  <label>Documento:</label>
                  <input type="number" name="docRestClave"><br><br>
               </div>
               <input type="hidden" name="anticsrf" value="<?php echo $_SESSION['anticsrf'];?>">
               <input id="submit" type="submit" name="enviar" value="Enviar Correo">
            </form>
      </div>
   </body>
</html>


<?php
if(isset($_POST['enviar']) && isset($_POST["docRestClave"])){
   $doc = $_POST["docRestClave"];
   validarRestablecimiento($doc,$conn);
} 

function validarRestablecimiento($documento,$conn){
   
   $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
   $CLAVE_RANDOM = substr(str_shuffle($permitted_chars), 0, 10);
   $CLAVE_SEND = MD5($CLAVE_RANDOM);
   
   $validarQuery = "EXEC [dbo].[PA_VALIDAR_RESTABLECIMIENTO]
   @DOCUMENTO = N'$documento',
   @CLAVE = N'$CLAVE_SEND'";
   $validarResult=sqlsrv_query($conn, $validarQuery);   

   while($fila = sqlsrv_fetch_array($validarResult)){
      
      $email = $fila['CORREO'];

      CorreoRestablecimiento($email,$CLAVE_RANDOM);
   }
}
?>

<?php ob_end_flush(); ?>
