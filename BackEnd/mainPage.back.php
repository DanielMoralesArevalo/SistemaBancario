<?php ob_start();?>
<?php 
session_start();
include('../BD_&_Security/tools.php');
include('../conexion.php');
MostrarErrores();
// IniciarSesionSegura();
GenerarAntiCSRF();

?>
<?php ob_end_flush(); ?>