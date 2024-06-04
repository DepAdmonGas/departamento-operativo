<?php
require('app/help.php');

$datosUsuario = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($GET_idPersonal);
$nombrePersonal = $datosUsuario['nombre_personal'];
$puesto = $datosUsuario['puesto'];
$no_colaborador = $datosUsuario['no_colaborador'];
$fecha_ingreso = $datosUsuario['fecha_ingreso'];

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
  
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  });

  function BajaPersonal(idPersonal){

  let FechaBaja = $('#FechaBaja').val();
  let Motivo = $('#Motivo').val();
  let Detalle = $('#Detalle').val();
    
  ActaHechos = document.getElementById("ActaHechos");
  ActaHechos_file = ActaHechos.files[0];
  ActaHechos_filePath = ActaHechos.value;

  CartaRenuncia = document.getElementById("CartaRenuncia");
  CartaRenuncia_file = CartaRenuncia.files[0];
  CartaRenuncia_filePath = CartaRenuncia.value;

  ValFiniquito = document.getElementById("Finiquito");
  Finiquito_file = ValFiniquito.files[0];
  Finiquito_filePath = ValFiniquito.value;

  var data = new FormData();
  //var url = '../public/recursos-humanos/modelo/agregar-baja-personal.php';
  var url = '../app/controlador/2-recursos-humanos/controladorDocumentosPersonal.php';

  data.append('idPersonal', idPersonal);
  data.append('FechaBaja', FechaBaja);
  data.append('Motivo', Motivo);
  data.append('Detalle', Detalle);  
  data.append('ActaHechos_file', ActaHechos_file);
  data.append('CartaRenuncia_file', CartaRenuncia_file);
  data.append('Finiquito_file', Finiquito_file);
  data.append('Accion', 'agregar-baja-personal');
  
  if(FechaBaja != ""){
  $('#FechaBaja').css('border','');
  if(Motivo != ""){
  $('#Motivo').css('border','');    
  if(Detalle != ""){
  $('#Detalle').css('border','');

  $(".LoaderPage").show();

  $.ajax({
  url: url,
  type: 'POST',
  contentType: false,
  data: data,
  processData: false,
  cache: false
  }).done(function(result){
    
  console.log(result)

  if(result == 1){
  history.back();

  }else{
  $(".LoaderPage").hide();
  alertify.error('Error al dar de baja personal'); 
  }
  }); 
 
  }else{
  $('#Detalle').css('border','2px solid #A52525'); 
  }
  }else{
  $('#Motivo').css('border','2px solid #A52525'); 
  }
  }else{
  $('#FechaBaja').css('border','2px solid #A52525'); 
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
  <div class="bg-white p-3">

    
  <div class="row">

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Control de Documentos del Personal</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Baja de personal</li>
  </ol>
  </div>
   
  <div class="row"> 
  <div class="col-9"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Baja de personal</h3> </div>
  </div>

  <hr>
  </div>
  </div>

  
  <div class="row">
  
  <div class="col-12 col-md-4">
  <div class="text-secondary"><small>Fecha ingreso:</small></div>
  <div class="mt-1"><h6><?=FormatoFecha($fecha_ingreso);?></h6></div>
  </div>
  
  <div class="col-12 col-md-2">
  <div class="text-secondary"><small>No. de colaborador:</small></div>
  <div class="mt-1"><h6><?=$no_colaborador;?></h6></div>
  </div>
  
  <div class="col-12 col-md-4">
  <div class="text-secondary"><small>Nombre completo:</small></div>
  <div class="mt-1"><h6><?=$nombrePersonal;?></h6></div>
  </div>

  <div class="col-12 col-md-2">
  <div class="text-secondary"><small>Puesto:</small></div>
  <div class="mt-1"><h6><?=$puesto;?></h6></div>
  </div>

  <div class="col-12 col-md-4">
  <div class="text-secondary mt-2">Fecha baja:</div>
  <input class="form-control mt-1" type="date" id="FechaBaja">
  </div>

  <div class="col-12 col-md-4">
  <div class="text-secondary mt-2">Motivo:</div>
  <input type="text" list="DataList" class="form-control mt-1" id="Motivo">
  <datalist id="DataList">
  <option>Renuncia voluntaria</option>
  <option>Mala practica</option>
  <option>Abandono laboral</option>
  </datalist>
  </div>

  <div class="col-12 col-md-4">
  <div class="text-secondary mt-2">Detalle:</div>
  <textarea class="form-control mt-1" rows="1" id="Detalle"></textarea>
  </div>
    
  <div class="col-12 col-md-4">
  <div class="text-secondary mt-2">Acta de hechos:</div>
  <input class="form-control mt-1" type="file" id="ActaHechos">
  </div>

  <div class="col-12 col-md-4">
  <div class="text-secondary mt-2">Carta de Renuncia:</div>
  <input class="form-control mt-1" type="file" id="CartaRenuncia">
  </div>

  <div class="col-12 col-md-4">
  <div class="text-secondary mt-2">Finiquito:</div>
  <input class="form-control mt-1" type="file" id="Finiquito">
  </div>

  <div class="col-12">
  <hr>
  <button type="button" class="btn btn-labeled2 btn-danger float-end" onclick="BajaPersonal(<?=$GET_idPersonal;?>)"><span class="btn-label2"><i class="fa-solid fa-user-minus"></i></span>Dar de baja</button>  </div>

  </div>
  </div>

  </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
