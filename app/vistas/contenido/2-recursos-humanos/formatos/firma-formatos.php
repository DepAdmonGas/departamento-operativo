<?php
require('app/help.php');

$sql = "SELECT * FROM op_rh_formatos WHERE id = '".$GET_idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$explode = explode(' ', $row['fecha']);
$HoraFormato = date("g:i a",strtotime($explode[1]));
$idEstacion = $row['id_localidad'];
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);
$formato = $row['formato'];
$status = $row['status'];
}

$estacion = '('.$datosEstacion['localidad'].')';

if($formato == 1){
$Titulo = 'Firmar Alta de Personal '.$estacion;
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
  <script type="text/javascript" src="<?=RUTA_JS?>signature_pad.js"></script>

  <script type="text/javascript">
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  $('[data-toggle="tooltip"]').tooltip();

  });


  function CrearToken(idFormato,idVal,idTipo){
  $(".LoaderPage").show();

  var parametros = {
    "idFormato" : idFormato,
    "idVal" : idVal,
    "idUsuario" : <?=$Session_IDUsuarioBD?>,
    "idTipo" : idTipo,
    "token" : '<?=$tokenWhats?>',
    "accion" : 'firmar-formato-token'
    };

    $.ajax({
    data:  parametros,
    url:   '../app/controlador/2-recursos-humanos/controladorFormatos.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {
    $(".LoaderPage").hide();

    if(response == 1){
    alertify.message('El token fue enviado por mensaje');   
    }else{
    alertify.error('Error al crear el token');   
    }

    }
    });

    } 

    //---------- FIRMAR FORMATO TOKEN ----------//
    function AutorizacionFormato(idFormato,tipoFirma){
    var TokenValidacion = $('#TokenValidacion').val();

    var parametros = {
    "idFormato" : idFormato,
    "idUsuario" : <?=$Session_IDUsuarioBD?>,  
    "tipoFirma" : tipoFirma,
    "TokenValidacion" : TokenValidacion,
    "accion" : 'firmar-formato-martin'
    };

    if(TokenValidacion != ""){
    $('#TokenValidacion').css('border',''); 
    $(".LoaderPage").show();

    $.ajax({ 
    data:  parametros,
    url:   '../app/controlador/2-recursos-humanos/controladorFormatos.php',
    type:  'post', 
    beforeSend: function() {

    },
    complete: function(){ 

    },
    success:  function (response) {

      console.log(response)
    $(".LoaderPage").hide();
    if(response == 1){
    $('#ModalFinalizado').modal('show'); 

    }else{
    $('#ModalError').modal('show');
    alertify.error('Error al firmar formato');
    }

    }
    });

    }else{
    alertify.error('Falta ingresar el token');
    }

    }



  //---------- FINALIZAR ALTA PERSONAL ----------//
  function Finalizar(idReporte, tipoFirma) {
  let signatureBlank = signaturePad.isEmpty();
  var ctx = document.getElementById("canvas");
  var image = ctx.toDataURL();
  document.getElementById('base64').value = image;
  var base64 = $('#base64').val();
  var canvas = $('#canvas').val();

  if (!signatureBlank) {

  var data = new FormData();
  var url = '../app/controlador/2-recursos-humanos/controladorFormatos.php';

  data.append('idReporte', idReporte);
  data.append('idUsuario', <?=$Session_IDUsuarioBD?>);
  data.append('tipoFirma', tipoFirma);
  data.append('base64', base64);
  data.append('accion', 'finalizar-formato-firma');  

  alertify.confirm('',
  function () {

  $(".LoaderPage").show();

  $.ajax({
  url: url,
  type: 'POST',
  contentType: false,
  data: data,
  processData: false,
  cache: false 
  }).done(function (data) {


  if (data == 1) {
  history.go(-1);
  } else {
  $(".LoaderPage").hide();
  alertify.error('Error al finalizar');
  }

  });

  },
  function () {

  }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea finalizar el formato?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

  } else {
  alertify.error('Falta agregar la firma');
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

  <div class="cardAG container p-3">

  <div class="row">
  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Formatos
  </a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase"><?=$Titulo;?></li>
  </ol>
  </div>
  
  <div class="row"> 
  <div class="col-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"><?=$Titulo;?></h3> </div>
  </div>

  <hr>
  </div>

  <div class="col-12">
  <!---------- 1. ALTA DE PERSONAL ---------->
  <?php if($formato == 1){ ?>
  <div class="col-12 text-end mb-3 ">
  <b>Formato:</b> RH-ALT-01
  <br>
  <b>No. De control:</b> 00<?=$GET_idReporte?>
  <p>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?></p>
  </div>

  <div class="col-12">
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <p><b>Departamento de Recursos Humanos</b></p>
  <p>Buenos días por medio del presente solicito de su amable apoyo para realizar la siguiente alta de personal.</p>
  </div>

  <div class="table-responsive mb-4">
  <table class="custom-table" width="100%">

  <thead class="tables-bg">
  <tr>
  <th class="align-middle text-center">#</th>
  <th class="align-middle text-center">Empleado</th>
  <th class="align-middle text-center">Estacion</th>
  <th class="align-middle text-center">Puesto</th>
  <th class="align-middle text-center">Alta</th>
  <th class="align-middle text-center">Salario</th>

  </tr>
  </thead>

  <tbody class="bg-light">
  <?php
  $sql_lista = "SELECT * FROM op_rh_formatos_alta WHERE id_formulario = '" . $GET_idReporte . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if ($numero_lista > 0) {
  $num = 1;
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $id = $row_lista['id'];

  $NombreC = $row_lista['nombre'];
  $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($row_lista['id_estacion']);
  $nombreEstacion = $datosEstacion['localidad'];
  $puesto = $ClassHerramientasDptoOperativo->obtenerPuestoPersonal($row_lista['puesto']);
  $fecha_alta = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha_ingreso']);
  $salario = number_format($row_lista['sd'],2);

  echo '<tr>';              
  echo '<td class="align-middle text-center">' . $num . '</td>';      
  echo '<td class="align-middle text-center">' . $NombreC . '</td>';  
  echo '<td class="align-middle text-center">' . $nombreEstacion . '</td>';           
  echo '<td class="align-middle text-center">' . $puesto . '</td>';           
  echo '<td class="align-middle text-center">' . $fecha_alta . '</td>';       
  echo '<td class="align-middle text-center">$ ' . $salario . '</td>';           
  echo '</tr>';
       
  $num++;                     
  }

  } else {
  echo "<tr><th colspan='15' class='text-center text-secondary fw-normal'><small>No se encontró información para mostrar </small></th></tr>";
  }
  ?>

  </tbody>
  </table>
  </div>


  <div class="col-12 text-center"><p>Sin más por el momento quedo de usted.</p><hr></div>

  <?php } ?>
  </div>


  <!---------- fIRMAS DE ELABORACION DEL FORMATO ---------->
  <div class="col-12">
  <div class="row">

  <?php 
  $sql_firma = "SELECT * FROM op_rh_formatos_firma WHERE id_formato = '".$GET_idReporte."' ";
  $result_firma = mysqli_query($con, $sql_firma);
  $numero_firma = mysqli_num_rows($result_firma);

  while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){
  $explode = explode(' ', $row_firma['fecha']);

  $datosUsuario = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($row_firma['id_usuario']);
  $nombreUser = $datosUsuario['nombre'];


  if($row_firma['tipo_firma'] == "A"){
  $TipoFirma = "NOMBRE Y FIRMA DE QUIEN ELABORÓ";
  $Detalle = '<div class="border-0 text-center"><img src="'.RUTA_IMG_Firma.''.$row_firma['firma'].'" width="70%"></div>';
    
  }else if($row_firma['tipo_firma'] == "B"){
  $TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
  $Detalle = '<div class="text-center" style="font-size: 1em;"><small class="text-secondary">La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
    
  }else if($row_firma['tipo_firma'] == "C"){
  $TipoFirma = "NOMBRE Y FIRMA DE QUIEN VERIFICA";
  $Detalle = '<div class="border-0 text-center"><img src="'.RUTA_IMG_Firma.''.$row_firma['firma'].'" width="70%"></div>';
  }
    
  echo '  <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">'.$nombreUser.'</th> </tr>
  </thead>
  <tbody class="bg-light">
  <tr>
  <th class="align-middle text-center no-hover2">'.$Detalle.'</th>
  </tr>

  <tr>
  <th class="align-middle text-center no-hover2">'.$TipoFirma.'</th>
  </tr>
  
  </tbody>
  </table>
  </div>';
  }

  ?>



  <!----- FIRMA LIC. MARTIN ----->
  <?php 
  if($status == 1){
  if($Session_IDUsuarioBD == 2){ 
  ?>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
  <div class="table-responsive">
  <table class="custom-table" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">FIRMA DE AUTORIZACIÓN</th> </tr>
  </thead>
  <tbody>
    
  <tr class="no-hover">
  <th class="align-middle text-center bg-light">
  <h4 class="text-primary text-center">Token Móvil</h4>
  <small class="text-secondary" style="font-size: .75em;">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno:</small>
  <br>

  <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,1,<?=$formato?>)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-solid fa-comment-sms"></i></span>Crear nuevo token SMS</button>

  <button type="button" class="btn btn-labeled2 btn-success text-white ms-2 mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,2,<?=$formato?>)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-brands fa-whatsapp"></i></span>Crear nuevo token Whatsapp</button>

  </th>
  
  </tr>

  <tr class="no-hover">
  <th class="align-middle text-center bg-light">
  <small class="text-danger" style="font-size: .75em;">Nota: En caso de no recibir el token de WhatsApp, agrega el número <b>+1 555-617-9367</b><br>
   a tus contactos y envía un mensaje por WhatsApp a ese número con la palabra "OK".
  </small>
  </th>
  </tr>

  <tr class="no-hover">
  <th class="align-middle text-center bg-light p-0">
  <div class="input-group">
  <input type="text" class="form-control border-0 bg-light" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
  <button class="btn btn-outline-success " type="button" onclick="AutorizacionFormato(<?=$GET_idReporte;?>,'B')">Firmar solicitud</button>
  </div>
  </div>
  </th>
  </tr>


  </tbody>
  </table>
  </div>
  </div>

  <?php 

  }else if($Session_IDUsuarioBD == 354){
  echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mt-2 mb-0"><div class="text-center alert alert-warning" role="alert">
    ¡Aun no es posible firmar! <br> La persona que autoriza debe finalizar el formato.
  </div></div>';
  }else{
    echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mt-2 mb-0"><div class="text-center alert alert-warning" role="alert">
    ¡No cuentas con los permisos para firmar!
  </div></div>';
  }

  }
  ?>

    
  <!----- FIRMA ALEJANDRO GUZMAN ----->
  <?php 
  if($status == 2){
  if($Session_IDUsuarioBD == 354){
  ?>

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: .8em;" width="100%">
  
  <thead class="tables-bg">
  <tr><th class="text-center align-middle">Firma de quien verifica</th></tr>
  </thead>

  <tbody class="bg-light"> 
  <tr>
  <td class="no-hover2 p-0">
  <div id="signature-pad" class="signature-pad border-0" style="cursor:crosshair">
  <div class="signature-pad--body">
  <canvas style="width: 100%; height: 200px; border-right: 0.1px solid rgb(33, 93, 152); border-left: 0.1px solid rgb(33, 93, 152); cursor: crosshair; touch-action: none;" id="canvas" width="900" height="150"></canvas>  
  <input type="hidden" name="base64" value="" id="base64">
  </div>
  </div>
  </td>
  </tr>
                      
  <tr><th colspan="6" class="bg-danger text-white p-2" onclick="resizeCanvas()"><i class="fa-solid fa-broom"></i> Limpiar firma</th></tr>
  </tbody>
  </table>
  </div>
  </div>

  <div class="col-12">
  <hr>
  <button type="button" class="btn btn-labeled2 btn-success float-end" onclick="Finalizar(<?=$GET_idReporte?>,'C')">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Finalizar</button>
  </div>

  <?php 
  }else{
    echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mt-2 mb-0"><div class="text-center alert alert-warning" role="alert">
    ¡No cuentas con los permisos para firmar!
  </div></div>';
  }
  }
  ?>



  </div>
  </div>

  </div>
  </div>


  </div>
  </div>
  </div>
  </div>


  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalFinalizado">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
  <div class="modal-body">
    
  <h5 class="text-info">El token fue validado correctamente.</h5>
  <div class="text-secondary">El formato fue firmado.</div>

  </div>

  <div class="modal-footer">
	<button type="button" class="btn btn-labeled2 btn-success" onclick="history.back()">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Aceptar</button>
  </div>

  </div>
  </div>
  </div>

  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalError">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
  <div class="modal-body">

  <h5 class="text-danger">El token no fue aceptado, vuelva a generar uno nuevo o inténtelo mas tarde </h5>
  <div class="text-secondary">El formato no fue firmado.</div>
  </div>

  <div class="modal-footer">
	<button type="button" class="btn btn-labeled2 btn-success" data-bs-dismiss="modal">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Aceptar</button>
  </div>

  </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="<?= RUTA_JS2 ?>signature-pad-functions.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>


</body>
</html>