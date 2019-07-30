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
    <title>Agregar productos</title>
    <link rel="stylesheet" href="estilo.css"/>
</head>
<body>

    <div class="contenedor">
        <div class= "encabezado">
            <div class="izq">

                <p>Bienvenido/a:<br> <?php echo $_SESSION['fullname']; ?></p>

            </div>
            <div class="centro">
                <?php
                if ($_SESSION['cargo']=='Admin') {
                    echo "<a href=principalAdmin.php><center><img src='imagenes/home.png'><br>Home<center></a>";
                }else {
                    echo "<a href=principalBodega.php><img src='imagenes/home.png'><br>Home</a>";
                };

                error_reporting(E_ALL  ^  E_NOTICE  ^  E_WARNING);
                ?> 
            </div>
            
            <div class="derecha">
                <a href="salir.php?sal=si"><img src="imagenes/cerrar.png"><br>Salir</a>
            </div>
        </div>
        <br><h1 align="center">GESTIÓN DE PRODUCTOS</h1>     

        <div class="formulario">
            <?php 
            if ($_GET['status']) {
                $color = "#E12222B3";
                switch ($_GET['status']) {
                    case '10':
                    $msg = "No hay datos ingresados!";
                    break;
                    case '11':
                    $msg = "El CODIGO de producto ya existe!";
                    break;
                    case '200':
                    $color = "#41E122B3";
                    $extra = $_GET['new'];
                    $msg = "El producto #".$extra." fue creado!";
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
            <form name="registro" method="post" action="gestion_productos.php?modo=agregar" enctype="application/x-www-form-urlencoded">
                <div class="campo">
                    <label for="codigo">Código del producto:</label>
                    <input type="text" name="codigo" required/>
                </div>


                <div class="campo">
                    <label for="nombre">Descripción:</label>
                    <input type="text" name="descripcion" required/>
                </div>

                <div class="campo">
                    <label for="stock">Stock:</label>
                    <input type="number" name="stock" required/>
                </div>


                <div class="campo">
                    <label for="proveedor">Proveedor:</label>
                    <input type="text" name="proveedor" required/>
                </div>

                <div class="campo">
                    <label for="fecha">Fecha ingreso:</label>
                    <input type="date" name="fecha" required/>
                </div>

                <div class="botones">
                    <input type="submit" name="crear" value="Agregar producto"/>
                </div>
              </form>
                </div>
                    </div>
</body>
</html>