<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Panel Web</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="panel.css">
</head>
<body>
	<div class="panel-box">
		
		<h2>Panel de paginas web</h2>
		<form>
			<div class="botonañadir">
				<div class="user-box">
					<input type="text" name="nombre" required>
				</div>
				<?php 
				session_start();
				$conexion = mysqli_connect("localhost", "adm_webgenerator", "webgenerator2024", "webgenerator");
				$nombre = filter_input(INPUT_GET, 'nombre');
				$boton = filter_input (INPUT_GET, 'boton'); 
				$fecha_actual = date('Y-m-d');
				if (isset($boton)) {
					$dominio = $_SESSION['idUsuario']['idUsuario'] . $nombre;
					$consulta = "SELECT * FROM webs WHERE dominio = '$dominio'";
					$res = mysqli_query($conexion, $consulta);
					$resultados = [];
					while($fila = mysqli_fetch_assoc($res)){
						$resultados[] = $fila;
					}
					if (empty($resultados)) {
						$consulta = "INSERT INTO webs (idUsuario, dominio, fechaCreacion) VALUES ('{$_SESSION['idUsuario']['idUsuario']}', '$dominio', '$fecha_actual')";
						$res = mysqli_query($conexion, $consulta);
						shell_exec("./wix.sh $dominio");
					}else{
						echo "El dominio ingreado ya esta en uso<br>";
					}
				}
				?>
				<a>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<input type="submit" name="boton">
				</a>
			</div>
		</form>
		<div class="dominios">
			<?php
			$conexion = mysqli_connect("mattprofe.com.ar", "6915", "buey.sauce.silla", "6915");
			$Descargar = filter_input (INPUT_GET, 'Descargar');
			if($_SESSION['idUsuario']['idUsuario']==1){
				$consulta = "SELECT dominio FROM webs";
				$res = mysqli_query($conexion, $consulta);
				
			}else{
				$consulta = "SELECT dominio FROM webs WHERE idUsuario = '{$_SESSION['idUsuario']['idUsuario']}'";
				$res = mysqli_query($conexion, $consulta);
				
			}
			$resultados = [];
			while($fila = mysqli_fetch_assoc($res)){
				$resultados[] = $fila;
			}
			foreach ($resultados as $value) {
				echo '<div class="dominio">
				<div class="nombre-dominio">'.$value['dominio'].'</div>
				<form>
				<a href="'.$value['dominio'].'">
				<div class="verDominio">
				<span></span>
				<span></span>
				<span></span>
				<span></span>
				<button type="button">Ir a mi pagina</button>
				</div>
				</a>
			</form>
				<div class="descargar-dominio">
				<form>
				<a>
				<span></span>
				<span></span>
				<span></span>
				<span></span>
				<input type="submit" name="descarga" value="Descargar">
				<input type="hidden" name="dominio1" value="'.$value['dominio'].'">
				</a>
				</form>
				</div>
				<div class="eliminar-dominio">
				<form>
				<a>
				<span></span>
				<span></span>
				<span></span>
				<span></span>
				<input type="submit" name="eliminar" value="Eliminar">
				<input type="hidden" name="dominio" value="'.$value['dominio'].'">
				</a>
				</form>
				</div>
				</div>';

			}
			if(isset($_GET['descarga'])){
				$descarga=$_GET['dominio1'];
				shell_exec("zip -r '$descarga'.zip '$descarga'");
				$filename = "$descarga.zip";
				if (file_exists($filename)) {
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="'.basename($filename).'"');
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Length: ' . filesize($filename));
					ob_clean();
					flush();
					readfile($filename);
					exit;
				}
			}

			if (isset($_GET['eliminar'])) {
				$dominioAEliminar = $_GET['dominio'];
				$consulta3 = "DELETE FROM webs WHERE dominio = '$dominioAEliminar'";
				$res = mysqli_query($conexion, $consulta3);
				shell_exec("rm -r '$dominioAEliminar'");
				shell_exec("rm -r '$dominioAEliminar'.zip");
				header('Location: panel.php');
			}
			?>
		</div>
	</div>
	<div class="cerrar-sesion">
		<?php
		echo '<button><a href="logout.php">cerrar sesion de '.$_SESSION['idUsuario']['idUsuario'].' </a></button>';
		?>
	</div>
</body>
</html>			