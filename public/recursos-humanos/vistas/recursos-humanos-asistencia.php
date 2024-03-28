<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}
   
function ValAsistencia($con){
 
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
  ON op_rh_personal_asistencia.id_personal = op_rh_personal.id WHERE op_rh_personal_asistencia.incidencia = 0";
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
 
 ValAsistencia($con);

//------------------------------------------------------------
/*
ValidaAsistencia(7,$con);
ValidaAsistencia(9,$con);

function ValidaAsistencia($idEstacion,$con){

$sql_personal = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_personal.curp,
op_rh_personal.sd,
op_rh_puestos.puesto,
op_rh_personal.documentos,
op_rh_personal.estado
FROM op_rh_personal
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.id ASC ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);

while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){

$idPersonal = $row_personal['id'];

for ($i = 1; $i <= 20; $i++) {

$fecha = '2022-09-'.$i;
$nombreDias = nombreDia($fecha);

$BuscarHorario = BuscarHorario($idPersonal,$nombreDias,$con);

AgregarAsistencia($idEstacion,$idPersonal,$fecha,$BuscarHorario['horaentrada'],$BuscarHorario['horasalida'],$con);

}
}
}

function BuscarHorario($idPersonal,$nombreDias,$con){

$sql = "SELECT * FROM op_rh_personal_horario WHERE id_personal = '".$idPersonal."' AND dia = '".$nombreDias."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$horaentrada = $row['hora_entrada'];
$horasalida = $row['hora_salida'];
}

$array = array('horaentrada' => $horaentrada, 'horasalida' => $horasalida);

return $array;
}

function AgregarAsistencia($idEstacion,$idPersonal,$fecha,$horaentrada,$horasalida,$con){

$sql = "SELECT * FROM op_rh_personal_asistencia WHERE id_personal = '".$idPersonal."' AND fecha = '".$fecha."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

if($numero == 0){

$Salario = Salario($idPersonal,$con);
$Retardo = Retardo($idEstacion,$con);
$Incidencias = Incidencias($idEstacion,$con);

$sql_insert = "INSERT INTO op_rh_personal_asistencia (
                    id_estacion,
                    id_personal,
                    fecha,
                    hora_entrada,
                    hora_salida,
                    hora_entrada_sensor,
                    hora_salida_sensor,
                    retardo_minutos,
                    incidencia_dias,
                    incidencia,
                    sd) 
                    VALUES (                    
                    '".$idEstacion."',
                    '".$idPersonal."', 
                    '".$fecha."', 
                    '".$horaentrada."', 
                    '".$horasalida."',
                    '', 
                    '',
                    '".$Retardo."',
                    '".$Incidencias."',
                    0,
                    '".$Salario."')";                                    
                    
                    mysqli_query($con, $sql_insert);

}
}

    function Retardo($idEmpresa,$con){

        $sql = "SELECT retardo FROM op_rh_localidades_retardo_incidencia WHERE id_estacion = '".$idEmpresa."' LIMIT 1 ";
        $result = mysqli_query($con, $sql);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $return = $row['retardo'];
        }

        return $return;
    }

    function Incidencias($idEmpresa,$con){


        $sql = "SELECT incidencia FROM op_rh_localidades_retardo_incidencia WHERE id_estacion = '".$idEmpresa."' LIMIT 1 ";
        $result = mysqli_query($con, $sql);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $return = $row['incidencia'];
        }

        return $return;
    }

function Salario($id,$con){

$sql_incidencia = "SELECT id, sd FROM op_rh_personal WHERE id = '".$id."' ORDER BY id DESC LIMIT 1 ";
            $result_incidencia = mysqli_query($con, $sql_incidencia);
            $numero_incidencia = mysqli_num_rows($result_incidencia);  
            while($row_incidencia = mysqli_fetch_array($result_incidencia, MYSQLI_ASSOC)){
            $salario = $row_incidencia['sd'];
            }

            return $salario;  
            }


//-------------------------------------------------------------------------
//-------------------------------------------------------------------------
*/
//Estacion, Año, Mes, Uno, Dos, Encargado turno
//ValidaAsistencia(1,2022,9,  1,2,3,    1, 2,$con);
//ValidaAsistencia(1,2022,8,  3,1,2,    2, 1,$con);

function ValidaAsistencia($idEstacion,$year,$mes,$TN1,$TN2,$TN3,$TE1,$TE2,$con){
$ultimodia = date('t',mktime(0,0,0,$mes,1,$year));
$sql_personal = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_personal.curp,
op_rh_personal.sd,
op_rh_puestos.puesto,
op_rh_personal.documentos,
op_rh_personal.estado
FROM op_rh_personal
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.id ASC ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);
$Mitad = ceil($numero_personal / 3);
$num = 1;

while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){

$idPersonal = $row_personal['id'];

for ($i = 1; $i <= $ultimodia; $i++) {

$fecha = $year.'-'.$mes.'-'.$i;

if($idPersonal == 32 || $idPersonal == 35){

if($idPersonal == 32){
$BuscarHorario = BuscarHorario($idPersonal,$TE1,$fecha,$con); 
}else if($idPersonal == 35){
$BuscarHorario = BuscarHorario($idPersonal,$TE2,$fecha,$con); 
}

}else{

if($num <= ($Mitad * 1)){
$BuscarHorario = BuscarHorario($idPersonal,$TN1,$fecha,$con);
}else if($num <= ($Mitad * 2)){
$BuscarHorario = BuscarHorario($idPersonal,$TN2,$fecha,$con); 
}else if($num <= ($Mitad * 3)){
$BuscarHorario = BuscarHorario($idPersonal,$TN3,$fecha,$con); 
}

}
 
if($idPersonal != 326 || $idPersonal != 387 || $idPersonal != 358 || $idPersonal != 296 || $idPersonal != 326 || $idPersonal != 300 || $idPersonal != 335){
AgregarAsistencia($idEstacion,$idPersonal,$fecha,
  $BuscarHorario['horaentrada'],
  $BuscarHorario['horasalida'],
  $BuscarHorario['horaentradaS'],
  $BuscarHorario['horasalidaS'],
  $con);
}

}


$num = $num + 1;
}
}

