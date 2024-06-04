<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];

ValidaClientes($idReporte,"EFECTIVO",0,"",$con);
ValidaClientes($idReporte,"CHEQUE",0,"",$con);
ValidaClientes($idReporte,"TRANSFERENCIA (SPEI)",0,"",$con);
ValidaClientes($idReporte,"TARJETA DE CREDITO",0,"",$con);
ValidaClientes($idReporte,"DEPOSITO BANCARIO",0,"",$con);


function ValidaClientes($idReporte,$concepto,$importe,$nota,$con){

  
   $sql_reporte = "SELECT idreporte_dia, concepto FROM op_pago_clientes WHERE idreporte_dia = '".$idReporte."' AND concepto = '".$concepto."' ";
   $result_reporte = mysqli_query($con, $sql_reporte);
   $numero_reporte = mysqli_num_rows($result_reporte);

      if($numero_reporte == 0){
    $sql_insert = "INSERT INTO op_pago_clientes (
    idreporte_dia,
    concepto,
    importe,
    nota 
    )
    VALUES 
    (
    '".$idReporte."',
    '".$concepto."',
    '".$importe."',
    '".$nota."'
    )";
    mysqli_query($con, $sql_insert);
  }
  }

//------------------
mysqli_close($con);
//------------------