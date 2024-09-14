<?php
require 'app/vistas/contenido/header.php';

function IdReporte($Session_IDEstacion,$GET_year,$GET_mes,$con){
  $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$Session_IDEstacion."' AND year = '".$GET_year."' ";
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

  $IdReporte = IdReporte($Session_IDEstacion,$GET_year,$GET_mes,$con); 

  if($GET_mes == 1){
  $Year = $GET_year - 1;
  $Mes = 12;
  if (IdReporte($Session_IDEstacion,$Year,$Mes,$con) == "") {
  $IdReporteA = 0; 
  }else{
  $IdReporteA = IdReporte($Session_IDEstacion,$Year,$Mes,$con); 
  }
  }else{
  $Mes = $GET_mes - 1;
  if(IdReporte($Session_IDEstacion,$GET_year,$Mes,$con) == ""){
  $IdReporteA = 0; 
  }else{
  $IdReporteA = IdReporte($Session_IDEstacion,$GET_year,$Mes,$con); 
  }   
  }

   $sql_fin = "SELECT id FROM op_consumos_pagos_resumen_finalizar WHERE id_mes = '".$IdReporte."' LIMIT 1 ";
   $result_fin = mysqli_query($con, $sql_fin);
   $numero_fin = mysqli_num_rows($result_fin);
   if($numero_fin == 0){
   Resumen($IdReporte,$Session_IDEstacion,$con);
   ActSaldoInicial($IdReporte,$IdReporteA,$con);
   ActPagosConsumos($IdReporte,$IdReporteA,$con);
   ActSaldoFinal($IdReporte,$IdReporteA,$con);
   }else{
   //ActPagosConsumos($IdReporte,$IdReporteA,$con);
   //ActSaldoFinal($IdReporte,$IdReporteA,$con);
   }

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

   mysqli_query($con, $sql_insert);
   }
  }

  //-----------------------------------------------------------------------------

 function ConsumoPago($idResumen,$IdReporte,$idcliente,$con){
 $sql = "SELECT id FROM op_corte_dia WHERE id_mes = '".$IdReporte."' ";
 $result = mysqli_query($con, $sql);
 $numero = mysqli_num_rows($result);
 while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
 $reportedia = $row['id'];

 $Consumo = TotalCP($reportedia,$idcliente,'Consumo',$con);
 $totalCo = $totalCo + $Consumo;

 $Pago = TotalCP($reportedia,$idcliente,'Pago',$con);
 $totalPa = $totalPa + $Pago;

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
$total = $total + $row_c['total'];
}
}else{
$total = 0; 
}

return $total;

}

function SaldoInicial($IdReporteA,$idResumen,$idcliente,$con){

 $sql = "SELECT saldo_final FROM op_consumos_pagos_resumen WHERE id_mes = '".$IdReporteA."' AND id_cliente = '".$idcliente."' LIMIT 1 ";
 $result = mysqli_query($con, $sql);
 $numero = mysqli_num_rows($result);
 if ($numero == 1) {

 while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
 $saldoFinal = $row['saldo_final'];
 }

 if ($saldoFinal != 0) {

 $sql_edit = "UPDATE op_consumos_pagos_resumen SET saldo_inicial = '".$saldoFinal."' WHERE id='".$idResumen."' ";
 mysqli_query($con, $sql_edit);
 
 }
 }
 }

function SaldoFinal($idResumen,$saldoFinal,$con){
  $sql_edit1 = "UPDATE op_consumos_pagos_resumen SET saldo_final = '".$saldoFinal."' WHERE id='".$idResumen."' ";
 mysqli_query($con, $sql_edit1);
}

