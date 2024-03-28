<?php
require('../../../app/help.php');

$sql = "INSERT INTO op_orden_compra_articulo (
    id_ordencompra,      
    id_proveedor,
    concepto,
    unidades,
    estatus_r,
    precio_unitario

      )
      VALUES
      (
      '".$_POST['idReporte']."',
      '".$_POST['Proveedor']."',
      '".$_POST['Concepto']."',
      '".$_POST['Unidades']."',
      '".$_POST['EstatusR']."',
      '".$_POST['PrecioUnitario']."'
      )";


      if(mysqli_query($con, $sql)){
      echo 1;
      }else{
      echo 0;
      }


//------------------
mysqli_close($con);
//------------------