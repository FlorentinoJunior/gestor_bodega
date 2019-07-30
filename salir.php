<?php 	
include('sesion.php');
$data = Sessions::getInstance();

if ($_GET['sal'] == 'si') {
	$data->destroy();
	header("Location: login.php");
}else{
	header("Location: principalAdmin.php");
}
 ?>

