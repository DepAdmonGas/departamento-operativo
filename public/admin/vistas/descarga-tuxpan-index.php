<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

 
function Estacion($idEstacion,$con){
$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}
return $estacion;
}
?>
 
<html lang="es">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?=RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?=RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>alertify.css">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>themes/default.rtl.css">
  <link href="<?=RUTA_CSS2;?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?=RUTA_CSS2;?>navbar-general.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script type="text/javascript">
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  });

 
  function Regresar(){
  window.history.back();
  }
  function CrearDescarga(){
  window.location.href = "descarga-tuxpan-nuevo";   
  }
  function Detalle(id){
  window.location.href = "descarga-tuxpan-detalle/" + id;   
  }

  function PDF(id){
  window.location.href = "administracion/descarga-tuxpan-pdf/" + id;   
  }

  </script>
  </head>
  
  <body>
  <div class="LoaderPage"></div>

  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">

  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <?php include_once "public/navbar/navbar-perfil.php";?>
 
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">

  <div class="row">
  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3"> 

  <div class="row">
  <div class="col-10"> 
  <h5>Formato de descarga merma</h5> 
  </div>

  <div class="col-2"> 
  <img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="CrearDescarga()">
  </div>

  </div>
  <hr>

   
  <div class="col-12">
    
  <div class="table-responsive">
  <table class="table table-sm table-bordered mb-0" style="font-size: 1em">
          <thead class="tables-bg">
          <tr>
            <th class="align-middle text-center">Folio</th>
            <th class="align-middle text-center">Estación</th>
            <th class="align-middle text-center">Fecha y hora</th>
            <th class="align-middle text-center"width="20px"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
            <th class="align-middle text-center"width="20px"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
          </tr>
          </thead>
          <tbody>   
  <?php  

  if($Session_IDEstacion == 8){
  $sql_lista = "SELECT * FROM op_descarga_tuxpa ORDER BY folio desc ";
  }else{
  $sql_lista = "SELECT * FROM op_descarga_tuxpa WHERE id_estacion = '".$Session_IDEstacion."' ORDER BY folio desc ";
  }


  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if ($numero_lista > 0) {
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
  $id = $row_lista['id'];
  $folio = $row_lista['folio'];
  $Estacion = Estacion($row_lista['id_estacion'],$con);
  $fechallegada = FormatoFecha($row_lista['fecha_llegada']);
  $horallegada = date("g:i a",strtotime($row_lista['hora_llegada']));

  echo '<tr>
        <td class="align-middle text-center"><b>00'.$folio.'</b></td>
        <td class="align-middle text-center">'.$Estacion.'</td>
        <td class="align-middle text-center">'.$fechallegada.', '.$horallegada.'</td>
        <td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="Detalle('.$id.')"></td>
        <td class="align-middle text-center" onclick="PDF('.$id.')"><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></td>
        </tr>';

  }
  }else{
  echo "<tr><td colspan='5' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
  }
  ?>

  </tbody>

  </table>
  </div>

  </div>

  </div>
  </div>
  </div>
  </div>

  </div>

  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
