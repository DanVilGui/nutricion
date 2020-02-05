<?php
session_start();
$validarUsuario = false;
$title = "Nutrilife";
if(isset($_POST['password'])){
    $password = $_POST['password'];
    $_SESSION['acceso_login'] = $password;

}
include 'validar_usuario.php'; 

?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title><?= $title ?></title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    
    <!-- Custom styles for this template -->
    <link href="public/css/login.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <script src="public/js/jquery.form.min.js"></script>

   
    
  </head>

  <body class="text-center">
 <form class="form-signin" method="POST">
      <h1 class="h3 mb-3 font-weight-normal">Acceso de Usuarios</h1>
      <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Acceder</button>
</form>


</body>

</html>