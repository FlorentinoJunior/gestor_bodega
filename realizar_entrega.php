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
    <title>Entregas</title>
    <link type="text/css" href="estilo.css" rel="stylesheet">

</head>

<body>
    <div class="contenedor">
        <div class= "encabezado">
            <div class="izq">
                <p>Bienvenido/a:<br><?php echo $_SESSION['fullname']; ?></p>
            </div>

            <div class="centro">
                <a href=principalBodega.php><img src='imagenes/home.png'><br>Home</a>
            </div>

            <div class="derecha">
                <a href="salir.php?sal=si"><img src="imagenes/cerrar.png"><br>Salir</a>
            </div>
        </div>


        <br><h1 align='center'>PRODUCTOS EXISTENTES</h1><br>
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

      <form action="" method="post" align='center'>

        <div class="campo">
            <label name="rut">Rut personal que retira:</label>
            <input name='rut' type="text" required="">
        </div>

        <div class="campo">
            <label name="cod">Código del producto:</label>
            <input name='codigo' type="text" required="">
        </div>

        <div class="campo">
            <label name="cantd">Cantidad:</label>
            <input name='cantidad' type="text" required="">
        </div>

        <div class="campo">
            <label name="cantd">Fecha entrega:</label>
            <input name='fecha' type="date" required="">
        </div>

        <div class="botones">
            <input name='agregar' type="submit" value="Agregar">
        </div>

    </form>
</div>
</body>
</html> 


<?php 

if ($_GET['exito'] == "si") {
    echo "<script lenguaje='javascript'>alert('Se ha hecho la entrega!');</script>";
}


if (isset($_POST['agregar'])) {
    $rut = $_POST['rut'];
    $codigo = $_POST['codigo'];
    $cantidad = $_POST['cantidad'];
    $fecha = $_POST['fecha'];

    $verificar = $dbPDOClass->dbPDO->prepare("SELECT stock FROM productos WHERE cod_producto=:cod");
    $verificar->bindParam(':cod', $codigo, PDO::PARAM_STR);
    $verificar->execute();
    $verificacion = $verificar->fetchAll();
    $count = $verificar->rowCount();

    foreach ($verificacion as $key) {
        $dbstock = $key['stock'];
    }

    if($count != 0){
        if ($cantidad > $dbstock) {
            echo "<script lenguaje='javascript'>alert('La cantidad excede a las reservas!');</script>";
        }else{

            $newStock = $dbstock - $cantidad;
            $update = $dbPDOClass->dbPDO->prepare("INSERT INTO entregas (rut, cod_producto, cantidad, fecha_entrega) VALUES (:rut, :cod, :cant, :fecha)");
            $update->bindParam(':rut', $rut, PDO::PARAM_STR);
            $update->bindParam(':cod', $codigo, PDO::PARAM_STR);
            $update->bindParam(':cant', $cantidad, PDO::PARAM_STR);
            $update->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $update->execute();

            $updateStock = $dbPDOClass->dbPDO->prepare("UPDATE productos SET stock=:stock WHERE cod_producto=:cod");
            $updateStock->bindParam(':stock', $newStock, PDO::PARAM_STR);
            $updateStock->bindParam(':cod', $codigo, PDO::PARAM_STR);
            $updateStock->execute();

            sleep(1);
            header("Location: realizar_entrega.php?exito=si");
        }
    }else{
        echo "<script lenguaje='javascript'>alert('Producto no existente.');</script>";
    }

}
?>