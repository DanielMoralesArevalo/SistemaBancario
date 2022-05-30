<?php ob_start();?>
<?php 
include('../BD_&_Security/tools.php');
include('../conexion.php');
MostrarErrores();
IniciarSesionSegura();
GenerarAntiCSRF();

function seeData($conn){
  $documento = $_SESSION["documento"];
  echo "Documentoo";
  echo var_dump($documento);
  echo "Conexion";
  echo var_dump($conn);

  $consulta= "EXEC [dbo].[PA_BANCO]
      @DOCUMENTO = N'$documento'";

  $resultado=sqlsrv_query($conn, $consulta);
  $filas=sqlsrv_fetch_array($resultado);

  if($filas){
    echo "<b>BANCO:  </b>".$filas[0]."<br>";
    echo "<b>NIT:  </b>".$filas[1]."<br>";
    echo "<b>CIUDAD:  </b>".$filas[2]."<br>";
    echo "<b>SEDE:  </b>".$filas[3]."<br>";
    echo "<b>TELEFONO:  </b>".$filas[4]."<br>";
    echo "<b>GERENTE:  </b>".$filas[5]."<br>";
    $_SESSION["id_sucursal"] = $filas[6];
  }
}

?>
<?php ob_end_flush(); ?>