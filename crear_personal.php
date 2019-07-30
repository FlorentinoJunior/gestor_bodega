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
    <title>Crear personal</title>
    <link rel="stylesheet" href="estilo.css"/>
</head>
<body>

    <div class="contenedor">
        <?php
        error_reporting(E_ALL  ^  E_NOTICE  ^  E_WARNING);
        ?>
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

        <br><h1 align="center">GESTIÓN DE PERSONAL</h1>
    </div>
    <div class="formulario">

        <?php 
        if ($_GET['status']) {
            $color = "#E12222B3";
            switch ($_GET['status']) {
                case '0':
                $msg = "No hay datos ingresados!";
                break;
                case '1':
                $msg = "Debes rellenar el formulario!";
                break;
                case '2':
                $msg = "Ya existe un registro asociado al rut ingresado.";
                break;
                case '3':
                $msg = "Las contraseñas deben coincidir!";
                break;
                case '4':
                $color = "#41E122B3";
                $extra = $_GET['new'];
                $msg = "El usuario ".$extra." fue creado!";
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

        <form ="registro" method="post" action="registro.php" enctype="application/x-www-form-urlencoded">
            <div class="campo">
                <label for="cabra">RUT:</label>
                <input type="text" name="rut" required/>
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
                <label for="cargo">Cargo:</label>
                <select name="cargo" required/>
                <option>Admin</option>
                <option>Bodega</option>
            </select>
        </div>

        <div class="campo">
            <div class="en-linea izquierdo">
                <label for="contrasena1">Contraseña:</label>
                <input type="password" name="contrasena1" required/>
            </div>

            <div class="en-linea">
                <label for="contrasena2">Repetir contraseña:</label>
                <input type="password" name="contrasena2" required/>
            </div>
        </div>

        <div class="botones">
            <input type="submit" name="boton-enviar" value="crear usuario"/>    
        </div>
    </form>
</div>

</div>
</body>
</html>