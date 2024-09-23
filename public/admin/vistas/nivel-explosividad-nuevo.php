<?php
require('app/help.php');

$sql = "SELECT id_estacion FROM op_nivel_explosividad WHERE id = '".$GET_idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$idEstacion = $row['id_estacion'];  
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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

<script type="text/javascript" src="<?php echo RUTA_JS ?>signature_pad.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" ></script>
   <link rel="stylesheet" href="<?php echo RUTA_CSS ?>selectize.css">
 

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  DetallePozo(<?=$GET_idReporte;?>);
  });
 

  function DetallePozo(idReporte){
  $('#DetallePozo').load('../../public/admin/vistas/lista-nivel-explosividad-pozo.php?idReporte=' + idReporte);  
  } 

  function ModalPozo(idReporte){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('../../public/admin/vistas/modal-pozo-motobombas.php?idReporte=' + idReporte); 
  } 

  function GuardarPozo(idReporte){

  var PozoMotobomba = $('#PozoMotobomba').val();
  var PPM = $('#PPM').val();
  var Ubicacion = $('#Ubicacion').val();

    var parametros = {
    "idReporte" : idReporte,
    "PozoMotobomba" : PozoMotobomba,
    "PPM" : PPM,
    "Ubicacion" : Ubicacion
    };


  if (PozoMotobomba != "") {
  $('#PozoMotobomba').css('border', '');

  if (PPM != "") {
  $('#PPM').css('border', '');

    $.ajax({
     data:  parametros,
     url:   '../../public/admin/modelo/agregar-pozo-motobombas.php',
     type:  'post',
     beforeSend: function() {
    $(".LoaderPage").show();
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {

    $(".LoaderPage").hide();
    $('#Modal').modal('hide');
    DetallePozo(idReporte)
    alertify.success('Registro agregado exitosamente')

    }else{
    alertify.error('Error al agregar')
    $(".LoaderPage").hide();

    }

     }
     });

    } else {
  $('#PPM').css('border', '2px solid #A52525');
  }

} else {
  $('#PozoMotobomba').css('border', '2px solid #A52525');
  }


}

