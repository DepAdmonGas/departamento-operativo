<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

function ValAsistencia($IDEstacion,$con){
 
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
  ON op_rh_personal_asistencia.id_personal = op_rh_personal.id WHERE op_rh_personal.id_estacion = '".$IDEstacion."' AND op_rh_personal_asistencia.incidencia = 0";
  $result_asistencia = mysqli_query($con, $sql_asistencia);
  $numero_asistencia = mysqli_num_rows($result_asistencia);
  if ($numero_asistencia > 0) {
  while($row_asistencia = mysqli_fetch_array($result_asistencia, MYSQLI_ASSOC)){

  $id = $row_asistencia['id'];
  $fecha = $row_asistencia['fecha'];
  $hora_entrada = $row_asistencia['hora_entrada'];
  $hora_salida = $row_asistencia['hora_salida'];
  $hora_entrada_sensor = $row_asistencia['hora_entrada_sensor'];
  $hora_salida_sensor = $row_asistencia['hora_salida_sensor'];
  $retardominutos = $row_asistencia['retardo_minutos'];

   if($hora_entrada == "00:00:00" && $hora_salida == "00:00:00"){
   if($hora_entrada_sensor != "00:00:00" && $hora_salida_sensor == "00:00:00"){
   $resultado = "Día trabajado";  
   $idIncidencia = BuscarIncidencias($resultado,$con);
   EditIncidencias($id,$idIncidencia,$con);
   }else if($hora_entrada_sensor != "00:00:00" && $hora_salida_sensor != "00:00:00"){
   $resultado = "Día trabajado";  
   $idIncidencia = BuscarIncidencias($resultado,$con);
   EditIncidencias($id,$idIncidencia,$con);
   }else if($hora_entrada == "00:00:00" && $hora_salida == "00:00:00" && $hora_entrada_sensor == "00:00:00" && $hora_salida_sensor == "00:00:00"){
   $resultado = "Descanso";
   $idIncidencia = BuscarIncidencias($resultado,$con);
   EditIncidencias($id,$idIncidencia,$con);
   }
   }else{
   
   if($hora_entrada_sensor != "00:00:00" || $hora_salida_sensor != "00:00:00"){

   $ts_fin = strtotime($hora_entrada_sensor);
   $ts_ini = strtotime($hora_entrada);
   $diferencia = ($ts_fin-$ts_ini);

   if(is_numeric($diferencia) AND ($diferencia < 0) ){
   $resultado = "OK";
   $idIncidencia = BuscarIncidencias($resultado,$con);
   EditIncidencias($id,$idIncidencia,$con);
   }else{

   $retardo = $retardominutos * 60;
   $horainicio = $ts_ini + $retardo;

   if($horainicio < $ts_fin){
   $resultado = "Retardo";
   $idIncidencia = BuscarIncidencias($resultado,$con);
   EditIncidencias($id,$idIncidencia,$con);
   }else{
   $resultado = "OK";
   $idIncidencia = BuscarIncidencias($resultado,$con);
   EditIncidencias($id,$idIncidencia,$con);
   }

   }

   }else{

   if(nombreDia($fecha) == "Sábado" || nombreDia($fecha) == "Domingo"){
   $resultado = "Falta fin de semana";  
   }else{
   $resultado = "Falta";  
   }
   
   $idIncidencia = BuscarIncidencias($resultado,$con);
   EditIncidencias($id,$idIncidencia,$con); 
   }
   }
   }
   }
}

  function BuscarIncidencias($incidencia,$con){
    $sql = "SELECT * FROM op_rh_lista_incidencias
       WHERE detalle = '".$incidencia."' ";
    $result = mysqli_query($con, $sql);
    $numero = mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $id = $row['id'];
    }
    return $id;
  }

  function EditIncidencias($id,$idIncidencia,$con){

    $sql_edit = "UPDATE op_rh_personal_asistencia SET 
    incidencia = '".$idIncidencia."'
    WHERE id = '".$id."'  ";
    if(mysqli_query($con, $sql_edit)) {
    $result = true;
    }else{
    $result = false;
    }

  return $result;

  }
 
 ValAsistencia($Session_IDEstacion,$con);
 
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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  SelEstacion(<?=$Session_IDEstacion;?>)
 
  }); 

  function Regresar(){
  sessionStorage.removeItem('idestacion');
  window.history.back();
  }

  function ConfiguracionEstacion(){window.location.href = "recursos-humanos-estacion-configuracion";}


  function SelEstacion(idEstacion){
  sessionStorage.setItem('idestacion', idEstacion);
  $('#ListaAsistencia').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-asistencia.php?idEstacion=' + idEstacion);
  
  }  

  function SelEstacionReturn(idEstacion){
  sessionStorage.setItem('idestacion', idEstacion);
  $('#ListaAsistencia').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-asistencia.php?idEstacion=' + idEstacion);
  }
 
function ModalDetalleI(idPersonal,id,idEstacion){
$('#ModalIncidencias').modal('show');
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-incidencias.php?idAsistencia=' + id);  
}

function ModalIncidencias(idPersonal,id,idEstacion){
$('#ModalIncidencias').modal('show');
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-incidencias.php?idAsistencia=' + id + '&idPersonal=' + idPersonal + '&idEstacion=' + idEstacion); 
}

