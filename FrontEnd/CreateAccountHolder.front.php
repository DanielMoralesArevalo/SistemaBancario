<?php ob_start();?>
<?php 
include('../BackEnd/CreateAccountHolder.back.php');
regularNavegacion(2);
if(isset($_POST['CloseSession'])){
   closeSession();
}

?>
<?php ob_end_flush(); ?>



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
        <button type="button" class="btn btn-primary">Pagina Principal</button>
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
            <button type="submit" class="btn btn-link" name="CloseSession">Cerrar Sesión</button>
        </form>
    </a>
    </nav>
    <div align="center">
   <h2>Registrar un nuevo Usuario</h2>
   <form action="../BackEnd/CreateAccountHolder.back.php" method="post">
      <p>Nombre <input type="text" placeholder="Ingrese Nombre" name="name" placeholder="user" minlength="3" required=true maxlength="50"></p>
      <p>Apellido <input type="text" placeholder="Ingrese Apellido" name="lastname" placeholder="user" minlength="3" required=true maxlength="50"></p>
      <p>Documento <input type="text" placeholder="Ingrese Documento" name="document" placeholder="user" minlength="8" required=true maxlength="12"></p>
      <p>Correo <input type="email" placeholder="Ingrese Correo" name="email" placeholder="user" minlength="5" required=true maxlength="50"></p>
      <p>Clave Aplicativo<input type="password" placeholder="Ingrese Clave para el aplicativo" name="pswApp" placeholder="user" minlength="4" required=true maxlength="50"></p>
      <p>Saldo Inicial <input type="number" placeholder="Ingrese un saldo inicial" name="accountBalance" placeholder="user" required=true maxlength="50"></p>
      <p>Tipo de Cuenta <select name="idTipeAccount">
            <option value="1" selected>Ahorros</option>
            <option value="2">Corriente</option>
        </select></p>
      <p>Clave Cuenta <input type="password" placeholder="ingrese clave de cuenta" name="pswAccount" minlength="4" required=true maxlength="30"></p>
      <input type="hidden" name="anticsrf" value="<?php echo $_SESSION['anticsrf'];?>">
      
      <input type="submit" value="Ingresar">
   </form>
   </div>
</body>