<?php ob_start();?>
 <?php
    session_start();
    include('../BD_&_Security/tools.php');
    include('../conexion.php');
    include('./createPDF.php');
    regularNavegacion(2);
    GenerarAntiCSRF();

    if(isset($_POST['GenerateReports'])){
        GenerateReports($conn);
    }

    if(isset($_POST['CloseSession'])){
        closeSession();
    }

    $documento = $_SESSION["documento"];

    $consulta= "EXEC [dbo].[PA_BANCO]
        @DOCUMENTO = N'$documento'";
    $resultado=sqlsrv_query($conn, $consulta);
    $banco;
    $nit;
    $ciudad;
    $sede; 
    $telefono; 
    $gerente;
    while($fila = sqlsrv_fetch_array($resultado)){
        $banco = $fila['BANCO'];
        $nit = $fila['NIT'];
        $ciudad = $fila['CIUDAD'];
        $sede = $fila['SEDE']; 
        $telefono = $fila['TELEFONO']; 
        $gerente = $fila['GERENTE'];
        $_SESSION["id_sucursal"] = $fila['SUCURSAL'];
    }
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-light bg-light" style="width:fit-content;">
    <nav class="navbar navbar-light bg-light" style="width:fit-content;">
    <a class="navbar-brand" href="../FrontEnd/mainPageBanquero.front.php">
        <button type="button" class="btn btn-primary">Página Principal</button>
    </a>
    <a class="navbar-brand" href="../FrontEnd/CreateAccountHolder.front.php" >
        <button type="button" class="btn btn-primary">Crear CuentaHabiente</button>
    </a>
    <a class="navbar-brand" href="../FrontEnd/FiltrarCuentaHabientes.front.php">
        <button type="button" class="btn btn-primary">CuentaHabientes</button>
    </a>
    <a class="navbar-brand">
        <form  method="POST">   
            <input type="hidden" name="anticsrf" value="<?php echo $_SESSION['anticsrf'];?>">    
            <button type="submit" class="btn btn-primary" name="GenerateReports">Generar Reportes</button>
        </form>
    </a>
    <a class="navbar-brand">
        <form method="POST">
            <input type="hidden" name="anticsrf" value="<?php echo $_SESSION['anticsrf'];?>">    
            <button type="submit" class="btn btn-link" name="CloseSession">Cerrar Sesión</button>
        </form>
    </a>
    </nav>
    <div align="center" style="width:100%">
        <div style="margin-left:20px" align = "left">
        <H1>BIENVENIDO:</H1>
            <b>Banco:</b><?php echo $banco ?><br>
            <b>Nit:</b><?php echo $nit ?><br>
            <b>Ciudad:</b><?php echo $ciudad ?><br>
            <b>Sede:</b><?php echo $sede ?><br>
            <b>Telefono:</b><?php echo $telefono ?><br>
            <b>Gerente:</b><?php echo $gerente ?><?php ob_end_flush(); ?><br>
        </div>
    </div>
</body>

</html>

