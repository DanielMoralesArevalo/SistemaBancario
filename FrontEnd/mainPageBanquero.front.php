<?php ob_start();?>
<?php
include('./createPDF.php');
include('../BackEnd/mainPage.back.php');
MostrarErrores();

regularNavegacion(2);
if(isset($_POST['CloseSession'])){
    closeSession();
}
if(isset($_POST['GenerateReports'])){
    GenerateReports($conn);
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
        <form method="POST">  
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
    <div align="center">
        <H1>BIENVENIDOS AL BANCO UDEC</H1>
        <!-- <img src="https://www.valoraanalitik.com/wp-content/uploads/2018/03/BancodeBogota-696x461.jpg" -->
            <!-- width="600" height="400" class="d-inline-block align-top" alt=""> -->
        <?php
        echo "XDXDXDXD";
        seeData($conn); 
        ?>
        <?php ob_end_flush(); ?>
    </div>
</body>
</html>
