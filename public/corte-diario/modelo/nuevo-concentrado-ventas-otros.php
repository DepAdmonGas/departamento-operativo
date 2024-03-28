<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];

ValidaOtros($idReporte,"OTROS","",0,$con);
ValidaOtros($idReporte,"4 ACEITES Y LUBRICANTES","",0,$con);
ValidaOtros($idReporte,"5 AUTOLAVADO","",0,$con);
ValidaOtros($idReporte,"6 ADITIVO PARA DIESEL","",0,$con);

if($Session_IDEstacion == 2){
ValidaOtros($idReporte,"7 G BENEFICIOS","",0,$con);
}


function ValidaOtros($idReporte,$concepto,$piezas,$importe,$con){

  
   $sql_reporte = "SELECT idreporte_dia, concepto FROM op_ventas_dia_otros WHERE idreporte_dia = '".$idReporte."' AND concepto = '".$concepto."' ";
   $result_reporte = mysqli_query($con, $sql_reporte);
   $numero_reporte = mysqli_num_rows($result_reporte);

      if($numero_reporte == 0){
    $sql_insert = "INSERT INTO op_ventas_dia_otros (
    idreporte_dia,
    concepto,
    piezas,
    importe
    )
    VALUES 
    (
    '".$idReporte."',
    '".$concepto."',
    '".$piezas."',
    '".$importe."'
    )";
    mysqli_query($con, $sql_insert);
  }
  }

//------------------
mysqli_close($con);
//------------------