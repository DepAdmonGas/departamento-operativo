<?php
require('../../../app/help.php');


if ($_POST['AditivoGasolina'] != "" || $_POST['AditivoDiesel'] != "") {

$idEstacion = $_POST['idEstacion'];

  $sql_aditivo = "SELECT * FROM op_inventario_aditivo WHERE id_estacion = '".$idEstacion."' ";
  $result_aditivo = mysqli_query($con, $sql_aditivo);
  while($row_aditivo = mysqli_fetch_array($result_aditivo, MYSQLI_ASSOC)){

    if ($row_aditivo['gasolina'] == "") {
    $gasolina = 0;
    }else{
    $gasolina = $row_aditivo['gasolina'];
    }

    if ($row_aditivo['diesel'] == "") {
    $diesel = 0;
    }else{
    $diesel = $row_aditivo['diesel'];
    } 
  
  }


if ($_POST['AditivoGasolina'] != "") {

  $sql_insert1 = "INSERT INTO op_inventario_aditivo_hist (
    id_estacion,
    aditivo,
    galones,
    detalle
      )
      VALUES
      (
      '".$_POST['idEstacion']."',
      'Gasolina Hitec 6590C',
      '".$_POST['AditivoGasolina']."',
      'Se agrega aditivo'
      )";


  if(mysqli_query($con, $sql_insert1)){

    $Inventario = $gasolina + $_POST['AditivoGasolina'];
    $sql = "UPDATE op_inventario_aditivo SET gasolina='".$Inventario."' WHERE id_estacion='".$_POST['idEstacion']."' ";
    mysqli_query($con, $sql);
  }
}

if ($_POST['AditivoDiesel'] != "") {

  $sql_insert2 = "INSERT INTO op_inventario_aditivo_hist (
    id_estacion,
    aditivo,
    galones,
    detalle
      )
      VALUES
      (
      '".$_POST['idEstacion']."',
      'Diesel Hitec 4133G',
      '".$_POST['AditivoDiesel']."',
      'Se agrega aditivo'
      )";


      if(mysqli_query($con, $sql_insert2)){

        $Inventario = $diesel + $_POST['AditivoDiesel'];
        $sql = "UPDATE op_inventario_aditivo SET diesel='".$Inventario."' WHERE id_estacion='".$_POST['idEstacion']."' ";
        mysqli_query($con, $sql);
      }

}

echo 1;
}else
{
  echo 0;
}




//------------------
mysqli_close($con);
//------------------