//-----------------------------------------------------------------
 
 function ActSaldoInicial($IdReporte,$IdReporteA,$con){
 $saldoFinal = 0;
 $sql = "SELECT id, id_mes, id_cliente,saldo_inicial,consumos,pagos FROM op_consumos_pagos_resumen WHERE id_mes = '".$IdReporte."' ";
 $result = mysqli_query($con, $sql);
 $numero = mysqli_num_rows($result);
 while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
 $idResumen = $row['id'];
 $idcliente = $row['id_cliente'];
 SaldoInicial($IdReporteA,$idResumen,$idcliente,$con);
 ConsumoPago($idResumen,$IdReporte,$idcliente,$con);
 }
 }

 function ActPagosConsumos($IdReporte,$IdReporteA,$con){
 $saldoFinal = 0;
 $sql = "SELECT id, id_mes, id_cliente,saldo_inicial,consumos,pagos FROM op_consumos_pagos_resumen WHERE id_mes = '".$IdReporte."' ";
 $result = mysqli_query($con, $sql);
 $numero = mysqli_num_rows($result);
 while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
 $idResumen = $row['id'];
 $idcliente = $row['id_cliente'];
 ConsumoPago($idResumen,$IdReporte,$idcliente,$con);
 }
 }

 function ActSaldoFinal($IdReporte,$IdReporteA,$con){
 $saldoFinal = 0;
 $sql = "SELECT id, id_mes, id_cliente,saldo_inicial,consumos,pagos FROM op_consumos_pagos_resumen WHERE id_mes = '".$IdReporte."' ";
 $result = mysqli_query($con, $sql);
 $numero = mysqli_num_rows($result);
 while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
 $idResumen = $row['id'];
 $idcliente = $row['id_cliente'];
 $saldoFinal = $row['saldo_inicial'] + $row['consumos'] - $row['pagos'];
 SaldoFinal($idResumen,$saldoFinal,$con);
 }
 }

 $sql_fin = "SELECT id FROM op_consumos_pagos_resumen_finalizar WHERE id_mes = '".$IdReporte."' LIMIT 1 ";
 $result_fin = mysqli_query($con, $sql_fin);
 $numero_fin = mysqli_num_rows($result_fin);


  if($numero_fin == 0){

  $botonFinalizar = '<div class="text-end mb-3">
  <button type="button" class="btn btn-success btn-sm" onclick="Finalizar('.$IdReporte.')">Finalizar</button>
  </div>';
        
  }else{
    $botonFinalizar = '';

  }


?>
<!---------- LIBRERIAS DEL DATATABLE ---------->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">

<script type="text/javascript" src="<?php echo RUTA_CORTEDIARIO_JS ?>clientes-mes-functions.js"></script>
<script type="text/javascript">
  $(document).ready(function ($) {
    $(".LoaderPage").fadeOut("slow");
    ReporteClientes(<?= $IdReporte?>,"<?=RUTA_JS2?>");
  });
</script>

<body>
  <div class="LoaderPage"></div>
  <!---------- DIV - CONTENIDO ---------->
  <div id="content">
    <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
    <?php include_once "public/navbar/navbar-perfil.php"; ?>
    <!---------- CONTENIDO PAGINA WEB---------->
    <div class="contendAG">
      <div class="row">

        <div class="col-12">
          <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
            <ol class="breadcrumb breadcrumb-caret">
              <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-chevron-left"></i>
                    Corte Diario, <?=$ClassHerramientasDptoOperativo->nombreMes($GET_mes)?> <?=$GET_year?></a></li>
                    <li aria-current="page" class="breadcrumb-item active text-uppercase">
                Resumen Clientes (<?=$ClassHerramientasDptoOperativo->nombremes($GET_mes)?> <?=$GET_year?>)
              </li>
            </ol>
          </div>
          <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Resumen Clientes (<?= $ClassHerramientasDptoOperativo->nombremes($GET_mes)?> <?=$GET_year?>)
              </h3>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
            <?=$botonFinalizar?>
            </div>
          </div>
          <hr>
        </div>

        <div id="DivReporteClientes" class="col-12"></div>


      </div>

    </div>
  </div>


<!---------- FUNCIONES - NAVBAR ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>
<!---------- LIBRERIAS DEL DATATABLE ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

</body>
</html>