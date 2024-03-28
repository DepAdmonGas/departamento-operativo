<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$sql = "SELECT nombre_completo FROM op_rh_personal WHERE id = '".$GET_idPersonal."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$personal = $row['nombre_completo'];
}
 
$sql_asistencia = "SELECT 
op_rh_personal_asistencia.id,
op_rh_personal_asistencia.id_personal,
op_rh_personal_asistencia.fecha,
op_rh_personal_asistencia.hora_entrada,
op_rh_personal_asistencia.hora_salida,
op_rh_personal_asistencia.hora_entrada_sensor,
op_rh_personal_asistencia.hora_salida_sensor,
op_rh_personal_asistencia.retardo_minutos,
op_rh_personal_asistencia.incidencia_dias,
op_rh_personal_asistencia.incidencia,
op_rh_personal_asistencia.sd,
op_rh_personal.nombre_completo,
op_rh_personal.id_estacion
FROM op_rh_personal_asistencia 
INNER JOIN op_rh_personal 
ON op_rh_personal_asistencia.id_personal = op_rh_personal.id
WHERE 
op_rh_personal_asistencia.id_personal = '".$GET_idPersonal."' AND 
YEAR(op_rh_personal_asistencia.fecha) = '".$fecha_year."' AND 
MONTH(op_rh_personal_asistencia.fecha) = '".$fecha_mes."' AND 
DAY(op_rh_personal_asistencia.fecha) <= '".$fecha_dia."'
ORDER BY hora_entrada, id desc  ";
$result_asistencia = mysqli_query($con, $sql_asistencia);
$numero_asistencia = mysqli_num_rows($result_asistencia);

    function Incidencias($id,$con){
    $sql = "SELECT * FROM op_rh_personal_asistencia_incidencia
     WHERE id_asistencia = '".$id."' ";
  $result = mysqli_query($con, $sql);
  return $numero = mysqli_num_rows($result);
    }

function Detalle($id,$fecha,$hora_entrada,$hora_salida,$hora_entrada_sensor,$hora_salida_sensor,$retardominutos,$con){

 if(Incidencias($id,$con) > 0){

 $resultado = DetalleIncidencia($id,$con);

 }else{

 if($hora_entrada == "00:00:00" && $hora_salida == "00:00:00"){
 if($hora_entrada_sensor != "00:00:00" && $hora_salida_sensor == "00:00:00"){
 $resultado = "Día trabajado";  
 EditIncidencias($id,$resultado,$con);
 }else if($hora_entrada_sensor != "00:00:00" && $hora_salida_sensor != "00:00:00"){
 $resultado = "Día trabajado";  
 EditIncidencias($id,$resultado,$con);
 }else if($hora_entrada == "00:00:00" && $hora_salida == "00:00:00" && $hora_entrada_sensor == "00:00:00" && $hora_salida_sensor == "00:00:00"){
 $resultado = "Descanso";

 EditIncidencias($id,$resultado,$con);
 }
 }else{
 
 if($hora_entrada_sensor != "00:00:00" || $hora_salida_sensor != "00:00:00"){

 $ts_fin = strtotime($hora_entrada_sensor);
 $ts_ini = strtotime($hora_entrada);
 $diferencia = ($ts_fin-$ts_ini);

 if(is_numeric($diferencia) AND ($diferencia < 0) ){
 $resultado = "OK";
 EditIncidencias($id,$resultado,$con);
 }else{

 $retardo = $retardominutos * 60;
 $horainicio = $ts_ini + $retardo;

 if($horainicio < $ts_fin){
 $resultado = "Retardo";
 EditIncidencias($id,$resultado,$con);
 }else{
 $resultado = "OK";
 EditIncidencias($id,$resultado,$con);
 }

 }

 }else{

 if(nombreDia($fecha) == "Sábado" || nombreDia($fecha) == "Domingo"){
 $resultado = "Falta fin de semana";  
 }else{
 $resultado = "Falta";  
 }
 
 EditIncidencias($id,$resultado,$con);  
 }

 }
 }

 return $resultado;
 }

  function DetalleIncidencia($id,$con){
  $sql_incidencia = "SELECT incidencia FROM op_rh_personal_asistencia_incidencia WHERE id_asistencia = '".$id."' ";
  $result_incidencia = mysqli_query($con, $sql_incidencia);
  $numero_incidencia = mysqli_num_rows($result_incidencia);
  while($row_incidencia = mysqli_fetch_array($result_incidencia, MYSQLI_ASSOC)){
  $incidencia = $row_incidencia['incidencia'];
  }

  return $incidencia;
  }

  function EditIncidencias($id,$resultado,$con){

  if($resultado == "OK" || $resultado == "Día trabajado" || $resultado == "Descanso"){

  if(Incidencias($id,$con) == 0){
  $sql_edit = "UPDATE op_rh_personal_asistencia SET 
  incidencia = 1
  WHERE id = '".$id."'  ";
  if(mysqli_query($con, $sql_edit)) {
  $result = 1;
  }else{
  $result = 0;
  }
    }

  }else{

  if(Incidencias($id,$con) == 0){

  $sql = "SELECT * FROM emp_lista_incidencias
     WHERE detalle = '".$resultado."' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result); 
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

  $sql_edit = "UPDATE op_rh_personal_asistencia SET 
  incidencia = '".$row['puntos']."'
  WHERE id = '".$id."'  ";

  if(mysqli_query($con, $sql_edit)) {
  $result = 1;
  }else{
  $result = 0;
  }

  }

  }
    }

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

 
  function ModalDetalleI(idPersonal,id,idEstacion){
$('#Modal').modal('show');
$('#ContenidoModal').load('../public/recursos-humanos/vistas/modal-detalle-incidencias.php?idAsistencia=' + id);  
}  