function BuscarHorario($idPersonal,$tipo,$fecha,$con){

$Descando = Descando($idPersonal,$con);
$NomDia = get_nombre_dia($fecha);
$rand1 = mt_rand(0, 20);
$rand2 = mt_rand(0, 59);
$rand3 = mt_rand(0, 20);
$rand4 = mt_rand(0, 59);
$rand5 = mt_rand(0, 20);
$rand6 = mt_rand(0, 59);
$rand7 = mt_rand(0, 20);
$rand8 = mt_rand(0, 59);
$rand9 = mt_rand(0, 20);
$rand10 = mt_rand(0, 59);
$rand11 = mt_rand(0, 20);
$rand12 = mt_rand(0, 59);


if($Descando == $NomDia){

$array = array('horaentrada' => '00:00:00', 
               'horasalida' => '00:00:00',
               'horaentradaS' => '00:00:00', 
               'horasalidaS' => '00:00:00');

}else{

if($tipo == 1){
$array = array('horaentrada' => '06:00:00', 
               'horasalida' => '15:00:00',
               'horaentradaS' => '06:'.$rand1.':'.$rand2, 
               'horasalidaS' => '15:'.$rand3.':'.$rand4);
}else if($tipo == 2){
$array = array('horaentrada' => '15:00:00', 
               'horasalida' => '23:00:00',
               'horaentradaS' => '15:'.$rand5.':'.$rand6, 
               'horasalidaS' => '23:'.$rand7.':'.$rand8);
}else if($tipo == 3){
$array = array('horaentrada' => '23:00:00', 
               'horasalida' => '06:00:00',
               'horaentradaS' => '23:'.$rand9.':'.$rand10, 
               'horasalidaS' => '06:'.$rand11.':'.$rand12);
}

}
return $array;
}

