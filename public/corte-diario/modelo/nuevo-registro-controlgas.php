<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];

ValidaControlgas($idReporte,"CRÉDITO (ANEXO)",0,0,$con);
ValidaControlgas($idReporte,"DEBITO (ANEXO)",0,0,$con);


function ValidaControlgas($idReporte,$concepto,$pago,$consumo,$con){

  
   $sql_reporte = "SELECT idreporte_dia, concepto FROM op_clientes_controlgas WHERE idreporte_dia = '".$idReporte."' AND concepto = '".$concepto."' ";
   $result_reporte = mysqli_query($con, $sql_reporte);
   $numero_reporte = mysqli_num_rows($result_reporte);

      if($numero_reporte == 0){
    $sql_insert = "INSERT INTO op_clientes_controlgas (
    idreporte_dia,
    concepto,
    pago,
    consumo 
    )
    VALUES 
    (
    '".$idReporte."',
    '".$concepto."',
    '".$pago."',
    '".$consumo."'
    )";
    mysqli_query($con, $sql_insert);
  }
  }

//------------------
mysqli_close($con);
//------------------