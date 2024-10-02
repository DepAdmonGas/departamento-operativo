<?php
require('app/help.php');

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$GET_idReporte."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <script type="text/javascript" src="<?php echo RUTA_JS ?>signature_pad.js"></script>
  
  <script type="text/javascript">
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");


  });

  function Regresar(){
  window.history.back();
  } 

  function BuscarRER(){
  var idER = $('#idER').val();

    var parametros = {
    "idER" : idER
    };
    $.ajax({
    data:  parametros,
    url:   '../../public/admin/vistas/lista-refacciones-entra.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){
    },
    success:  function (response) {
    $('#RefaccionEntrada').html(response);
    }
    });

    }

    function Guardar(idEstacion){

    var ctx = document.getElementById("canvas");
    var image = ctx.toDataURL();
    document.getElementById('base64').value = image;

    var idRefacccion = $('#idRefacccion').val();
    var idEstacionR = $('#idER').val();
    var idRefaccionE = $('#RefaccionE').val();
    var base64 = $('#base64').val();
    var check = 0;
    var Observaciones = $('#Observaciones').val();

    var data = new FormData();
    var url = '../../public/admin/modelo/agregar-refaccion-transaccion.php';

    var isChecked = document.getElementById('CheckAgregarR').checked;
    if(isChecked){
    check = 1; 
    }else{
    check = 0;
    }

  if(idRefacccion != ""){
  $('#idRefacccion').css('border',''); 
  if(idEstacionR != ""){
  $('#idER').css('border',''); 
  if(signaturePad.isEmpty()){
  $('#canvas').css('border','2px solid #A52525'); 
  }else{
  $('#canvas').css('border','1px solid #000000'); 
  $('#DivCheck').css('border','');

  data.append('idEstacion', idEstacion);
  data.append('idRefacccion', idRefacccion);
  data.append('idEstacionR', idEstacionR);
  data.append('idRefaccionE', idRefaccionE);
  data.append('check', check);
  data.append('base64', base64);
  data.append('Observaciones', Observaciones);
  
    //$(".LoaderPage").show();

    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

    if(data == 1){
    Regresar();
    }else if(data == 2){
    $(".LoaderPage").hide();
    $('#idRefacccion').css('border','2px solid #A52525'); 
    alertify.warning('¡La refacción no tiene piezas suficientes!')      
    }else if(data == 3){
    $(".LoaderPage").hide();
    $('#DivCheck').css('border','2px solid #A52525'); 
    alertify.warning('¡Falta seleccionar la opción!');     

    }
     
    }); 

  }

  }else{
  $('#idER').css('border','2px solid #A52525'); 
  }
  }else{
  $('#idRefacccion').css('border','2px solid #A52525'); 
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
  <div class="contendAG container">
  <div class="row">

  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3">

  <div class="row"> 
  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Inventario</a></li>
  <li aria-current="page" class="breadcrumb-item active">FORMULARIO DE TRANSACCIÓN (<?= strtoupper($estacion)?>)</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Formulario de Transacción (<?=$estacion;?>)</h3>
  </div>

  </div>

  <hr> 
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
  <div class="text-secondary mb-1">ESTACIÓN PROVEEDORA:</div>
  <?=$estacion;?>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
  <div class="text-secondary fw-bold mb-1">* REFACCIÓN QUE SALE:</div>
  <select class="form-select rounded-0" id="idRefacccion">
  <option></option>
  <?php 
  $sqlRS = "SELECT * FROM op_refacciones WHERE id_estacion = '".$GET_idReporte."' AND status = 1 ORDER BY id ASC";
  $resultRS = mysqli_query($con, $sqlRS);
  $numeroRS = mysqli_num_rows($resultRS);
  while($rowRS = mysqli_fetch_array($resultRS, MYSQLI_ASSOC)){
  echo '<option value="'.$rowRS['id'].'">'.$rowRS['nombre'].'</option>';
  }
  ?>
  </select>
  </div>


  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
  <div class="text-secondary fw-bold mb-1">* ESTACIÓN RECEPTORA:</div>
  <select class="form-select rounded-0" id="idER" onchange="BuscarRER()">
  <option></option>
  <?php 
  $sqlEstacion = "SELECT id,localidad FROM op_rh_localidades WHERE numlista <= 8 ORDER BY numlista ASC ";
  $resultEstacion = mysqli_query($con, $sqlEstacion);
  while($rowEstacion = mysqli_fetch_array($resultEstacion, MYSQLI_ASSOC)){
  echo '<option value="'.$rowEstacion['id'].'">'.$rowEstacion['localidad'].'</option>';
  }
  ?>
  </select>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
  <div class="text-secondary fw-bold mb-1">* REFACCIÓN QUE ENTRA:</div>
  <div id="RefaccionEntrada">
  <select class="form-select rounded-0"></select>
  </div>
  </div>

  <div class="col-12 mb-3">
  <div class="text-secondary mb-1">OBSERVACIÓN Y/O MOTIVO:</div>
  <textarea class="form-control rounded-0" id="Observaciones"></textarea>
  </div>

  <div class="col-12">
  <div class="alert alert-primary" role="alert"> <div id="DivCheck"><input type="checkbox" id="CheckAgregarR"> <b class="ms-2">AGREGAR REFACCIÓN A LA LISTA</b></div></div>
  <hr>
  </div>
 

  <!---------- FIRMA ---------->
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">RESPONSABLE DE ALMACEN</th> </tr>
  </thead>
  <tbody>
  <tr>
  <th class="align-middle text-center p-0 no-hover2">          
  <div id="signature-pad" class="signature-pad ">
  <div class="signature-pad--body ">
  <canvas style="width: 100%; height: 150px; border-right: .1px solid #215d98; border-left: .1px solid #215d98; cursor: crosshair;" id="canvas"></canvas>
  </div>
  <input type="hidden" name="base64" value="" id="base64">
  </div> 
  </th>
  </tr>

  <tr>
  <th class="align-middle text-center p-2 bg-danger text-white" onclick="resizeCanvas()">  
  <i class="fa-solid fa-arrow-rotate-left"></i> LIMPIAR FIRMA
  </th>
  </tr>

  </tbody>
  </table>
  </div>


  <div class="col-12">
  <hr>
  <button type="button" class="btn btn-labeled2 btn-success float-end" onclick="Guardar(<?=$GET_idReporte;?>)">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
  </div>

  </div>

  
  </div>
  </div>
  </div>

  </div>
  </div>

  </div>


    <script type="text/javascript">

var wrapper = document.getElementById("signature-pad");

var canvas = wrapper.querySelector("canvas");
var signaturePad = new SignaturePad(canvas, {
  backgroundColor: 'rgb(255, 255, 255)'
});

function resizeCanvas() {

  var ratio =  Math.max(window.devicePixelRatio || 1, 1);

  canvas.width = canvas.offsetWidth * ratio;
  canvas.height = canvas.offsetHeight * ratio;
  canvas.getContext("2d").scale(ratio, ratio);

  signaturePad.clear();
}

window.onresize = resizeCanvas;
resizeCanvas();



 
</script>
   
  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>

