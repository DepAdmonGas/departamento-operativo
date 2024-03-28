<?php
require('../../../app/help.php');

$sql = "INSERT INTO op_orden_compra_proveedor (
      id_ordencompra, 
      razon_social,
      direccion, 
      contacto,
      email
      )
      VALUES
      (
      '".$_POST['idReporte']."',
      '".$_POST['RazonSocial']."',
      '".$_POST['Direccion']."',
      '".$_POST['Contacto']."',
      '".$_POST['Email']."'
      )";

      if(mysqli_query($con, $sql)){
      echo 1;
      }else{
      echo 0;
      }
 
//------------------
mysqli_close($con);
//------------------