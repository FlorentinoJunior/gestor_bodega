<?php 
include('sesion.php');
$data = Sessions::getInstance();

if ($data->isOnline == false) {
	header("Location: login.php");
}
error_reporting(E_ALL  ^  E_NOTICE  ^  E_WARNING);
?>
<!DOCTYPE html> 
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>formulario eliminar producto</title>
		<link type="text/css" href="estilo.css" rel="stylesheet">

	</head>

	<body>
		<div class="contenedor">
			<div class= "encabezado">
				<div class="izq">
					<p>Bienvenido/a:<br><?php echo $_SESSION['fullname']; ?></p>
				</div>

				<div class="centro">
					<?php
						if ($_SESSION['cargo']=='Admin') {
								echo "<a href=principalAdmin.php><center><img src='imagenes/home.png'><br>Home<center></a>";
						}else {
								echo "<a href=principalBodega.php><img src='imagenes/home.png'><br>Home</a>";
						}
	       			?> 
				</div>
				
				<div class="derecha">
					<a href="salir.php?sal=si"><img src="imagenes/cerrar.png"><br>Salir</a>
				</div>
			</div>
				
			
			<br><h1 align='center'>REGISTROS EXISTENTES</h1><br>
			<?php 
			if ($_GET['status']) {
				$color = "#E12222B3";
				switch ($_GET['status']) {
					case '10':
					$msg = "No hay datos ingresados!";
					break;
					case '11':
					$msg = "El CODIGO de producto no existe!";
					break;
					case '200':
					$color = "#41E122B3";
					$extra = $_GET['new'];
					$msg = "El producto #".$extra." fue eliminado!";
					break;
					default:
					$msg = "Error desconocido, contacta con un administrador.";
					break;
				}

				echo '<div style="margin-top: 2px;margin-bottom: 2px;">';
				echo '<div class="formulario" style="background-color: '.$color.';">';
				echo '<p style="text-align: center;text-align-last: ;font-weight: bolder;font-size-adjust: inherit;margin-bottom: 1em;">'.$msg.'</p>';
				echo '</div>';
				echo '</div>';

			}

			?>
			<br>
			<?php
				$dbPDOClass = new PDOConnect();
				$stmt = $dbPDOClass->dbPDO->prepare("SELECT * FROM productos");
				$stmt->execute();
				$dbresult = $stmt->fetchAll();
			
				echo "<table  width='80%' align='center'><tr>";	         	  
				echo "<th width='10%'>CODIGO PRODUCTO</th>";
				echo "<th width='20%'>DESCRIPCIÓN</th>";
				echo "<th width='10%'>STOCK</th>";
				echo "<th width='20%'>PROVEEDOR</th>";
				echo "<th width='20%'>FECHA DE INGRESO</th>";
				echo  "</tr>"; 
			
				foreach($dbresult as $result){	
		          	
		          echo "<tr>";	         	  
				  echo '<td width=10%>'.$result['cod_producto'].'</td>';
				  echo '<td width=20%>'.$result['descripcion'].'</td>';
				  echo '<td width=20%>'. $result['stock'].'</td>';
				  echo '<td width=20%>'.$result['proveedor'].'</td>';
				  echo '<td width=20%>'.$result['fecha_ingreso'].'</td>';
				  echo "</tr>";
				}
				echo "</table></br>";
			?>
			<form action="gestion_productos.php?modo=eliminar" method="post" align='center'>
			 	<label name="elimina">Ingresa el código del producto a eliminar:</label>
			 	<input name='codigo' type="text">
			 	<input name='eliminar' type="submit" value="ELIMINAR" onclick="return confirm('Seguro que deseas eliminarlo?')">
			</form>   	
		</div>
	</body>
</html>		 