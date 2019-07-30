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
	<title>Modificar personal</title>
	<link type="text/css" href="estilo.css" rel="stylesheet">

</head>

<body>

	<div class="contenedor">
		<div class= "encabezado">
			<div class="izq">

				<p>Bienvenido/a:<br><?php echo $_SESSION['fullname']; ?></p>

			</div>

			<div class="centro">
				<a href=principalAdmin.php><center><img src='imagenes/home.png'><br>Home<center></a> 
			</div>

			<div class="derecha">
				<a href="salir.php?sal=si"><img src="imagenes/cerrar.png"><br>Salir</a>
			</div>
		</div>
		<br><h1 align='center'>REGISTROS EXISTENTES</h1><br>
		<?php

		$dbPDOClass = new PDOConnect();
		$stmt = $dbPDOClass->dbPDO->prepare("SELECT * FROM personal");
		$stmt->execute();
		$dbresult = $stmt->fetchAll();

		echo "<table  width='80%' align='center'><tr>";	         	  
		echo "<th width='20%'>RUT</th>";
		echo "<th width='20%'>NOMBRE</th>";
		echo "<th width='20%'>APELLIDO</th>";
		echo "<th width='20%'>CARGO</th>";
		echo  "</tr>"; 

		foreach ($dbresult as $result){	

			echo "<tr>";	         	  
			echo '<td width=20%>'.$result['rut'].'</td>';
			echo '<td width=20%>'.$result['nombre'].'</td>';
			echo '<td width=20%>'. $result['apellido'].'</td>';
			echo '<td width=20%>'.$result['cargo'].'</td>';
			echo "</tr>";
		}
		echo "</table></br>";
		?>


		<div class="encabezado">
			<h1>Modificar personal</h1>
		</div>

		<div class="formulario">
			<form ="registro" method="post" action="" enctype="application/x-www-form-urlencoded">

				<div class="campo">
					<label name="Seleccionar">Ingresa el Rut del registro a modificar:</label>
					<input name='seleccionar' type="text" required>
				</div>

				<div class="campo">
					<div class="en-linea izquierdo">
						<label for="nombre">Nombre:</label>
						<input type="text" name="nombre" required/>
					</div>

					<div class="en-linea">
						<label for="apellido">Apellido:</label>
						<input type="text" name="apellido" required/>
					</div>
				</div>

				<div class="campo">
					<label for="cargo">cargo:</label>
					<select name="cargo" required/>
					<option>Admin</option>
					<option>Bodega</option>
				</select>
			</div>

			<div class="botones">
				<input type="submit" name="modificar" value="Modificar"/>
			</div>
		</form>
		<?php
		if (isset($_POST['modificar']))
		{
			$seleccionar = $_POST['seleccionar'];
			if ($seleccionar == '2048371045')
			{
				echo "<script lenguaje='javascript'>alert('Admin general no puede ser modificado');</script>";
			}
			else
			{
				$validation = $dbPDOClass->dbPDO->prepare("SELECT rut FROM personal WHERE rut=:rut");
				$validation->bindParam(':rut', $seleccionar, PDO::PARAM_STR);
				$validation->execute();
				$count = $validation->rowCount();
				if($count == 0)
				{
					echo "<script lenguaje='javascript'>alert('Usuario no encontrado!');</script>";
				}
				else
				{
					$nombre = $_POST['nombre'];
					$updatename = (empty($nombre)) ? $_SESSION['name'] : $nombre;

					$apellido = $_POST['apellido'];
					$updateapellido = (empty($apellido)) ? $_SESSION['apellido'] : $apellido;

					$cargo = $_POST['cargo'];
					$updatecargo = (empty($cargo)) ? $_SESSION['cargo'] : $cargo;

					$update = $dbPDOClass->dbPDO->prepare("UPDATE personal SET nombre=:nombre, apellido=:apellido, cargo=:cargo WHERE rut=:rut");
					$update->bindParam(':nombre', $updatename, PDO::PARAM_STR);
					$update->bindParam(':apellido', $updateapellido, PDO::PARAM_STR);
					$update->bindParam(':cargo', $updatecargo, PDO::PARAM_STR);
					$update->bindParam(':rut', $seleccionar, PDO::PARAM_STR);
					$update->execute();
					echo "<script lenguaje='javascript'>alert('Usuario actualizado!');</script>";

					if ($seleccionar == $_SESSION['rut']) {
						header("Location: updatesession.php?name=".$updatename."&apellido=".$updateapellido."&&cargo=".$cargo);
					}else{
						header("Location: mod_personal.php");
					}
				}
			};

		};
		?>
	</div>
</div>
</body>
</html>		