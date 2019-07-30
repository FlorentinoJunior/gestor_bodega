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
	<title>Modificar producto</title>
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
		<br><h1 align="center">PRODUCTOS EXISTENTES</h1><br>
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


		<div class="encabezado">
			<h1>Modificar producto</h1>
		</div>

		<div class="formulario">
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
					$msg = "El producto #".$extra." tiene un nuevo stock!";
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
			<form name="actualizar" method="post" action="gestion_productos.php?modo=modificar&mod=stock" enctype="application/x-www-form-urlencoded">
				<div class="campo">
					<p>Para actualizar el stock de un producto ingresa el código del producto y la cantidad que deseas agregar. Para quitar deber ingresar la cantidad anteponiendo el signo menos (-) a la cantidad</p><br><br>

					<label name="Seleccionar">Ingresa el código del producto que deseas actualizar:</label>
					<input name='codigo' type="text" required>
				</div>

				<div class="campo">
					<div class="en-linea izquierdo">
						<label for="descrip">Stock:</label>
						<input type="number" name="stock" required/>
					</div>

					<div class="en-linea">
						<label for="apellido">Stock:</label>
						<input type="submit" name="actualiza" value="Actualizar" required/>
					</div>
				</div>

			</form>

			<form name="modificar" method="post" action="gestion_productos.php?modo=modificar&mod=producto" enctype="application/x-www-form-urlencoded">

				<div class="campo">
					<label name="Seleccionar">Ingresa el código del producto que deseas modificar:</label>
					<input name='codigo' type="text" required>
				</div>

				<div class="campo">
					<label for="descrip">Descripción:</label>
					<input type="text" name="descripcion" required/>
				</div>

				<div class="campo">
					<label for="cargo">Proveedor:</label>
					<input type="text" name="proveedor" required/>
				</div>

				<div class="campo">
					<label for="cargo">Fecha ingreso:</label>
					<input type="date" name="fecha" required/>
				</div>

				<div class="botones">
					<input type="submit" name="modificar" value="Modificar"/>
				</div>
			</form>

		</div>
	</div>
</body>
</html>