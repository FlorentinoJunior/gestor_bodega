<?php 
include('sesion.php');
$data = Sessions::getInstance();
if ($data->isOnline() == true) {
	switch ($_SESSION['cargo']) {
		case 'Bodega':
		header("Location:principalBodega.php");
		break;
		case 'Admin':
		header("Location:principalAdmin.php");
		break;
		default:
		break;
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<title>LOGIN</title>
	<link rel="stylesheet" href="estilo.css"/>
</head>
<body>

	<div class="contenedorLogin">
		<div class="login">
			<?php
			error_reporting(E_ALL  ^  E_NOTICE  ^  E_WARNING); 
 
			if ($_GET["error"]=="si") { 
				if ($_GET['msg'] == 1) {
					$msg = "Debes rellenar todos los campos!";
				}else{
					$msg = "VERIFICA TUS DATOS";
				}
				echo "<center><span style='color:#F00; font-size:2em;'>".$msg."</span></center>";
			}
			?>
			<h2 align="center">BIENVENIDOS AL GESTOR DE BODEGA</br></h2>
			<h3 align="center">Por favor ingresa tus datos</h3>
			<form name="login" method="post" action="validar.php" enctype="application/x-www-form-urlencoded">
				<div class="campos">
					<label for="usuario">Usuario:</label>
					<input type="text" name="usuario" />
				</div>

				<div class="campos">
					<label for="password">Contraseña:</label>
					<input type="password" name="pass" />
				</div>

				<div class="botones">
					<input type="submit" name="ingresar" value="Ingresar"/>
					<p class="mensaje" name="mensaje"></p>
				</div>
			</form>
		</div>

	</div>
</body>
</html>