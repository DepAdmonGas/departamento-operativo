<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];

if ($Session_IDEstacion == 1) {
//-------------Interlomas
ValidaTarjetas($idReporte,"1","TICKETCARD",0,$con);
ValidaTarjetas($idReporte,"1.1","G500 FLETT",0,$con);
ValidaTarjetas($idReporte,"A","VALE ACCORD",0,$con);
ValidaTarjetas($idReporte,"2","EFECTICARD",0,$con);
ValidaTarjetas($idReporte,"B","VALE EFECTIVALE",0,$con);
ValidaTarjetas($idReporte,"3","SODEXO",0,$con);
ValidaTarjetas($idReporte,"C","VALE SODEXO",0,$con);
ValidaTarjetas($idReporte,"4","INBURGAS",0,$con);
ValidaTarjetas($idReporte,"5","AMERICAN EXPRESS",0,$con);
ValidaTarjetas($idReporte,"6","BBVA BANCOMER SA",0,$con);
ValidaTarjetas($idReporte,"E","INBURSA",0,$con);
ValidaTarjetas($idReporte,"7","SI VALE",0,$con);
ValidaTarjetas($idReporte,"10","OTROS",0,$con);

}else if ($Session_IDEstacion == 2){
//-------------Palo Solo
ValidaTarjetas($idReporte,"1","TICKETCARD",0,$con);
ValidaTarjetas($idReporte,"1.1","G500 FLETT",0,$con);
ValidaTarjetas($idReporte,"2","EFECTICARD",0,$con);
ValidaTarjetas($idReporte,"3","SODEXO",0,$con);
ValidaTarjetas($idReporte,"4","INBURGAS",0,$con);
ValidaTarjetas($idReporte,"5","AMERICAN EXPRESS",0,$con);
ValidaTarjetas($idReporte,"6","BBVA BANCOMER SA",0,$con);
ValidaTarjetas($idReporte,"E","INBURSA",0,$con);
ValidaTarjetas($idReporte,"10","OTROS",0,$con);

}else if ($Session_IDEstacion == 3){
//-------------San Agustin
ValidaTarjetas($idReporte,"1","TICKETCARD",0,$con);
ValidaTarjetas($idReporte,"1.1","G500 FLETT",0,$con);
ValidaTarjetas($idReporte,"2","EFECTICARD",0,$con);
ValidaTarjetas($idReporte,"3","SODEXO",0,$con);
ValidaTarjetas($idReporte,"4","INBURGAS",0,$con);
ValidaTarjetas($idReporte,"5","AMERICAN EXPRESS",0,$con);
ValidaTarjetas($idReporte,"6","BBVA BANCOMER SA",0,$con);
ValidaTarjetas($idReporte,"E","INBURSA",0,$con);
ValidaTarjetas($idReporte,"7","SI VALE",0,$con);
ValidaTarjetas($idReporte,"8","ULTRAGAS",0,$con);
ValidaTarjetas($idReporte,"9","ENERGEX",0,$con);
ValidaTarjetas($idReporte,"10","OTROS",0,$con);

}else if ($Session_IDEstacion == 4){
//-------------Gasomira
ValidaTarjetas($idReporte,"1","TICKETCARD",0,$con);
ValidaTarjetas($idReporte,"1.1","G500 FLETT",0,$con);
ValidaTarjetas($idReporte,"2","EFECTICARD",0,$con);
ValidaTarjetas($idReporte,"3","SODEXO",0,$con);
ValidaTarjetas($idReporte,"4","INBURGAS",0,$con);
ValidaTarjetas($idReporte,"5","AMERICAN EXPRESS",0,$con);
ValidaTarjetas($idReporte,"6","BBVA BANCOMER SA",0,$con);
ValidaTarjetas($idReporte,"E","INBURSA",0,$con);
ValidaTarjetas($idReporte,"10","OTROS",0,$con);

}else if ($Session_IDEstacion == 5){
//-------------Valle de Guadalupe
ValidaTarjetas($idReporte,"1","TICKETCARD",0,$con);
ValidaTarjetas($idReporte,"1.1","G500 FLETT",0,$con);
ValidaTarjetas($idReporte,"2","EFECTICARD",0,$con);
ValidaTarjetas($idReporte,"3","SODEXO",0,$con);
ValidaTarjetas($idReporte,"4","INBURGAS",0,$con);
ValidaTarjetas($idReporte,"5","AMERICAN EXPRESS",0,$con);
ValidaTarjetas($idReporte,"6","BBVA BANCOMER SA",0,$con);
ValidaTarjetas($idReporte,"E","INBURSA",0,$con);
ValidaTarjetas($idReporte,"10","OTROS",0,$con);

}else if ($Session_IDEstacion == 6){
//--------------Esmegas
ValidaTarjetas($idReporte,"1","TICKETCARD",0,$con);
ValidaTarjetas($idReporte,"1.1","G500 FLETT",0,$con);
ValidaTarjetas($idReporte,"2","EFECTICARD",0,$con);
ValidaTarjetas($idReporte,"B","VALE EFECTIVALE",0,$con);
ValidaTarjetas($idReporte,"3","SODEXO",0,$con);
ValidaTarjetas($idReporte,"C","VALE SODEXO",0,$con);
ValidaTarjetas($idReporte,"4","INBURGAS",0,$con);
ValidaTarjetas($idReporte,"5","AMERICAN EXPRESS",0,$con);
ValidaTarjetas($idReporte,"6","BBVA BANCOMER SA",0,$con);
ValidaTarjetas($idReporte,"E","INBURSA",0,$con);
ValidaTarjetas($idReporte,"10","OTROS",0,$con);

}else if ($Session_IDEstacion == 7){
//--------------Xochimilco
ValidaTarjetas($idReporte,"1","TICKETCARD",0,$con);
ValidaTarjetas($idReporte,"1.1","G500 FLETT",0,$con);
ValidaTarjetas($idReporte,"A","VALE ACCORD",0,$con);
ValidaTarjetas($idReporte,"2","EFECTICARD",0,$con);
ValidaTarjetas($idReporte,"B","VALE EFECTIVALE",0,$con);
ValidaTarjetas($idReporte,"3","SODEXO",0,$con);
ValidaTarjetas($idReporte,"4","INBURGAS",0,$con);
ValidaTarjetas($idReporte,"5","AMERICAN EXPRESS",0,$con);
ValidaTarjetas($idReporte,"6","BBVA BANCOMER SA",0,$con);
ValidaTarjetas($idReporte,"E","INBURSA",0,$con);
ValidaTarjetas($idReporte,"10","OTROS",0,$con);

}else if($Session_IDEstacion == 14){
ValidaTarjetas($idReporte,"1","TICKETCARD",0,$con);
ValidaTarjetas($idReporte,"1.1","G500 FLETT",0,$con);
ValidaTarjetas($idReporte,"2","EFECTICARD",0,$con);
ValidaTarjetas($idReporte,"3","SODEXO",0,$con);
ValidaTarjetas($idReporte,"4","INBURGAS",0,$con);
ValidaTarjetas($idReporte,"5","AMERICAN EXPRESS",0,$con);
ValidaTarjetas($idReporte,"6","BBVA BANCOMER SA",0,$con);
ValidaTarjetas($idReporte,"10","OTROS",0,$con);
}

