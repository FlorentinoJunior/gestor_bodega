<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('sesion.php');
$data = Sessions::getInstance();
$dbPDOClass = new PDOConnect();

$codigo = $_POST['codigo'];
$desc = "";
$stock = $_POST['stock'];
$proveedor = "";
$fecha = "";

if (isset($_POST)) {
	if($_GET)
	{

		switch ($_GET['modo']) {
			case 'agregar':
			$desc = $_POST['descripcion'];
			$proveedor = $_POST['proveedor'];
			$fecha = $_POST['fecha'];

			$verificar = $dbPDOClass->dbPDO->prepare("SELECT cod_producto FROM productos WHERE cod_producto=:cod");
			$verificar->bindParam(':cod', $codigo, PDO::PARAM_STR);
			$verificar->execute();
			$count = $verificar->rowCount();

			if ($count == 0) {
				$stmt = $dbPDOClass->dbPDO->prepare("INSERT INTO `productos`(`cod_producto`, `descripcion`, `stock`, `proveedor`, `fecha_ingreso`) VALUES (:cod,:descripcion,:stock,:prov,:fecha)");
				$stmt->bindParam(':cod', $codigo, PDO::PARAM_STR);
				$stmt->bindParam(':descripcion', $desc, PDO::PARAM_STR);
				$stmt->bindParam(':stock', $stock, PDO::PARAM_STR);
				$stmt->bindParam(':prov', $proveedor, PDO::PARAM_STR);
				$stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
				$stmt->execute();
				
				header("Location: mod_producto.php?status=200&new=".$codigo);
			} else {
				header("Location: mod_producto.php?status=11");
			}
			break;
			case 'modificar':
			if ($_GET['mod'] == "stock") {
				if (isset($_POST['actualiza'])) {
					$verificar = $dbPDOClass->dbPDO->prepare("SELECT stock FROM productos WHERE cod_producto=:cod");
					$verificar->bindParam(':cod', $codigo, PDO::PARAM_STR);
					$verificar->execute();
					$verificacion = $verificar->fetchAll();

					foreach ($verificacion as $key) {
						$dbstock = $key['stock'] + $stock;
					}
					$stmt = $dbPDOClass->dbPDO->prepare("UPDATE productos SET stock = :total WHERE cod_producto = :cod");
					$stmt->bindParam(':cod', $codigo, PDO::PARAM_STR);
					$stmt->bindParam(':total', $dbstock, PDO::PARAM_STR);
					$stmt->execute();
					header("Location: mod_producto.php?status=200&new=".$codigo);
				} else {
					header("Location: mod_producto.php?status=10");
				}
			} elseif($_GET['mod'] == "producto") {
				if ($_POST['modificar']) {
					$desc = $_POST['descripcion'];
					$proveedor = $_POST['proveedor'];
					$fecha = $_POST['fecha'];

					$verificar = $dbPDOClass->dbPDO->prepare("SELECT cod_producto FROM productos WHERE cod_producto=:cod");
					$verificar->bindParam(':cod', $codigo, PDO::PARAM_STR);
					$verificar->execute();
					$count = $verificar->rowCount();
					if($count != 0){
						$stmt = $dbPDOClass->dbPDO->prepare("UPDATE productos SET descripcion=:descripcion, proveedor=:prov, fecha_ingreso=:fecha WHERE cod_producto=:cod");
						$stmt->bindParam(':cod', $codigo, PDO::PARAM_STR);
						$stmt->bindParam(':descripcion', $desc, PDO::PARAM_STR);
						$stmt->bindParam(':prov', $proveedor, PDO::PARAM_STR);
						$stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
						$stmt->execute();
						header("Location: mod_producto.php?status=200&new=".$codigo);
					}else{
						header("Location: mod_producto.php?status=11");
					}
				}else{
					header("Location: mod_producto.php?status=10");
				}
			}
			break;
			case 'eliminar':
				if (isset($_POST['eliminar'])) {
					$verificar = $dbPDOClass->dbPDO->prepare("SELECT cod_producto FROM productos WHERE cod_producto=:cod");
					$verificar->bindParam(':cod', $codigo, PDO::PARAM_STR);
					$verificar->execute();
					$count = $verificar->rowCount();
					if($count != 0){
						$stmt = $dbPDOClass->dbPDO->prepare("DELETE FROM `productos` WHERE cod_producto=:cod");
						$stmt->bindParam(':cod', $codigo, PDO::PARAM_STR);
						$stmt->execute();
						header("Location: eliminar_producto.php?status=200&new=".$codigo);
					}else{
						header("Location: eliminar_producto.php?status=11");
					}
				}
			break;
			default:
				header("Location: eliminar_producto.php?status=404");
			break;
		}
	}else{
		header("Location: mod_producto.php?status=10");
	}

} else {
	if ($_SESSION['cargo']=='Admin') {
		echo "<a href=principalAdmin.php><center><img src='imagenes/home.png'><br>Home<center></a>";
	}else {
		echo "<a href=principalBodega.php><img src='imagenes/home.png'><br>Home</a>";
	};
}
function redireccionar($destino){
	header("Location: $destino");
}
?>






