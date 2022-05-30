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
         <section id="principal">
            <form method="post" >
               <div class="campos">
                  <label>Documento:</label>
                  <input type="text" name="documento" required> <br><br>
               </div>
               <div class="campos">
                  <label>Clave Antigua:</label>
                  <input type="text" name="ClaveAntigua"><br><br>
               </div>
               <div class="campos">
                  <label>Clave Nueva:</label>
                  <input type="text" name="ClaveNueva"><br><br>
               </div>
               <input type="hidden" name="anticsrf" value="<?php echo $_SESSION['anticsrf'];?>">
               <input id="submit" type="submit" name="cambiarClave" value="Cambiar Clave">
            </form>
         </section>
      </div>
   </body>
</html>
<?php ob_start();?>
<?php 
include('../conexion.php');

if (isset($_POST['cambiarClave']) &&
   isset($_POST['ClaveNueva']) && 
   isset($_POST['ClaveAntigua']) && 
   isset($_POST['documento'])) {

   CambiarClave($conn,md5($_POST['ClaveAntigua']),md5($_POST['ClaveNueva']),$_POST['documento']);
}

function CambiarClave($conn,$claveGenerada, $claveNueva,$documento){
   $changeQuery = "EXEC [dbo].[PA_CHANGE_PASSWORD]
   @CLAVE_GENERADA = N'$claveGenerada',
   @CLAVE_NUEVA = N'$claveNueva',
   @DOCUMENTO = N'$documento'";
   $changeResult=sqlsrv_query($conn, $changeQuery);
   while($fila = sqlsrv_fetch_array($changeResult)){
      if ($fila["ESTADO"] == "TRUE") {
         echo'<script type="text/javascript">
               alert("CONTRASEÑA ACTUALIZADA!!!!!!!");
               window.location="http://localhost/Linea_Prof_3/Banco_Project/FrontEnd/index.front.php"
               </script>';
      }
      else {
         echo "DATOS ERRÓNEOS";
      }
   }
}
?>
<?php ob_end_flush(); ?>