function ModalIncidencias(idPersonal,id,idEstacion){
$('#Modal').modal('show');
$('#ContenidoModal').load('../public/recursos-humanos/vistas/modal-agregar-incidencias.php?idAsistencia=' + id + '&idPersonal=' + idPersonal + '&idEstacion=' + idEstacion); 
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
    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

     <h5>Asistencia <?=$personal;?></h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

 <div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle">#</th>
  <th class="align-middle">Fecha</th>
  <th class="align-middle">Sistema (Entrada)</th>
  <th class="align-middle">Sistema (Salida)</th>
  <th class="align-middle">Sensor (Entrada)</th>
  <th class="align-middle">Sensor (Salida)</th>
  <th class="align-middle">Detalle</th>
  <th class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>incidencia-tb.png"></th>
  </tr>
</thead> 
<body>
<?php
  if ($numero_asistencia > 0) {
  while($row_asistencia = mysqli_fetch_array($result_asistencia, MYSQLI_ASSOC)){

    $id = $row_asistencia['id'];
    $idpersonal = $row_asistencia['id_personal'];
    $fecha = $row_asistencia['fecha'];
        $hora_entrada = $row_asistencia['hora_entrada'];
    $hora_entrada_sensor = $row_asistencia['hora_entrada_sensor'];
    $retardominutos = $row_asistencia['retardo_minutos'];
    $incidenciadias = $row_asistencia['incidencia_dias'];
    $incidencia = $row_asistencia['incidencia'];
    $ToIncidencia = $row_asistencia['incidencia_dias'];
    
    $status = $row_asistencia['status'];

    if($row_asistencia['hora_entrada'] == "00:00:00"){
    $horaentrada = "S/I"; 
    }else{
    $horaentrada = date("g:i a",strtotime($row_asistencia['hora_entrada']));
    }

    if($row_asistencia['hora_salida'] == "00:00:00"){
    $horasalida = "S/I";  
    }else{
    $horasalida = date("g:i a",strtotime($row_asistencia['hora_salida']));
    }

    if($row_asistencia['hora_entrada_sensor'] == "00:00:00"){
    $horaentradasensor = "S/I";
    }else{
    $horaentradasensor = date("g:i a",strtotime($row_asistencia['hora_entrada_sensor'])); 
    }
    if($row_asistencia['hora_salida_sensor'] == "00:00:00"){
    $horasalidasensor = "S/I";
    }else{
    $horasalidasensor = date("g:i a",strtotime($row_asistencia['hora_salida_sensor'])); 
    }

    //-------------------------------------------
    if($row_asistencia['hora_entrada'] == "00:00:00" && $row_asistencia['hora_salida'] == "00:00:00"){
         if($row_asistencia['hora_entrada_sensor'] != "00:00:00" && $row_asistencia['hora_salida_sensor'] == "00:00:00"){
     $colorTable = "table-success"; 
     $colorDetalle = "text-success";
     }else if($row_asistencia['hora_entrada_sensor'] != "00:00:00" && $row_asistencia['hora_salida_sensor'] != "00:00:00"){
     $colorTable = "table-success"; 
     $colorDetalle = "text-success";
     }else if($row_asistencia['hora_entrada'] == "00:00:00" && $row_asistencia['hora_salida'] == "00:00:00" && $row_asistencia['hora_entrada_sensor'] == "00:00:00" && $row_asistencia['hora_salida_sensor'] == "00:00:00"){
     $colorTable = "table-light";
     $colorDetalle = "text-secondary";
     }
     }else{

    if($row_asistencia['hora_entrada_sensor'] != "00:00:00" || $row_asistencia['hora_salida_sensor'] != "00:00:00"){
    $ts_fin = strtotime($hora_entrada_sensor);
    $ts_ini = strtotime($hora_entrada);

    $retardo = $retardominutos * 60;
    $horainicio = $ts_ini + $retardo;

    if($horainicio < $ts_fin){
    $colorTable = "table-warning";
    $colorDetalle = "text-warning";
    }else{
    $colorTable = "";
    $colorDetalle = "";
    }

    }else{
    $colorTable = "table-danger"; 
    $colorDetalle = "text-danger";
    }

    }
    //-------------------------------------------

    $fechaIncidencia = date("d-m-Y",strtotime($fecha."+ ".$ToIncidencia." days")); 
    if(strtotime($fechaIncidencia) < strtotime($fecha_del_dia)){
    $iconIncidencia = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'incidencia-tb.png" onclick="ModalDetalleI('.$idpersonal.','.$row_asistencia['id'].','.$idEstacion.')" />';
    
  }else{
    $iconIncidencia = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'incidencia-tb.png" onclick="ModalIncidencias('.$idpersonal.','.$row_asistencia['id'].','.$idEstacion.')" />';
    } 

      if(Incidencias($row_asistencia['id'],$con) > 0){
      $incidencia = '<small><span class="badge rounded-pill bg-info fw-light p-1"> </span></small>';
      }else{
      $incidencia = '';
      }
    

  echo '<tr class="'.$colorTable.'">
  <td class="align-middle fs-6 text-center fw-light"><b>'.$row_asistencia['id'].'</b></td>
  <td class="align-middle fs-6 font-weight-light"><b>'.FormatoFecha($fecha).'</b></td>
  <td class="align-middle fs-6 font-weight-light">'.$horaentrada.'</td>
  <td class="align-middle fs-6 font-weight-light">'.$horasalida.'</td>
  <td class="align-middle fs-6 font-weight-light"><b>'.$horaentradasensor.'</b></td>
  <td class="align-middle fs-6 font-weight-light"><b>'.$horasalidasensor.'</b></td>
  <td class="align-middle fs-6 font-weight-bold '.$colorDetalle.'">'.Detalle($row_asistencia['id'],$fecha,$row_asistencia['hora_entrada'],$row_asistencia['hora_salida'],$row_asistencia['hora_entrada_sensor'],$row_asistencia['hora_salida_sensor'],$retardominutos, $con).'</td>
  <td class="align-middle fs-6 text-center">'.$iconIncidencia.$incidencia.'</td>
  </tr>';

  }
  }else{
echo "<tr><td colspan='11'><div class='text-secondary text-center p-2 fs-6 fw-light'>No se encontró información para mostrar </div></td></tr>"; 
}
?>
</body>
</table>
</div>

     
  </div>
  </div>
  </div>

  </div>
  </div>

  </div>




  <div class="modal" id="Modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="ContenidoModal"></div>
      </div>
    </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>