function AgregarAsistencia($idEstacion,$idPersonal,$fecha,$horaentrada,$horasalida,$horaentradaS,$horasalidaS,$con){

$sql = "SELECT * FROM op_rh_personal_asistencia WHERE id_personal = '".$idPersonal."' AND fecha = '".$fecha."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

if($numero == 0){

  
$sql_insert = "INSERT INTO op_rh_personal_asistencia (
                    id_estacion,
                    id_personal,
                    fecha,
                    hora_entrada,
                    hora_salida,
                    hora_entrada_sensor,
                    hora_salida_sensor,
                    retardo_minutos,
                    incidencia_dias,
                    incidencia,
                    sd) 
                    VALUES (                    
                    '".$idEstacion."',
                    '".$idPersonal."', 
                    '".$fecha."', 
                    '".$horaentrada."', 
                    '".$horasalida."',
                    '".$horaentradaS."', 
                    '".$horasalidaS."',
                    '30',
                    '3',
                    0,
                    0)";                                    
                    

  mysqli_query($con, $sql_insert);

}
}
 
function Descando($idPersonal,$con){

        $sql = "SELECT documentos FROM op_rh_personal WHERE id = '".$idPersonal."' LIMIT 1 ";
        $result = mysqli_query($con, $sql);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $return = $row['documentos'];
        }

        return $return;
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
  <link href="<?=RUTA_CSS2;?>navbar-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <script src="<?=RUTA_JS?>size-window.js"></script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
 
  <style media="screen">
  .decorado:hover {
  text-decoration: none;
  }
  </style>

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow();

  if(sessionStorage){
    if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {

      idestacion = sessionStorage.getItem('idestacion');
      $('#ListaAsistencia').load('public/recursos-humanos/vistas/contenido-recursos-humanos-asistencia.php?idEstacion=' + idestacion);
          
    } 
      
    }
 
    });  

    function Regresar(){
    sessionStorage.removeItem('idestacion');
    window.history.back();
    }


    function Configuracion(){window.location.href = "recursos-humanos-configuracion";}


    function SelEstacion(idEstacion){
    sizeWindow();  
    sessionStorage.setItem('idestacion', idEstacion);
    $('#ListaAsistencia').load('public/recursos-humanos/vistas/contenido-recursos-humanos-asistencia.php?idEstacion=' + idEstacion);
  }

    function SelEstacionReturn(idEstacion){
    sessionStorage.setItem('idestacion', idEstacion);
    $('#ListaAsistencia').load('public/recursos-humanos/vistas/contenido-recursos-humanos-asistencia.php?idEstacion=' + idEstacion);
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
sizeWindow()
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
//---------------------------------------------------------------------
//---------------------------------------------------------------------
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
//$('#ListaAsistencia').load('public/recursos-humanos/vistas/contenido-recursos-humanos-reporte-asistencia.php?idEstacion=' + idEstacion + '&Year=' + Year + '&Mes=' + Mes);
$('#ListaAsistencia').load('public/recursos-humanos/vistas/contenido-recursos-humanos-reporte-asistencia-v2.php?idEstacion=' + idEstacion + '&Year=' + Year + '&Mes=' + Mes + '&Val=1');        



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
  

  <!---------- CONTENIDO Y BARRA DE NAVEGACION ---------->
 <div class="wrapper"> 
  <!---------- BARRA DE NAVEGACION ---------->
  <nav id="sidebar">
          
  <div class="sidebar-header text-center">
  <img class="" src="<?=RUTA_IMG_LOGOS."Logo.png";?>" style="width: 100%;">
  </div>

    <ul class="list-unstyled components">
   
    <li>
    <a class="pointer" href="<?=SERVIDOR_ADMIN?>">
    <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i>Menu
    </a>
    </li>

    <li>
    <a class="pointer" onclick="Regresar()">
    <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
    </a>
    </li>

    <li>
    <a class="pointer" onclick="Configuracion()">
    <i class="fa-solid fa-gear" aria-hidden="true" style="padding-right: 10px;"></i><b>Configuración</b>
    </a>
    </li>
 
  <?php

  $FInicio = date("Y").'-'.date("m").'-01';
  $FTermino = date("Y-m-t", strtotime($FInicio));

  $sql_listaestacion = "SELECT id, numlista, localidad FROM op_rh_localidades WHERE numlista <= 10 ORDER BY numlista ASC";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);
  while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
  $id = $row_listaestacion['id'];
  $estacion = $row_listaestacion['localidad'];


