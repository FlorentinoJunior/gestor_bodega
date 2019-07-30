<?php 
include('sesion.php');
$data = Sessions::getInstance();

if ($data->isOnline == false or $data->cargo == "bodega") {
	header("Location: login.php");
}

$rut = $_POST['rut'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$cargo = $_POST['cargo'];
$realpass = ($_POST['contrasena1'] === $_POST['contrasena2']) ?  $_POST['contrasena1'] : 'FALSE';


$dbPDOClass = new PDOConnect();
$stmt = $dbPDOClass->dbPDO->prepare("SELECT rut FROM personal WHERE rut=:name");
$stmt->bindParam(':name', $rut, PDO::PARAM_STR);
$stmt->execute();
$count = $stmt->rowCount();

if ($_POST) {
	if(!isset($_POST['boton-enviar']) or !isset($_POST['rut']) or $_POST['nombre'] or $_POST['apellido'] or $_POST['contrasena1']){
		if ($count == 0) {
			if ($realpass != 'FALSE') {
				$hashPass = md5($realpass);

				$putdata = $dbPDOClass->dbPDO->prepare("INSERT INTO personal (rut, nombre, apellido, cargo, contrasena) VALUES (:rut, :nombre, :apellido, :cargo, :contrasena)");
				$putdata->bindParam(':rut', $rut, PDO::PARAM_STR);
				$putdata->bindParam(':nombre', $nombre, PDO::PARAM_STR);
				$putdata->bindParam(':apellido', $apellido, PDO::PARAM_STR);
				$putdata->bindParam(':cargo', $cargo, PDO::PARAM_STR);
				$putdata->bindParam(':contrasena', $hashPass, PDO::PARAM_STR);
				$putdata->execute();
				header('Location: crear_personal.php?status=4&new='.$nombre.' '.$apellido);
			}else{
				header('Location: crear_personal.php?status=3');
			}
		}else{
			header('Location: crear_personal.php?status=2');
		}
	}else{
		header('Location: crear_personal.php?status=1');
	}
}else{
	header('Location: crear_personal.php?status=0');
}
?>