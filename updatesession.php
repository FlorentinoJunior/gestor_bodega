<?php 

include('sesion.php');
$data = Sessions::getInstance();
if ($data->isOnline == false) {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<title>Refresh Sessions...</title>
	<link rel="stylesheet" href="estilo.css"/>
</head>
<body>
	<div class="contenedorLogin">
		<div class="login">
			<h2 align="center">Refrescando tu sesión...</br></h2>
			<form name="login" method="post" action="validar.php" enctype="application/x-www-form-urlencoded">

				<div class="campos">
					<img src="https://www.createwebsite.net/wp-content/uploads/2015/09/GD.gif" width="50%">
				</div>
			</form>
		</div>
	</div>
</body>
</html>

<?php 
if ($_GET) {
	if (isset($_GET['name']) && isset($_GET['apellido']) && isset($_GET['cargo'])) {
			$data->name = $_GET['nombre'];
			$data->apellido = $_GET['apellido'];
			$data->fullname = $_GET['name']." ".$_GET['apellido'];
			$data->cargo = $_GET['cargo'];
			header("Refresh: 3; url=mod_personal.php");
	}
}else{
	header("Location: mod_personal.php");
}
 ?>