<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];

ValidaProsegur($idReporte,"BILLETE MATUTINO","",0,$con);
ValidaProsegur($idReporte,"BILLETE VESPERTINO","",0,$con);
ValidaProsegur($idReporte,"BILLETE NOCTURNO","",0,$con);
ValidaProsegur($idReporte,"MORRALLA","",0,$con);
ValidaProsegur($idReporte,"DEPOSITO BANCARIO","",0,$con);
ValidaProsegur($idReporte,"CHEQUE 1","",0,$con);
ValidaProsegur($idReporte,"TRANSFERENCIA 1","",0,$con);
ValidaProsegur($idReporte,"CHEQUE 2","",0,$con);
ValidaProsegur($idReporte,"TRANSFERENCIA 2","",0,$con);

function ValidaProsegur($idReporte,$denominacion,$recibo,$importe,$con){

  
   $sql_reporte = "SELECT idreporte_dia, denominacion FROM op_prosegur WHERE idreporte_dia = '".$idReporte."' AND denominacion = '".$denominacion."' ";
   $result_reporte = mysqli_query($con, $sql_reporte);
   $numero_reporte = mysqli_num_rows($result_reporte);

      if($numero_reporte == 0){
    $sql_insert = "INSERT INTO op_prosegur (
    idreporte_dia,
    denominacion,
    recibo,
    importe 
    )
    VALUES 
    (
    '".$idReporte."',
    '".$denominacion."',
    '".$recibo."',
    '".$importe."'
    )";
    mysqli_query($con, $sql_insert);
  }
  }

//------------------
mysqli_close($con);
//------------------