monederosybancos($idReporte,"TICKETCARD",$con);
monederosybancos($idReporte,"G500 FLETT",$con);
monederosybancos($idReporte,"EFECTICARD",$con);
monederosybancos($idReporte,"SODEXO",$con);
monederosybancos($idReporte,"INBURGAS",$con);
monederosybancos($idReporte,"AMERICAN EXPRESS",$con);
monederosybancos($idReporte,"BBVA BANCOMER SA",$con);
monederosybancos($idReporte,"INBURSA",$con);
monederosybancos($idReporte,"ULTRAGAS",$con);
monederosybancos($idReporte,"ENERGEX",$con);

function ValidaTarjetas($idReporte,$num,$concepto,$baucher,$con){

  
   $sql_reporte = "SELECT idreporte_dia, concepto FROM op_tarjetas_c_b WHERE idreporte_dia = '".$idReporte."' AND concepto = '".$concepto."' ";
   $result_reporte = mysqli_query($con, $sql_reporte);
   $numero_reporte = mysqli_num_rows($result_reporte);

      if($numero_reporte == 0){
    $sql_insert = "INSERT INTO op_tarjetas_c_b (
    idreporte_dia,
    num,
    concepto,
    baucher 
    )
    VALUES 
    (
    '".$idReporte."',
    '".$num."',
    '".$concepto."',
    '".$baucher."'
    )";
    mysqli_query($con, $sql_insert);
  }
  }


  function monederosybancos($idReporte,$empresa,$con){

   $sql_listacierre = "SELECT * FROM op_cierre_lote WHERE idreporte_dia = '".$idReporte."' AND empresa = '".$empresa."' ";
    $result_listacierre = mysqli_query($con, $sql_listacierre);
    while($row_listacierre = mysqli_fetch_array($result_listacierre, MYSQLI_ASSOC)):

        $TotalImporte = 100;
    
    endwhile;

    $sql = "UPDATE op_tarjetas_c_b SET baucher='".$TotalImporte."' WHERE concepto='".$empresa."' AND idreporte_dia = ".$idReporte." ";

  if (mysqli_query($con, $sql)) {
    echo 1;
  } else {
    echo 0;
  }

}

//------------------
mysqli_close($con);
//------------------