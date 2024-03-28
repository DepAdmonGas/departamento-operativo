<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}


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

$sql_lista = "SELECT * FROM op_control_despacho WHERE id_mes = '".$IdReporte."' ORDER BY id desc ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>
<html lang="es">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?php echo RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?php echo RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>alertify.css">
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>themes/default.rtl.css">
  <link href="<?php echo RUTA_CSS ?>bootstrap.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?php echo RUTA_JS ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <style media="screen">
  .LoaderPage {
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url('../imgs/iconos/load-img.gif') 50% 50% no-repeat rgb(249,249,249);
  }
  </style>
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  
  });

  function Regresar(){
   window.history.back();
  }

  </script>
  </head>
  <body>
<div class="LoaderPage"></div>

<div class="p-4">
   <div class="card">
  <div class="card-body">
    <div class="border-bottom">
    <h5 class="card-title"><img class="pr-2" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()"> Control de despacho, <?=nombremes($GET_mes);?> <?=$GET_year;?></h5>
    </div>

<table class="table table-sm table-bordered pb-0 mb-0 mt-2" style="font-size: .8em;">
<thead>
  <th class="align-middle text-center">Fecha y hora</th>
  <th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
</thead>
<tbody>
<?php
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$fechahora = explode(' ', $row_lista['fecha_hora']);
echo '<tr>';
echo '<td class="align-middle">'.FormatoFecha($fechahora[0]).', '.date("g:i a",strtotime($fechahora[1])).'</td>';
echo '<td><a href="../../archivos/'.$row_lista['documento'].'" download><img src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='2' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
  
</div>
</div>
</div>

  <script src="<?php echo RUTA_JS ?>bootstrap.min.js"></script>
  </body>
  </html>
