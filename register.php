<!DOCTYPE html>
<html lang="es">


<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="style.css">
  <title>Register</title>
</head>
<body>
 <div class="login-box">
    <div class="main">    
      <div class="signup">
        <form >
      <label  >Web Generator Register</label>
      <div class="user-box">
        <input type="text" name="email" placeholder="Email"required>
      </div>
      <div class="user-box">
        <input type="password" name="password" placeholder="Password"required>
      </div>
      <div class="user-box">
        <input type="password" name="password2" placeholder="Repeat Password"required>
         <input type="submit" value="Registrar" name="boton" >
        </form>
      </div>
      </div>
  </div>
    <?php 
    session_start();
    $conexion = mysqli_connect("localhost", "adm_webgenerator", "webgenerator2024", "webgenerator");
    $email = filter_input(INPUT_GET, 'email');
    $password = filter_input(INPUT_GET, 'password');
    $password2 = filter_input(INPUT_GET, 'password2');
    $boton = filter_input (INPUT_GET, 'boton'); 
    $fecha_actual = date('Y-m-d');
    if(isset($_SESSION['idUsuario']['idUsuario'])){
      header('Location: panel.php');
    }else{
      $consulta1 = "SELECT * FROM usuarios WHERE email = '$email'";
      $res1 = mysqli_query($conexion, $consulta1);
      $resultados = [];
      while($fila = mysqli_fetch_assoc($res1)){
        $resultados[] = $fila;
      }
      if (empty($resultados)) {
        if ($password==$password2) {
          $consulta = "INSERT INTO usuarios (email, password, fechaRegistro) VALUES ('$email', '$password', '$fecha_actual')";
          $res = mysqli_query($conexion, $consulta);
          echo "<center>Registro exitoso</center>";
          echo "<center><script>setTimeout(function(){window.location.href='login.php';}, 3000);</script></center><br>";
          echo "<center>Redirigiendote al login...</center>";
        }else{
          echo "Las contraseñas no son iguales";
        }
      }
    }

    ?>
</body>
</html>