if($estacion == "Comodines"){
 $icon = "fa-solid fa-users";

}else if($estacion == "Autolavado"){
 $icon = "fa-solid fa-car";

}else if($estacion == "Almacen"){
$icon = "fa-sharp fa-solid fa-shop";

}else if($estacion == "Directivos"){
$icon = " fa-solid fa-user-tie"; 

}else if($estacion == "Servicio Profesionales Operación Servicio y Mantenimiento de Personal"){
$icon = "fa-solid fa-screwdriver-wrench";

}else if($estacion == "Dirección de operaciones" ||
 $estacion == "Departamento Gestión" ||
 $estacion == "Departamento Jurídico" ||
 $estacion == "Departamento Mantenimiento" ||
 $estacion == "Departamento Sistemas"){
   $icon = "fa-solid fa-briefcase"; 


}else{
 $icon = "fa-solid fa-gas-pump";    
}

  if($id <> 8){
  echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.')">
    <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
}
  
  }
  ?> 
</ul>
</nav>

  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
 <nav class="navbar navbar-expand navbar-light navbar-bg" >
  
  <i class="fa-solid fa-bars menu-btn rounded pointer" 
  id="sidebarCollapse"></i>

  <div class="pointer">
  <a class="text-dark" onclick="history.back()">Recursos humanos asistencia</a>
  </div>
 
   
  <div class="navbar-collapse collapse">

  <div class="dropdown-divider"></div>

  <ul class="navbar-nav navbar-align">

  <li class="nav-item dropdown">
  <a class=" dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
  <i class="align-middle" data-feather="settings"></i>
  </a>

 
  <a class="nav-link dropdown-toggle d-none d-sm-inline-block pointer" data-bs-toggle="dropdown">
  
  <img src="<?=RUTA_IMG_ICONOS."usuarioBar.png";?>" class="avatar img-fluid rounded-circle"/>

  <span class="text-dark" style="padding-left: 10px;">
  <?=$session_nompuesto;?>  
  </span>
  </a>
  
  <div class="dropdown-menu dropdown-menu-end">
  
  <div class="user-box">

  <div class="u-text">
  <p class="text-muted">Nombre de usuario:</p>
  <h4><?=$session_nomusuario;?></h4>
  </div>

  </div>

 
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=PERFIL_ADMIN?>">
  <i class="fa-solid fa-user" style="padding-right: 5px;"></i>Perfil
  </a>
 
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=RUTA_SALIR2?>salir">
  <i class="fa-solid fa-power-off" style="padding-right: 5px;"></i> Cerrar Sesión
  </a>

  </div>
  </li>
  
  </ul>
  </div>

  </nav>
 
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">  
  
  <div class="col-12 mb-3">
  <div id="ListaAsistencia" class="cardAG"></div>
  </div> 

  </div>
  </div> 

  </div>

</div>


<div class="modal" id="ModalIncidencias" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog" style="margin-top: 83px;">
<div class="modal-content border-0 rounded-0" >
<div id="ContenidoModal"></div>
</div>
</div>
</div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>


</body>
</html>