function Eliminar(idReporte,idNivel){
  
  var parametros = {
      "idReporte" : idReporte,
      "idNivel" : idNivel
      };
      $.ajax({
     data:  parametros,
     url:   '../../public/admin/modelo/eliminar-pozo-motobombas.php',
     type:  'post',
     beforeSend: function() {

     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {

   DetallePozo(idReporte)
    alertify.success('Registro eliminado exitosamente.')


    }else{
    alertify.error('Error al eliminar.')
    $(".LoaderPage").hide();

    }

     }
     });

}

  function Guardar(idReporte){

  var Fecha = $('#Fecha').val();
  var Elemento1 = $('#Elemento1').val();
  var Elemento2 = $('#Elemento2').val();
  var Elemento3 = $('#Elemento3').val();
  var Elemento4 = $('#Elemento4').val();
  var Elemento5 = $('#Elemento5').val();
  var Elemento6 = $('#Elemento6').val();
  var Elemento7 = $('#Elemento7').val();
  var Elemento8 = $('#Elemento8').val();
  var Elemento9 = $('#Elemento9').val();
  var Elemento10 = $('#Elemento10').val();
  var Elemento11 = $('#Elemento11').val();
  var Elemento12 = $('#Elemento12').val();
  var Elemento13 = $('#Elemento13').val();
  var Elemento14 = $('#Elemento14').val();
  var Elemento15 = $('#Elemento15').val();
  var Elemento16 = $('#Elemento16').val();
  var Elemento17 = $('#Elemento17').val();
  var Elemento18 = $('#Elemento18').val();
  var Observaciones = $('#Observaciones').val();
  var Encargado = $('#Encargado').val();

  var baseImage1 = "";
  var baseImage2 = "";



  let signatureBlank1 = signaturePad1.isEmpty();
  if (!signatureBlank1) {
  var ctx1 = document.getElementById("canvas1");
  var image1 = ctx1.toDataURL();
  document.getElementById('baseImage1').value = image1;
  baseImage1 = $('#baseImage1').val();  
  $('#canvas1').css('border','0px solid black');
  }else{
  $('#canvas1').css('border','2px solid #A52525'); 
  baseImage1 = ""; 
  }

  let signatureBlank2 = signaturePad2.isEmpty();
  if (!signatureBlank2) {
  var ctx2 = document.getElementById("canvas2");
  var image2 = ctx2.toDataURL();
  document.getElementById('baseImage2').value = image2;
  baseImage2 = $('#baseImage2').val();
  $('#canvas2').css('border','0px solid black');
  }else{
  $('#canvas2').css('border','2px solid #A52525');
  baseImage2 = "";   
  }

  var data = new FormData();
  var url = '../../public/admin/modelo/guardar-nivel-explosividad.php';

  if(Fecha != ""){
  $('#Fecha').css('border','');

  if (Elemento1 != "") {
  $('#Elemento1').css('border', '');
  if (Elemento2 != "") {
  $('#Elemento2').css('border', '');
  if (Elemento3 != "") {
  $('#Elemento3').css('border', '');
  if(Encargado != ""){
  $('#Encargado').css('border','');
  if(baseImage1 != ""){
  $('#canvas1').css('border','0px solid black'); 
  if(baseImage2 != ""){
  $('#canvas2').css('border','0px solid black');

  data.append('idReporte', idReporte);
  data.append('Fecha', Fecha);
  data.append('Elemento1', Elemento1);
  data.append('Elemento2', Elemento2);
  data.append('Elemento3', Elemento3);
  data.append('Elemento4', Elemento4);
  data.append('Elemento5', Elemento5);
  data.append('Elemento6', Elemento6);
  data.append('Elemento7', Elemento7);
  data.append('Elemento8', Elemento8);
  data.append('Elemento9', Elemento9);
  data.append('Elemento10', Elemento10);
  data.append('Elemento11', Elemento11);
  data.append('Elemento12', Elemento12);
  data.append('Elemento13', Elemento13);
  data.append('Elemento14', Elemento14);
  data.append('Elemento15', Elemento15);
  data.append('Elemento16', Elemento16);
  data.append('Elemento17', Elemento17);
  data.append('Elemento18', Elemento18);
  data.append('Observaciones', Observaciones);
  data.append('Encargado', Encargado);
  data.append('baseImage1', baseImage1);
  data.append('baseImage2', baseImage2);

  $(".LoaderPage").show();

  $.ajax({
  url: url,
  type: 'POST',
  contentType: false,
  data: data,
  processData: false,
  cache: false
  }).done(function(data){

  $(".LoaderPage").hide();
  if(data == 1){
  history.back();
  }
  
  });

  }else{ 
  alertify.error('Falta firma de quien tomo medición');
  }
  }else{ 
  alertify.error('Falta firma encargado de estación');
  }
  
  }else{
  $('#Encargado').css('border','2px solid #A52525'); 
  }


  }else{
  $('#Elemento3').css('border','2px solid #A52525'); 
  alertify.error('Falta seleccionar las observaciones.');
  }

  }else{
  $('#Elemento2').css('border','2px solid #A52525'); 
  alertify.error('Falta seleccionar el tipo de verificador.');
  }
  
  }else{
  $('#Elemento1').css('border','2px solid #A52525'); 
  alertify.error('Falta seleccionar el tipo de medición.');
  }

  }else{
  $('#Fecha').css('border','2px solid #A52525'); 
  alertify.error('Falta ingresar la fecha.');
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
  <div class="col-12 cardAG p-3 container">

  <div class="row">

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Nivel de explosividad</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Formulario Nivel de explosividad</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Formulario Nivel de explosividad</h3></div>
  </div>
  <hr>
  </div>

  <div class="col-12">
  <div class="row ">

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary mb-1 fw-bold">* FECHA:</label>
  <input type="date" class="form-control rounded-0" id="Fecha">
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary mb-1 fw-bold">* TIPO DE MEDICION</label>
  <select class="form-select rounded-0" id="Elemento1">
    <option></option>
    <option>Mantenimiento</option>
    <option>Extraordinaria</option>
  </select>
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary mb-1 fw-bold">VERIFICADOR</label>
  <select class="form-select rounded-0" id="Elemento2">
    <option></option>
    <option>Interno</option>
    <option>Externo</option>
  </select>
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary mb-1 fw-bold">* OBSERVACIONES</label>
  <select class="form-select rounded-0" id="Elemento3">
    <option></option>
    <option>Urgentes SI</option>
    <option>Urgentes NO</option>
  </select>
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary mb-1">ESTACIONAMIENTO:</label>
  <input type="number" class="form-control rounded-0" id="Elemento4">
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary mb-1">LOCAL COMERCIAL:</label>
  <input type="number" class="form-control rounded-0" id="Elemento5">
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary ">OFICINAS:</label>
  <input type="number" class="form-control rounded-0" id="Elemento6">
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary mb-1">BODEGA LOCAL:</label>
  <input type="number" class="form-control rounded-0" id="Elemento7">
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary mb-1">BAÑOS EMPLEADOS:</label>
  <input type="number" class="form-control rounded-0" id="Elemento8">
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary mb-1">BODEGA DE ACEITES:</label>
  <input type="number" class="form-control rounded-0" id="Elemento9">
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary mb-1">BAÑOS HOMBRES:</label>
  <input type="number" class="form-control rounded-0" id="Elemento10">
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary mb-1">BAÑOS MUJERES:</label>
  <input type="number" class="form-control rounded-0" id="Elemento11">
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary mb-1">CCUARTO DE SUCIOS:</label>
  <input type="number" class="form-control rounded-0" id="Elemento12">
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary mb-1">CTO DE MAQUINAS:</label>
  <input type="number" class="form-control rounded-0" id="Elemento13">
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary mb-1">ZONA 1 DESPACHO:</label>
  <input type="number" class="form-control rounded-0" id="Elemento14">
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary mb-1">ZONA 2 DESPACHO:</label>
  <input type="number" class="form-control rounded-0" id="Elemento15">
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary mb-1">ZONA 3 DESPACHO:</label>
  <input type="number" class="form-control rounded-0" id="Elemento16">
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary mb-1">CTO DE ADITIVO:</label>
  <input type="number" class="form-control rounded-0" id="Elemento17">
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2">
  <label class="text-secondary mb-1">ZONA DE TANQUES:</label>
  <input type="number" class="form-control rounded-0" id="Elemento18">
  </div>

  </div>
  <hr>
  </div>

  <!---------- DETALLE DE PPM ---------->
  <div class="col-12">  <div id="DetallePozo"></div> </div>

  <!---------- OBSERVACIONES ---------->
  <div class="col-12">
  <div class="table-responsive">
  <table class="custom-table mt-2" style="font-size: 12.5px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">Observaciones</th> </tr>
  </thead>
  <tbody>
  <tr class="no-hover">
  <th class="align-middle text-center bg-light p-0"><textarea class="form-control rounded-0 border-0 bg-light" id="Observaciones" style="height: 150px;"></textarea></th>
  </tr>
  </tbody>
  </table>
  </div>
  <hr>
  </div>

  <!---------- FIRMAS ---------->
  <div class="col-12">
  <h5 class="text-secondary mb-2">Firmas:</h5>

  <div class="row">
      
  <div class="col-12 col-sm-6 mt-2 mb-1">
  <div class="table-responsive">
  <table class="custom-table mt-2" style="font-size: 12.5px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">FIRMA DE QUIEN TOMA MEDICIÓN</th> </tr>
  </thead>
  <tbody>
  <tr class="no-hover">
  <th class="align-middle text-center bg-light p-0 ">
    
  <div id="signature-pad-1" class="signature-pad">
  <div class="signature-pad--body">
  <canvas style="width: 100%; height: 205px; border: 0px black solid;" id="canvas1"></canvas>
  </div>
  </div>
  <input type="hidden" name="base64" value="" id="baseImage1">
  </th>
  </tr>

  <tr onclick="clear1()">
  <th class="align-middle bg-danger text-center text-white p-2">
  <i class="fa-solid fa-rotate-left"></i> Limpiar firma
  </th>
  </tr>

  </tbody>
  </table>
  </div>
  </div>

  <div class="col-12 col-sm-6 mt-2 mb-1">
  <div class="table-responsive">
  <table class="custom-table mt-2" style="font-size: 12.5px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">NOMBRE Y FIRMA POR LA ESTACIÓN</th> </tr>
  </thead>

  <tbody class="bg-light">

  <tr>
  <th class="no-hover2 p-0">
  <select class="form-select rounded-0 border-0 bg-light" id="Encargado">
  <option value="">Selecciona una opción...</option>
  <?php 
  $sql_lista = "SELECT id, nombre FROM tb_usuarios WHERE id_gas = '".$idEstacion."' AND id_puesto = 6 AND estatus = 0 ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
  echo '<option value="'.$row_lista['id'].'">'.$row_lista['nombre'].'</option>';
  }
  ?>
  </select>
  </th>
  </tr>

  <tr>
  <th class="align-middle text-center bg-light p-0 ">
  <div id="signature-pad-2" class="signature-pad" >
  <div class="signature-pad--body">
  <canvas style="width: 100%; height: 165px; border: 0px black solid; " id="canvas2"></canvas>
  </div>
  </div>
  <input type="hidden" name="base64" value="" id="baseImage2">
  </th>
  </tr>

  <tr onclick="clear2()">
  <th class="align-middle bg-danger text-center text-white p-2">
  <i class="fa-solid fa-rotate-left"></i> Limpiar firma
  </th>
  </tr>

  </tbody>
  </table>
  </div>
  </div>

  </div>
  <hr>
  </div>




  <div class="col-12">
  <button type="button" class="btn btn-labeled2 btn-success float-end" onclick="Guardar(<?=$GET_idReporte;?>)">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
  </div>

  </div>
  </div>

  </div>



<div class="modal" id="Modal">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div id="ContenidoModal"></div>    
</div>
</div>
</div>

<script type="text/javascript">

var wrapper1 = document.getElementById("signature-pad-1"),
    canvas1 = wrapper1.querySelector("canvas"),
    signaturePad

var wrapper2 = document.getElementById("signature-pad-2"),
    canvas2 = wrapper2.querySelector("canvas"),
    signaturePad2;

function resizeCanvas(canvas) {
    var ratio =  window.devicePixelRatio || 1;
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}

resizeCanvas(canvas1);
signaturePad1 = new SignaturePad(canvas1);

resizeCanvas(canvas2);
signaturePad2 = new SignaturePad(canvas2);

function clear1() {
    signaturePad1.clear();
    document.getElementById('baseImage1').value = "";
}

function clear2() {
    signaturePad2.clear();
    document.getElementById('baseImage2').value = "";
}
</script>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>

