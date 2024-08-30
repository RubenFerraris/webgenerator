<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Webgenerator</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="./style.css">
</head>
<body>
	<div class="login-box">
		<div class="main">  	
			<div class="signup">
        <form >
			<label  >Web Generator Login</label>
			<input type="text" name="email" placeholder="Email" required=""maxlength="50">
          <input type="password" name="Password" placeholder="Password" required=""maxlength="50">
          <input type="submit" value="Iniciar Seccion" name="boton" >
				</form>
				<div class="registro">
		<center><a href="register.php">ir al registro</a></center>
		</div>
		           </div>
			
			</div>
	</div>
		<?php 
		$conexion = mysqli_connect("localhost", "adm_webgenerator", "webgenerator2024", "webgenerator");

		$email = filter_input(INPUT_GET, 'email');
		$password = filter_input(INPUT_GET, 'Password');
		$boton = filter_input (INPUT_GET, 'boton');	
		if(isset($boton)){
		    $consulta = "SELECT * FROM usuarios WHERE email = '$email' AND password = '$password'";
		    $res = mysqli_query($conexion, $consulta);
		    $resultados = [];
		    while($fila = mysqli_fetch_assoc($res)){
		        $resultados[] = $fila;
		    }
		    if(empty($resultados)){
		        echo "<center><h3>El email o la contraseña son incorrectos</h3></center>";
		    }else{
		    	session_start();
	            $_SESSION ['idUsuario']=$resultados[0];
		        header('Location: panel.php');
		    }
	    }
		?>
		
</body>
</html>			