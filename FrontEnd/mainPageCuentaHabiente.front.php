<?php ob_start();?>
 <?php
    include('../BackEnd/mainPage.back.php');
    regularNavegacion(1);


    if(isset($_POST['CloseSession'])){
        closeSession();
    }

    $name = $_SESSION["nombre"];
    $lastname = $_SESSION["apellido"] ;
    $document = $_SESSION["documento"];
    $email = $_SESSION["correo"];

    $consulta = "EXEC [dbo].[CUENTAHABIENTE]
            @DOCUMENTO = N'$document'";
    $resultado=sqlsrv_query($conn, $consulta);
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
        <H1>BIENVENIDO:</H1>
        <div style="margin-left:20px" align = "left">
        <b>Documento:</b><?php echo $name ?><br>
        <b>Nombre:</b><?php echo $lastname ?><br>
        <b>Apellido:</b><?php echo $document ?><br>
        <b>Correo:</b><?php echo $email ?><br>

        <table class="table table-bordered">
        <thead>
        <tr align="center">
            <th width="100" align="center">Numero de Cuenta</th>
            <th width="100" align="center">Tipo de Cuenta</th>
            <th width="100" align="center">Ciudad</th>
            <th width="300" align="center">Sede</th>
            <th width="300" align="center">Saldo</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while($fila = sqlsrv_fetch_array($resultado)){ 
            $NUM_CUENTA = $fila['NUM_CUENTA'];
            $TIPO_CUENTA = $fila['TIPO_CUENTA'];
            $CIUDAD = $fila['CIUDAD'];
            $SEDE = $fila['SEDE'];
            $SALDO = $fila['SALDO'];

            ?>
            <tr align="center">
            <td><?php echo $NUM_CUENTA ?></td>
            <td><?php echo $TIPO_CUENTA ?></td>
            <td><?php echo $CIUDAD ?></td>
            <td><?php echo $SEDE ?></td>
            <td><?php echo $SALDO ?></td>
            <td>
                <form action="./Transaccion.front.php" method="post">
                    <select name="transactionType" required>
                        <option value="1">Depósito</option>
                        <option value="2">Retiro</option>
                        <option value="3">Transferencia</option>
                    </select>
                    <input name="NUM_CUENTA" type="hidden" value="<?php echo $NUM_CUENTA ?>">

                    <input type="hidden" name="anticsrf" value="<?php echo $_SESSION['anticsrf'];?>">

                    <input type="submit" name="transactionClicked" value="Realizar Transacción">
                </form>
            </td>
            </tr>
        <?php
        }
        ?>
        <?php ob_end_flush(); ?>
        
        </tbody>
            </div>
        </div>
    </body>
    </html>