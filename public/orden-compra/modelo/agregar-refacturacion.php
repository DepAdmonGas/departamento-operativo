<?php
require('../../../app/help.php');

$sql = "INSERT INTO op_orden_compra_refacturacion (
    id_ordencompra,
    id_estacion,
    descripcion,
    cantidad,
    importe,
    porcentaje,
    cantidadES,
    cantidadAl
      )
      VALUES
      (
      '".$_POST['idReporte']."',
      '".$_POST['Estacion']."',
      '".$_POST['Descripcion']."',
      '".$_POST['Cantidad']."',
      '".$_POST['Importe']."',
      '".$_POST['Porcentaje']."',
      '".$_POST['CantidadES']."',
      '".$_POST['CantidadAl']."'
      )";


      if(mysqli_query($con, $sql)){
      echo 1;
      }else{
      echo 0;
      }


//------------------
mysqli_close($con);
//------------------