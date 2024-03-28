<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL.""); 
}


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
  $('#Mensaje').html('');


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
    $('#Mensaje').html('¡La refacción no tiene piezas suficientes!');    
    }else if(data == 3){
    $(".LoaderPage").hide();
    $('#DivCheck').css('border','2px solid #A52525'); 
    $('#Mensaje').html('¡Falta seleccionar la opción!');    
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

     <h5>Agregar transacción</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

 
<div class="row">


  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
    
  <h6>Estación proveedora:</h6>
 <?=$estacion;?>

 <h6 class="mt-3">Refacción que sale:</h6>
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

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
 <h6>Estación receptora:</h6>
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

 <h6 class="mt-3">Refacción que entra:</h6>
 <div id="RefaccionEntrada">
 <select class="form-select rounded-0"></select>
 </div>

<h6 class="mt-3">Observación y/o motivo:</h6>
<textarea class="form-control rounded-0" id="Observaciones"></textarea>


 <div id="DivCheck" class="mt-3"><input type="checkbox" id="CheckAgregarR"> <b>Agregar refacción a la lista</b></div>
 <hr>
          <div class="col-12 mb-2">  
          <div class="mb-2 text-secondary ">
<h6 class="mt-3">Realizo responsable de almacén:</h6>

          </div>
          <div id="signature-pad" class="signature-pad mt-2" >
          <div class="signature-pad--body">
          <canvas style="width: 100%; height: 150px; border: 1px black solid;" id="canvas"></canvas>
          </div>
          <input type="hidden" name="base64" value="" id="base64">
          </div> 
          <div class="text-end mt-2">
          <button class="btn btn-info btn-md text-white" onclick="resizeCanvas()"><small>Limpiar</small></button>
          </div>
          </div>

          <div id="Mensaje" class="text-center text-danger"></div>

  </div>


</div>

<hr>

<div class="text-end">
<button type="button" class="btn btn-primary mt-2 " onclick="Guardar(<?=$GET_idReporte;?>)">Guardar</button>
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

