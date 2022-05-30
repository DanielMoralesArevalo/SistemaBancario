<?php ob_start();?>
<?php
// session_start();

include('../conexion.php');
include('../BD_&_Security/tools.php');
IniciarSesionSegura();
redireccionarLogin();
GenerarAntiCSRF();

/**
 * Validación de Login
 */
function validateLogin($conn){
  $rol= htmlentities(addslashes($_POST['txtRole']));
  $usuario= htmlentities(addslashes($_POST['txtUser']));
  $contraseña=md5(htmlentities(addslashes($_POST['txtPassword'])));
  //Se valida la sesion del usuario
  $consulta= "EXEC [dbo].[PA_LOGIN]
      @ROL = N'$rol',
      @DOCUMENT = N'$usuario',
      @PASSWORD = N'$contraseña'";

  $resultado=sqlsrv_query($conn, $consulta);
  $filas=sqlsrv_fetch_array($resultado);
  if($filas){
    session_destroy();
    session_start();
    $_SESSION["nombre"]=$filas[0];
    $_SESSION["apellido"]= $filas[1];
    $_SESSION["documento"]= $filas[2];
    $_SESSION["correo"]= $filas[3];
    $_SESSION["tip_user"]= $rol;

    redireccionarLogin();

  }else{
    ?>
    <h1 class="bad">CREDENCIALES INCORRECTAS</h1>
    <?php
  }
  sqlsrv_free_stmt($resultado);
  sqlsrv_close($conn);
}
/**
 * Redireccionar: Redirecciona al usuario a la página principal segun su rol
 */
 
function redireccionarLogin(){
  if(isset($_SESSION["tip_user"])){
    
    if($_SESSION["tip_user"] == 2){
      header("Location: ../FrontEnd/mainPageBanquero.front.php");
    }
    else if($_SESSION["tip_user"] == 1){
      header("Location: ../FrontEnd/mainPageCuentaHabiente.front.php");
    }
  }
}
?>
<?php ob_end_flush(); ?>