function GuardarIncidencia(idAsistencia,idEstacion){

var Comentario = $('#Comentario').val();

if(document.querySelector('input[name="CheckBox"]:checked')) {
var incidencia = document.querySelector('input[name="CheckBox"]:checked').value;
$('#bordercheck').css('border','');
if(Comentario != ""){
$('#Comentario').css('border','');

alertify.confirm('',
function(){

var parametros = {
"idAsistencia" : idAsistencia,
"incidencia" : incidencia,
"Comentario" : Comentario
};

$.ajax({
data:  parametros,
url:   'public/recursos-humanos/modelo/agregar-incidencia.php',
type:  'POST',
        
beforeSend: function() {
$(".LoaderPage").show();
},

complete: function(){
},

success:  function (response) {

if(response == 1){
$(".LoaderPage").hide();
$('#ModalIncidencias').modal('hide'); 
alertify.success('Se creo la incidencia');
SelEstacion(idEstacion)
}else{
$(".LoaderPage").hide();
alertify.error('Error al crear la incidencia');
}
 
}
});

},
function(){
}).setHeader('Agregar Incidencia').set({transition:'zoom',message: '¿Desea agregar incidenia?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}else{
$('#Comentario').css('border','2px solid #A52525');    
}
}else{
$('#bordercheck').css('border','2px solid #A52525'); 
}

}

function EditarSaldoTMR(idAsistencia){

var SueldoDiaTMR = $('#SueldoDiaTMR').val();

if(SueldoDiaTMR != ""){
$('#SueldoDiaTMR').css('border','');

alertify.confirm('',
function(){

var parametros = {
"idAsistencia" : idAsistencia,
"SueldoDiaTMR" : SueldoDiaTMR
};

$.ajax({
data:  parametros,
url:   'public/recursos-humanos/modelo/editar-sueldo-incidencia.php',
type:  'POST',
        
beforeSend: function() {
},
complete: function(){
},
success:  function (response) {

if(response == 1){

alertify.success('Se edito la incidencia');
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-incidencias.php?idAsistencia=' + idAsistencia); 

}else{
$(".LoaderPage").hide();
alertify.error('Error al editar la incidencia');
}
 
}
});

},
function(){
}).setHeader('Editar sueldo').set({transition:'zoom',message: '¿Desea editar el sueldo del día?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}else{
$('#SueldoDiaTMR').css('border','2px solid #A52525'); 
}

}

function GuardarDoc(idPersonal,idAsistencia,idEstacion){
var data = new FormData();
var url = 'public/recursos-humanos/modelo/agregar-documento-incidencia.php';

var FechaInicio = $('#FechaIni').val();
var FechaFin = $('#FechaFin').val();
var SueldoDiaI = $('#SueldoDiaI').val();

var Documento = document.getElementById("Documento");
var Documento_file = Documento.files[0];
var Documento_filePath = Documento.value;
var Documento_ext = $("#Documento").val().split('.').pop();

if(Documento_ext == "pdf"){
if(FechaInicio < FechaFin){
$('#FechaFin').css('border',''); 

data.append('Documento_file', Documento_file);
data.append('idPersonal', idPersonal);
data.append('idAsistencia', idAsistencia);
data.append('idEstacion', idEstacion);
data.append('FechaInicio', FechaInicio);
data.append('FechaFin', FechaFin);
data.append('SueldoDiaI', SueldoDiaI);

$.ajax({
url: url,
type: 'POST',
contentType: false,
data: data,
processData: false,
cache: false
}).done(function(data){
 
if(data == 1){
alertify.success('Se agrego el documento');
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-incidencias.php?idAsistencia=' + idAsistencia); 
SelEstacion(idEstacion)
 
}else{
alertify.error('Error al agregar el documento');
}
 
});

}else{
$('#FechaFin').css('border','2px solid #A52525'); 
}
}else{
$('#Resultado').html('<div class="text-center text-danger"><small>El formato debe ser PDF</small></div>');
}


}
 
function ModalReporte(idEstacion){
$('#ModalIncidencias').modal('show');
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-reporte-asistencia.php?idEstacion=' + idEstacion); 
} 
 
function btnBuscar(idEstacion){


var Year = $('#Year').val();
var Mes = $('#Mes').val();

if(Year != ""){
$('#Year').css('border','');
if(Mes != ""){
$('#Mes').css('border','');

 
$('#ModalIncidencias').modal('hide');
$('#ListaAsistencia').load('public/recursos-humanos/vistas/contenido-recursos-humanos-reporte-asistencia.php?idEstacion=' + idEstacion + '&Year=' + Year + '&Mes=' + Mes);
 
}else{
$('#Mes').css('border','2px solid #A52525'); 
}
}else{
$('#Year').css('border','2px solid #A52525'); 
}

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
    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

     <h5>Recursos humanos asistencia</h5>
    
    </div> 
    </div>

    </div>

  <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">

    <button type="button" class="btn btn-outline-primary btn-sm float-end ms-2" onclick="ModalReporte(<?=$Session_IDEstacion;?>)">Reporte</button>
    <img class="float-start pointer float-end ms-2" src="<?=RUTA_IMG_ICONOS;?>configuracion-tb.png" onclick="ConfiguracionEstacion()">

  </div>

  </div>

  <hr>

<div id="ListaAsistencia"></div>
  

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>


<div class="modal" id="ModalIncidencias" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog" style="margin-top: 83px;">
<div class="modal-content border-0 rounded-0">
<div id="ContenidoModal"></div>
</div>
</div>
</div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>