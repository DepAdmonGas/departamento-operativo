<?php
require('../../../app/help.php');

$IdReporte = $_POST['IdReporte'];
$GET_idEstacion = $_POST['idEstacion'];
$GET_year = $_POST['year'];
$GET_mes = $_POST['mes'];

function IdReporte($GET_idEstacion,$GET_year,$GET_mes,$con){
   $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$GET_idEstacion."' AND year = '".$GET_year."' ";
   $result_year = mysqli_query($con, $sql_year);
   while($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)){
   $idyear = $row_year['id'];
   }

   $sql_mes = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '".$idyear."' AND mes = '".$GET_mes."' ";
   $result_mes = mysqli_query($con, $sql_mes);
   while($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)){
   $idmes = $row_mes['id'];
   }
   return $idmes;
   }

   if($GET_mes == 1){
   $Year = $GET_year - 1;
   $Mes = 12;
   if (IdReporte($GET_idEstacion,$Year,$Mes,$con) == "") {
   $IdReporteA = 0; 
   }else{
   $IdReporteA = IdReporte($GET_idEstacion,$Year,$Mes,$con); 
   }
   }else{
   $Mes = $GET_mes - 1;
   if(IdReporte($GET_idEstacion,$GET_year,$Mes,$con) == ""){
   $IdReporteA = 0; 
   }else{
   $IdReporteA = IdReporte($GET_idEstacion,$GET_year,$Mes,$con); 
   }   
   }


   Resumen($IdReporte,$GET_idEstacion,$con);

   function Resumen($IdReporte,$idEstacion,$con){
    $sql = "SELECT * FROM op_cliente WHERE id_estacion = '".$idEstacion."' AND estado = 1 ";
    $result = mysqli_query($con, $sql);
    $numero = mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $id = $row['id'];
    ValidaResumen($IdReporte,$id,$con);
    
    }
    }

   function ValidaResumen($IdReporte,$id,$con){
    $sql = "SELECT * FROM op_consumos_pagos_resumen WHERE id_mes = '".$IdReporte."' AND id_cliente = '".$id."' ";
    $result = mysqli_query($con, $sql);
    $numero = mysqli_num_rows($result);

    if ($numero == 0) {
    $sql_insert = "INSERT INTO op_consumos_pagos_resumen (
    id_mes,
    id_cliente,
    saldo_inicial,
    consumos,
    pagos,
    saldo_final
    )
    VALUES 
    (
    '".$IdReporte."',
    '".$id."',
    0,
    0,
    0,
    0
    )";

    if(mysqli_query($con, $sql_insert)){
    return 1;
    }else{
    return 0;
    }
    }
   }

   //-----------------------------------------------------------------------------

   ResumenCP($IdReporte,$IdReporteA,$con);

  function ResumenCP($IdReporte,$IdReporteA,$con){
  $saldoFinal = 0;
  $sql = "SELECT id, id_mes, id_cliente,saldo_inicial,consumos,pagos FROM op_consumos_pagos_resumen WHERE id_mes = '".$IdReporte."' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  $idResumen = $row['id'];
  $idcliente = $row['id_cliente'];
  ConsumoPago($idResumen,$IdReporte,$idcliente,$con);
  if ($IdReporteA != 0) {
  SaldoInicial($IdReporteA,$idResumen,$idcliente,$con);
  }

  $saldoFinal = $row['saldo_inicial'] + $row['consumos'] - $row['pagos'];

  SaldoFinal($idResumen,$saldoFinal,$con);

  }
  }

function ConsumoPago($idResumen, $IdReporte, $idcliente, $con){
  $totalCo = 0; // Inicializa la variable
  $totalPa = 0; // Inicializa la variable
  
  $sql = "SELECT id FROM op_corte_dia WHERE id_mes = '".$IdReporte."' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $reportedia = $row['id'];

    $Consumo = TotalCP($reportedia, $idcliente, 'Consumo', $con);
    $totalCo += $Consumo;

    $Pago = TotalCP($reportedia, $idcliente, 'Pago', $con);
    $totalPa += $Pago;
  }

  $sql_edit1 = "UPDATE op_consumos_pagos_resumen SET consumos = '".$totalCo."' WHERE id='".$idResumen."' ";
  mysqli_query($con, $sql_edit1);

  $sql_edit2 = "UPDATE op_consumos_pagos_resumen SET pagos = '".$totalPa."' WHERE id='".$idResumen."' ";
  mysqli_query($con, $sql_edit2);
}

  function TotalCP($reportedia,$idCliente,$tipo,$con){

$sql_c = "SELECT total FROM op_consumos_pagos WHERE id_reportedia = '".$reportedia."' AND id_cliente = '".$idCliente."' AND tipo = '".$tipo."' ";
$result_c = mysqli_query($con, $sql_c);
$numero_c = mysqli_num_rows($result_c);

if ($numero_c > 0) {
while($row_c = mysqli_fetch_array($result_c, MYSQLI_ASSOC)){
$total = $row_c['total'];
}
}else{
$total = 0; 
}
return $total;

}

function SaldoInicial($IdReporteA,$idResumen,$idcliente,$con){
  $saldoFinal = 0; // Inicializa la variable

$sql = "SELECT saldo_final FROM op_consumos_pagos_resumen WHERE id_mes = '".$IdReporteA."' AND id_cliente = '".$idcliente."' LIMIT 1 ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  $saldoFinal = $row['saldo_final'];
  }

  $sql_edit = "UPDATE op_consumos_pagos_resumen SET saldo_inicial = '".$saldoFinal."' WHERE id='".$idResumen."' ";
  mysqli_query($con, $sql_edit);

}

function SaldoFinal($idResumen,$saldoFinal,$con){
   $sql_edit1 = "UPDATE op_consumos_pagos_resumen SET saldo_final = '".$saldoFinal."' WHERE id='".$idResumen."' ";
  mysqli_query($con, $sql_edit1);
}

echo 1;