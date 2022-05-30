<?php ob_start();?>
<?php 
// session_start();
include('../BD_&_Security/tools.php');
include('../conexion.php');
GenerarAntiCSRF();
IniciarSesionSegura();

if(isset($_POST['mostrar']) && isset($_POST['doc'])){
    $doc = htmlentities(addslashes($_POST['doc']));
    $name = htmlentities(addslashes($_POST['name']));
    $lname = htmlentities(addslashes($_POST['lname']));
    $email = htmlentities(addslashes($_POST['email']));

    mostrarCuentaHabiente($conn,$doc,$name,$lname,$email);
}
function validateDataFilter($conn, $name, $lastname,$document, $email){
    if( (strlen($name) < 30 && is_string($name))&& 
        (strlen($lastname) < 30 && is_string($lastname)) &&
        (strlen($document) < 30 && is_string($document)) &&
        (strlen($email) < 30 && is_string($email))
    ){
        filtrarCuentaHabientes($conn, $name, $lastname,$document, $email);
    }
    else{
        echo '<h3>Los datos no cumplen con las caracterísiticas de seguridad</h3>';
    }
}

function filtrarCuentaHabientes($conn, $name, $lastname,$document, $email){
    $nombre = htmlentities(addslashes($name));
    $apellido = htmlentities(addslashes($lastname));
    $documento = htmlentities(addslashes($document));
    $email = htmlentities(addslashes($email));

    $consulta= "EXEC [dbo].[FILTRAR_CUENTAHABIENTES]
            @NOMBRES = N'$nombre',
            @APELLIDOS = N'$apellido',
            @DOCUMENTO = N'$documento',
            @CORREO = N'$email'";
    $resultado=sqlsrv_query($conn, $consulta);
    echo'
    <table class="table table-bordered">
    <thead>
    <tr align="center">
        <th width="100" align="center">Nombre</th>
        <th width="100" align="center">Apellido</th>
        <th width="100" align="center">Documento</th>
        <th width="300" align="center">Correo</th>
    </tr>
    </thead>
    <tbody>';
    while($fila = sqlsrv_fetch_array($resultado)){
        $nombre = $fila['NOMBRES'];
        $apellido = $fila['APELLIDOS'];
        $documento = $fila['DOCUMENTO'];
        $email = $fila['CORREO'];

        echo 
        '
        <tr align="center">
        <td>'. $documento .'</td>
        <td>'. $nombre .'</td>
        <td>'. $apellido .'</td>
        <td>'. $email .'</td>
        <td>
        <form method="post">
            <input type="submit" name="mostrar" value="Mostrar Datos">
            <input name="doc" type="hidden" value="'.$documento.'">
            <input name="name" type="hidden" value="'.$nombre.'">
            <input name="lname" type="hidden" value="'.$apellido.'">
            <input name="email" type="hidden" value="'.$email.'">
            <input type="hidden" name="anticsrf" value="'.$_SESSION['anticsrf'].'">
        </form></td>
        </tr>';
    }
    echo'</tbody>';
}

function mostrarCuentaHabiente($conn,$doc,$name,$lname,$email){
    $consulta= "EXEC [dbo].[CUENTAHABIENTE]
            @DOCUMENTO = N'$doc'";
    $resultado=sqlsrv_query($conn, $consulta);

    echo'
    <div>
    <div style="margin-left:20px" align = "left">
    <b>Documento:</b> '.$doc.'<br>
    <b>Nombre:</b> '.$name.'<br>
    <b>Apellido:</b> '.$lname.'<br>
    <b>Correo:</b> '.$email.'<br>
    <table class="table table-bordered">
    <thead>
    <tr align="center">
        <th width="100" align="center">Numero de Cuenta</th>
        <th width="100" align="center">Tipo de Cuenta</th>
        <th width="100" align="center">Ciudad</th>
        <th width="300" align="center">Sede</th>
    </tr>
    </thead>
    <tbody>';
    while($fila = sqlsrv_fetch_array($resultado)){ 
        $NUM_CUENTA = "******".substr($fila['NUM_CUENTA'],-4);
        $TIPO_CUENTA = $fila['TIPO_CUENTA'];
        $CIUDAD = $fila['CIUDAD'];
        $SEDE = $fila['SEDE'];

        echo 
        '
        <tr align="center">
        <td>'. $NUM_CUENTA .'</td>
        <td>'. $TIPO_CUENTA .'</td>
        <td>'. $CIUDAD .'</td>
        <td>'. $SEDE .'</td>
        </tr>';
    }
    echo'</tbody></div></div>';
}
?>
<?php ob_end_flush(); ?>