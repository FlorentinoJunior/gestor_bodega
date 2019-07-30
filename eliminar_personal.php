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
	<title>formulario eliminar PERSONAL</title>
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
		
		
		<br><br><h1 align='center'>REGISTROS EXISTENTES</h1><br>
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
		
		foreach ($dbresult as $result)
		{	
			echo "<tr>";	         	  
			echo '<td width=20%>'.$result['rut'].'</td>';
			echo '<td width=20%>'.$result['nombre'].'</td>';
			echo '<td width=20%>'. $result['apellido'].'</td>';
			echo '<td width=20%>'.$result['cargo'].'</td>';
			echo "</tr>";
		}
		echo "</table></br>";
		?>

		<form action="" method="post" align='center'>
			<label name="elimina">Ingresa el Rut del personal a eliminar:</label>
			<input name='eliminar-personal' type="text">
			<input name='eliminar' type="submit" value="ELIMINAR" onclick="return  confirm('Seguro que deseas eliminarlo?')">
		</form>
		<?php
		if (isset($_POST['eliminar'])) {
			$eliminar = $_POST['eliminar-personal'];
			if ($eliminar == '204837104') {
				echo "<script lenguaje='javascript'>alert('Admin general no puede ser eliminado');</script>";
			}else{

				if (!empty($eliminar) && is_numeric($eliminar)) {

					$validation = $dbPDOClass->dbPDO->prepare("SELECT rut FROM personal WHERE rut=:rut");
					$validation->bindParam(':rut', $eliminar, PDO::PARAM_STR);
					$validation->execute();
					$count = $validation->rowCount();

					if($count == 0)
					{
						echo "<script lenguaje='javascript'>alert('Nada que borrar!');</script>";
					}
					else
					{
						if($eliminar != $_SESSION['rut'])
						{
							$delete = $dbPDOClass->dbPDO->prepare("DELETE FROM personal WHERE rut=:rut");
							$delete->bindParam(':rut', $eliminar, PDO::PARAM_STR);
							$delete->execute();

							echo "<script lenguaje='javascript'>alert('Eliminado con exito!');</script>";
							header("Refresh:1; url=eliminar_personal.php");
						}
						else
						{
							echo "<script lenguaje='javascript'>alert('No puedes eliminarte a ti mismo!');</script>";
						}
					}
				}
			}
		};
		?>
	</div>
</body>
</html>		 