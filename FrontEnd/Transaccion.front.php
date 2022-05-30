<?php ob_start();?>
<?php
    include('../BackEnd/mainPage.back.php');
    regularNavegacion(1);

    if(!isset($_POST['movement'])){
        if(!isset($_POST['transactionType']) or !isset($_POST['transactionClicked']) or ($_POST['transactionType'] < 1 or $_POST['transactionType'] > 3)){
            echo '<script>alert("Acción no permitida")</script>';
            header("Location: ../FrontEnd/mainPageCuentaHabiente.front.php");
        }
    }
    
    if(isset($_POST['CloseSession'])){
        closeSession();
    }

    $NUM_CUENTA = $_POST['NUM_CUENTA'];
    $transactionTypeDB = $_POST['transactionType'];

    switch ($_POST['transactionType']) {
        case 1:
            $transactionType = "Deposito";
            break;
        case 2:
            $transactionType = "Retiro";
            break;
        case 3:
            $transactionType = "Transferencia";
            break;
    }
?>


<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/cabecera.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-light bg-light" style="width:fit-content;">
    <a class="navbar-brand" href="../FrontEnd/mainPageCuentaHabiente.front.php" >
        <button type="button" class="btn btn-primary">Inicio</button>
    </a>
    <a class="navbar-brand">
        <form method="POST">
            <input type="hidden" name="anticsrf" value="<?php echo $_SESSION['anticsrf'];?>">    
            <button type="submit" class="btn btn-link" name="CloseSession">Cerrar Sesión</button>
        </form>
    </a>
    </nav>
    <div align="center">
    <h2><?php echo $transactionType?></h2>
    <form method="post">
        <p><b>Numero de Cuenta:</b> <?php echo $NUM_CUENTA?> <input type="hidden" name="num_cuenta_origen" value="<?php echo $NUM_CUENTA ?>"></p>
        <input type="hidden" name="transactionType" value="<?php echo $transactionTypeDB ?>"></p>
        <?php
            if($transactionTypeDB == 3){
        ?>
        <p>Transfiere a: <input type="number" placeholder="Número de Cuenta" name="num_cuenta_destino" minlength="8" required=true maxlength="12"></p>
        <?php
            }
        ?>
        <p>Valor <input type="number" placeholder="Valor" name="mount" required=true maxlength="50"></p>
        <p>Concepto<input type="text" placeholder="Concepto" name="concepto" minlength="5" required=true maxlength="50"></p>
        <p>Contraseña <input type="password" placeholder="Contraseña" name="psw" minlength="4" required=true maxlength="30"></p>
        
        <input type="hidden" name="anticsrf" value="<?php echo $_SESSION['anticsrf'];?>">

        <input type="submit" value="Realizar" name="movement">
    </form>
    </div>
    </body>
    </html>

    <?php
    if (isset($_POST['movement'])) {
        $num_cuenta_origen = htmlentities(addslashes($_POST['num_cuenta_origen']));
        $mount = htmlentities(addslashes($_POST['mount']));
        $concept = htmlentities(addslashes($_POST['concepto']));
        $password = md5(htmlentities(addslashes($_POST['psw'])));
        if(isset($_POST['num_cuenta_destino'])){
            $num_cuenta_destino = htmlentities(addslashes($_POST['num_cuenta_destino']));
        } else {
            $num_cuenta_destino = 0;
        }

        $insertar = "EXECUTE [dbo].[PA_TRANSACCIONES]
                @NUM_CUENTA = N'$num_cuenta_origen',
                @NUM_CUENTA_TRASFERENCIA = N'$num_cuenta_destino',
                @CLAVE = N'$password',
                @ID_TIPO_TRANSACCION = N'$transactionTypeDB',
                @VALOR = N'$mount',
                @DESCRIPCION = N'$concept'"; 

        $ejecutar = sqlsrv_query($conn, $insertar);

        if($ejecutar){
            echo '<script>alert("Transacción realizada correctamente")</script>';
            header("Location: ../FrontEnd/mainPageCuentaHabiente.front.php");
        }
        else
        {
            die( print_r( sqlsrv_errors(), true));
        }
    }
    ?>
    <?php ob_end_flush(); ?>