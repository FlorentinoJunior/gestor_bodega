<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('sesion.php');
$data = Sessions::getInstance();


$username = $_POST['usuario'];
$password = $_POST['pass'];

$newpass = md5($password);

if($_POST)
{
	if(!empty($username) or !empty($password))
	{
		$dbPDOClass = new PDOConnect();
		$stmt = $dbPDOClass->dbPDO->prepare("SELECT * FROM personal WHERE rut=:name AND contrasena=:pass");
		$stmt->bindParam(':name', $username, PDO::PARAM_STR);
		$stmt->bindParam(':pass', $newpass, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		

		if($count == 0)
		{
			redireccionar("login.php?error=si");
		}
		else
		{
			$result = $stmt->fetchAll();
			foreach ($result as $key)
			{
				$dbpass = $key['contrasena'];
				$dbrut  = $key['rut'];
				$dbname = $key['nombre'];
				$dbapellido = $key['apellido'];
				$dbcargo = $key['cargo'];
			}

			if($newpass === $dbpass)
			{
				$data->setOnline(true);
				$data->rut = $dbrut;
				$data->name = $dbname;
				$data->apellido = $dbapellido;
				$data->fullname = $dbname." ".$dbapellido;
				$data->cargo = $dbcargo;
				switch ($dbcargo) {
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
			else
			{
				redireccionar("login.php?error=si");
			}
		}
	}
	else
	{
		redireccionar("login.php?error=si");
	}
}
else
{
	redireccionar("login.php?error=si&msg=1");
}


function redireccionar($destino){
	header("Location: $destino");
}


?>



   

