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

}else if($formato == 2){
$Titulo = 'Firmar Baja de Personal '.$estacion;

}else if($formato == 3){
$Titulo = 'Firmar Falta de Personal '.$estacion;

}else if($formato == 4){
$Titulo = 'Firmar Reestructuración de Personal '.$estacion;
  
}else if($formato == 5){
$Titulo = 'Firmar Ajuste Salarial '.$estacion;
    
}else if($formato == 6){
$Titulo = 'Firmar Vacaciones de Personal '.$estacion;
      
}else if($formato == 7){
$Titulo = 'Firmar Solicitud Prima Vacacional '.$estacion;
        
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
    "estacion":'<?=$datosEstacion['localidad']?>',
    "fecha":'<?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?>',
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
      //Dentro de la condición cuando se manda la alerta
    alertify.success('El token fue enviado por mensaje');
            alertify.warning('Debera esperar 30 seg para volver a crear un nuevo token');
            // Deshabilitar los botones y guardar el tiempo en localStorage
            var disableTime = new Date().getTime();
            localStorage.setItem('disableTime', disableTime);
            // Deshabilitar los botones
            document.getElementById('btn-email').disabled = true;
            document.getElementById('btn-telegram').disabled = true;
            // Define el tiempo para habilitar los botones
            setTimeout(function () {
              document.getElementById('btn-email').disabled = false;
              document.getElementById('btn-telegram').disabled = false;
            }, 30000); // 30000 milisegundos = 30 segundos
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


  //---------- CREAR TOKEN VIA EMAIL ----------//

    function CrearTokenEmail(idFormato,idTipo){
    $(".LoaderPage").show();

    var parametros = {
    "idFormato" : idFormato,
    "idUsuario" : <?=$Session_IDUsuarioBD?>,
    "accion" : 'crear-token-email'
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
     alertify.message('El token fue enviado por correo electrónico');   
   }else{
     alertify.error('Error al crear el token');   
   }
  
    }
    });
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


  <!---------- 2. BAJA DE PERSONAL ---------->
  <?php } else if($formato == 2){ ?>
  <div class="col-12 text-end mb-3 ">
  <b>Formato:</b> RH-BAJ-02
  <br>
  <b>No. De control:</b> 00<?=$GET_idReporte?>
  
  <p>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?></p>
  </div>

  <div class="col-12">
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <p><b>Departamento de Recursos Humanos</b></p>
  <p>Buenos días por medio del presente solicito de su amable apoyo para realizar las siguientes bajas de personal.</p>
  </div>

  <div class="table-responsive mb-4">
  <table class="custom-table" width="100%">

  <thead class="tables-bg">
  <tr>
  <th class="align-middle text-center">#</th>
  <th class="align-middle text-center">Empleado</th>
  <th class="align-middle text-center">Estacion / Departamento</th>
  <th class="align-middle text-center">Fecha de aplicacion de baja</th>
  <th class="align-middle text-center">Motivo</th>
  <th class="align-middle text-center">Detalle</th>
  </tr>
  </thead>

  <tbody class="bg-light">
  <?php
  $sql_lista = "SELECT * FROM op_rh_formatos_baja WHERE id_formulario = '" . $GET_idReporte . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if ($numero_lista > 0) { 
  $num = 1;
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $id = $row_lista['id'];

  $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($row_lista['id_personal']);
  $NombreC = $datosPersonal['nombre_personal'];

  $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($row_lista['id_estacion']);
  $nombreEstacion = $datosEstacion['localidad'];

  $fecha_baja = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha_baja']);
  
  $motivo = $row_lista['motivo'];
  $detalle = $row_lista['detalle'];

  echo '<tr>';              
  echo '<td class="align-middle text-center">' . $num . '</td>';      
  echo '<td class="align-middle text-center">' . $NombreC . '</td>';  
  echo '<td class="align-middle text-center">' . $nombreEstacion . '</td>';           
  echo '<td class="align-middle text-center">' . $fecha_baja . '</td>';      
  echo '<td class="align-middle text-center">' . $motivo . '</td>';          
  echo '<td class="align-middle text-center">' . $detalle . '</td>';           
  echo '</tr>';
       
  $num++;                     
  }

  }else{
  echo "<tr><th colspan='15' class='text-center text-secondary fw-normal'><small>No se encontró información para mostrar </small></th></tr>";
  }
  ?>

  </tbody>
  </table>
  </div>

  <div class="col-12 text-center"><p>Sin más por el momento quedo de usted.</p><hr></div>
  <!---------- 5. FALTA DE PERSONAL ---------->
  <?php } else if($formato == 3){ ?>

  <div class="col-12 text-end mb-3 ">
  <b>Formato:</b> RH-FALT-03
  <br>
  <b>No. De control:</b> 00<?=$GET_idReporte?>
  
  <p>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?></p>
  </div>

  <div class="col-12">
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <p><b>Departamento de Recursos Humanos</b></p>
  <p>Por medio del presente se le notifica la siguiente incidencia que corresponde a faltas de personal.</p>
  </div>
 
  <div class="table-responsive mb-4">
  <table class="custom-table" width="100%">

  <thead class="tables-bg">
  <tr>
  <th class="align-middle text-center">#</th>
  <th class="align-middle text-center">Colaborador</th>
  <th class="align-middle text-center">Dia faltante</th>
  <th class="align-middle text-center">Estacion</th>
  </tr>
  </thead>

  <tbody class="bg-light">
  <?php
  $sql_lista = "SELECT * FROM op_rh_formatos_falta WHERE id_formulario = '" . $GET_idReporte . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if ($numero_lista > 0) { 
  $num = 1;
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $id = $row_lista['id'];

  $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($row_lista['id_personal']);
  $NombreC = $datosPersonal['nombre_personal'];

  $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($row_lista['id_estacion']);
  $nombreEstacion = $datosEstacion['localidad'];

  $dias_falta = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['dias_falta']);

  echo '<tr>';              
  echo '<td class="align-middle text-center">' . $num . '</td>';      
  echo '<td class="align-middle text-center">' . $NombreC . '</td>';  
  echo '<td class="align-middle text-center">' . $dias_falta . '</td>';          
  echo '<td class="align-middle text-center">' . $nombreEstacion . '</td>';           
  echo '</tr>';
       
  $num++;                     
  }

  }else{
  echo "<tr><th colspan='15' class='text-center text-secondary fw-normal'><small>No se encontró información para mostrar </small></th></tr>";
  }
  ?>

  </tbody>
  </table>
  </div>
  
  <div class="col-12 text-center"><p>Sin más por el momento quedo de usted.</p><hr></div>







  <!---------- 4. REESTRUCTURACIÓN DE PERSONAL ---------->
  <?php } else if($formato == 4){ ?>

  <div class="col-12 text-end mb-3 ">
  <b>Formato:</b> RH-REEST-04
  <br>
  <b>No. De control:</b> 00<?=$GET_idReporte?>
  
  <p>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?></p>
  </div>

  <div class="col-12">
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <p><b>Departamento de Recursos Humanos</b></p>
  <p>Buenos días por medio del presente solicito de su amable apoyo para realizar el siguiente cambio de personal.</p>
  </div>

  <div class="table-responsive mb-4">
  <table class="custom-table" width="100%">

  <thead class="tables-bg">
  <tr>
  <th class="align-middle text-center">#</th>
  <th class="align-middle text-center">Empleado</th>
  <th class="align-middle text-center">De Estacion / Departamento</th>
  <th class="align-middle text-center">Cambio a</th>
  <th class="align-middle text-center">Fecha de aplicacion de baja</th>

  </tr>
  </thead>

  <tbody class="bg-light">
  <?php
  $sql_lista = "SELECT * FROM op_rh_formatos_restructuracion WHERE id_formulario = '" . $GET_idReporte . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if ($numero_lista > 0) { 
  $num = 1;
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $id = $row_lista['id'];

  $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($row_lista['id_personal']);
  $NombreC = $datosPersonal['nombre_personal'];

  $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($row_lista['id_estacion']);
  $nombreEstacion = $datosEstacion['localidad'];

  $datosEstacion2 = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($row_lista['id_estacion_cambio']);
  $nombreEstacion2 = $datosEstacion2['localidad'];

  $fecha= $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha']);


  echo '<tr>';              
  echo '<td class="align-middle text-center">' . $num . '</td>';      
  echo '<td class="align-middle text-center">' . $NombreC . '</td>';  
  echo '<td class="align-middle text-center">' . $nombreEstacion . '</td>';           
  echo '<td class="align-middle text-center">' . $nombreEstacion2 . '</td>';       
  echo '<td class="align-middle text-center">' . $fecha . '</td>';          
  echo '</tr>';
       
  $num++;                      
  }

  }else{
  echo "<tr><th colspan='15' class='text-center text-secondary fw-normal'><small>No se encontró información para mostrar </small></th></tr>";
  }
  ?>

  </tbody>
  </table>
  </div>

  <div class="col-12 text-center"><p>Sin más por el momento quedo de usted.</p><hr></div>

    
  <!---------- 5. AJUSTE SALARIAL ---------->
  <?php } else if($formato == 5){ ?>
  <div class="col-12 text-end mb-3 ">
  <b>Formato:</b> RH-ADJS-05
  <br>
  <b>No. De control:</b> 00<?=$GET_idReporte?>
  
  <p>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?></p>
  </div>

  <div class="col-12">
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <p><b>Departamento de Recursos Humanos</b></p>
  <p>Buenos días por medio del presente solicito su apoyo para el ajuste salarial al siguiente colaborador.</p>
  </div>
 

  <div class="table-responsive mb-4">
  <table class="custom-table" width="100%">

  <thead class="tables-bg">
  <tr>
  <th class="align-middle text-center">#</th>
  <th class="align-middle text-center">Colaborador</th>
  <th class="align-middle text-center">Puesto</th>
  <th class="align-middle text-center">Salario Diario</th>
  <th class="align-middle text-center">Ajuste a</th>
  <th class="align-middle text-center">Aplicar a partir del</th>

  </tr>
  </thead>
 
  <tbody class="bg-light">
  <?php
  $sql_lista = "SELECT * FROM op_rh_formatos_ajuste_salarial WHERE id_formulario = '" . $GET_idReporte . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if ($numero_lista > 0) { 
  $num = 1;
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $id = $row_lista['id'];

  $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($row_lista['id_personal']);
  $NombreC = $datosPersonal['nombre_personal']; 
  $Puesto = $datosPersonal['puesto'];  

  $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($row_lista['id_estacion']);
  $nombreEstacion = $datosEstacion['localidad'];

  $salarioActual = $row_lista['salario_actual'];
  $salarioAjustado = $row_lista['salario_ajustado'];

  $fecha_aplicacion = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha_aplicacion']);
 

  echo '<tr>';              
  echo '<td class="align-middle text-center">' . $num . '</td>';      
  echo '<td class="align-middle text-center">' . $NombreC . '</td>';  
  echo '<td class="align-middle text-center">' . $Puesto . '</td>';           
  echo '<td class="align-middle text-center">$' . number_format($salarioActual,2) . '</td>';       
  echo '<td class="align-middle text-center">$' . number_format($salarioAjustado,2) . '</td>';    
  echo '<td class="align-middle text-center">' . $fecha_aplicacion . '</td>';                
  echo '</tr>';
       
  $num++;                     
  }

  }else{
  echo "<tr><th colspan='15' class='text-center text-secondary fw-normal'><small>No se encontró información para mostrar </small></th></tr>";
  }
  ?>

  </tbody>
  </table>
  </div>


  <div class="col-12 text-center"><p>Sin más por el momento quedo de usted.</p><hr></div>


  <!---------- 6. VACACIONES DE PERSONAL ---------->
  <?php } else if($formato == 6){ 
    
  $sql_lista = "SELECT * FROM op_rh_formatos_vacaciones WHERE id_formulario = '" . $GET_idReporte . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

    while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
    $id = $row_lista['id'];
    $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($row_lista['id_usuario']);
    $NombreC = $datosPersonal['nombre_personal']; 
    $Puesto = $datosPersonal['puesto'];  
    $idEstaciones = $datosPersonal['idEstacion'];  
 
    $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstaciones);
    $nombreEstacion = $datosEstacion['localidad'];
      
    $num_dias = $row_lista['num_dias'];      
    $fecha_inicio = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha_inicio']);
    $fecha_termino = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha_termino']);
    $fecha_regreso = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha_regreso']);

    $observaciones = $row_lista['observaciones'];      
    }
    
    if($observaciones == ""){
    $observaciones2 = "N/A";
    }else{
    $observaciones2 = $observaciones;
    }

    ?>


  <div class="col-12 text-end mb-3 ">
  <b>Formato:</b> RH-FV-06
  <br>
  <b>No. De control:</b> 00<?=$GET_idReporte?>
  
  <p>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?></p>
  </div>

  <div class="col-12">
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <p><b>Departamento de Recursos Humanos</b></p>
  <p>Por medio de la presente, solicito su apoyo para llevar a cabo la autorizacion correspondiente en las vacaciones al siguiente colaborador.</p>
  </div>


  <!---------- TABLA DEL PERSONAL ---------->
  <div class="col-12">
  <div class="table-responsive">
    <table class="custom-table mb-3" style="font-size: 12.5px;" width="100%">
    <tr>
    <td class="font-weight-bold tables-bg"><b>Área o Departamento:</b></td>
    <td class="font-weight-bold tables-bg"><b>Nombre completo:</b></td>
    <td class="font-weight-bold tables-bg"><b>Número de días a disfrutar:</b></td>
    </tr>
    <tr>
    <td class="bg-light"><?=$nombreEstacion?></td>
    <td class="bg-light"><?=$NombreC?></td>
    <td class="bg-light"><?=$num_dias;?></td>
    </tr>

    <tr>
    <th class="tables-bg">Del:</th>
    <td class="tables-bg"><b>Al:</b></td>
    <th class="tables-bg">Regresando el:</th>
    </tr>
    <tr>
    <td class="bg-light"><?=$fecha_inicio?></td>
    <td class="bg-light"><?=$fecha_termino?></td>
    <td class="bg-light"><?=$fecha_regreso?></td>
    </tr>

    <tr>
    <th class="tables-bg" colspan="3">Observaciones:</th>
    </tr>
    <tr>
    <td class="bg-light" colspan="3"><?=$observaciones2?></td>
    </tr>

    </table>
    </div>
    </div>
 

    
  <div class="col-12 text-center"><p>Sin más por el momento quedo de usted.</p><hr></div>

  <!---------- 7. PRIMA VACACIONAL ---------->
  <?php } else if($formato == 7){ 
 $sql_lista = "SELECT * FROM op_rh_formatos_prima_vacacional WHERE id_formulario = '" . $GET_idReporte . "' ";
 $result_lista = mysqli_query($con, $sql_lista);
 $numero_lista = mysqli_num_rows($result_lista);

     while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
     $id = $row_lista['id'];
     $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($row_lista['id_personal']);
     $NombreC = $datosPersonal['nombre_personal']; 
     $fecha_ingreso = $ClassHerramientasDptoOperativo->FormatoFecha($datosPersonal['fecha_ingreso']); 
  
     $idEstaciones = $row_lista['id_estacion'];      
     $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstaciones);
     $nombreEstacion = $datosEstacion['localidad'];
       
     $periodo = $row_lista['periodo'];      
 
     }
 
     $contenido = '<th class="text-center fw-normal">'.$NombreC.'</th>
     <th class="text-center fw-normal">'.$fecha_ingreso.'</th>
     <th class="text-center fw-normal">'.$nombreEstacion.'</th>';

  ?>
  


  <div class="col-12 text-end mb-3 ">
  <b>Formato:</b> RH-FV-06
  <br>
  <b>No. De control:</b> 00<?=$GET_idReporte?>
  
  <p>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?></p>
  </div>

  <div class="col-12">
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <p><b>Departamento de Recursos Humanos</b></p>
  <p>
  Sirva la presente para enviarle un cordial saludo, al mismo tiempo, me permito solicitarle el pago de mi prima vacacional, correspondiente al periodo de  
  <input class="form-control ms-2" type="number" value="<?=$periodo?>" style="display: inline-block; width: auto; width: 150px" disabled>
  </p>
  </div>


  <!---------- TABLA DEL PERSONAL ---------->
  <div class="col-12">
  <div class="table-responsive mb-4">
  <table class="custom-table" width="100%">

  <thead class="tables-bg">
  <tr>
  <th class="align-middle text-center">Colaborador</th>
  <th class="align-middle text-center">Fecha de ingreso</th>
  <th class="align-middle text-center">Estacion / Departamento</th>

  </tr>
  </thead>

  <tbody class="bg-light">
  <tr>             
    <?=$contenido?>      
  </tr>
  </tbody>
  </table>
  </div>
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
  $TipoFirma = "NOMBRE Y FIRMA DE VOBO";
  $Detalle = '<div class="text-center" style="font-size: 1em;"><small class="text-secondary">La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
    
  }else if($row_firma['tipo_firma'] == "C"){
  $TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
  $Detalle = '<div class="text-center" style="font-size: 1em;"><small class="text-secondary">La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';

  }else if($row_firma['tipo_firma'] == "D"){
  $TipoFirma = "NOMBRE Y FIRMA DE VERIFICACIÓN";
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
  if($Session_IDUsuarioBD == 19){ 
  ?>

  <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">
  <div class="table-responsive">
  <table class="custom-table" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">FIRMA DE VOBO</th> </tr>
  </thead>
  <tbody>
    
  <tr class="no-hover">
  <th class="align-middle text-center bg-light">
  <h4 class="text-primary text-center">Token Móvil</h4>
  <small class="text-secondary" style="font-size: .75em;">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno:</small>
  <br> 
  <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" 

  onclick="CrearTokenEmail(<?=$GET_idReporte;?>,<?=$formato?>)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-regular fa-envelope"></i></span> Crear nuevo token vía e-mail</button>

  <button id="btn-telegram" type="button" class="btn btn-labeled2 btn-primary text-light mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,3,<?=$formato?>)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-brands fa-telegram"></i></span>Crear nuevo token Telegram</button>
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

  }else if($Session_IDUsuarioBD == 2){
  echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mt-2 mb-0"><div class="text-center alert alert-warning" role="alert">
    ¡Aun no es posible firmar! <br> La persona que da el VOBO debe finalizar el formato.
  </div></div>';
  }else{
    echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mt-2 mb-0"><div class="text-center alert alert-warning" role="alert">
    ¡No cuentas con los permisos para firmar!
  </div></div>';
  }

  }
  ?>


  <!----- FIRMA LIC. MARTIN ----->
  <?php 
  if($status == 2){
  if($Session_IDUsuarioBD == 2){ 
  ?>


  <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">
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

  <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" 
  onclick="CrearTokenEmail(<?=$GET_idReporte;?>,<?=$formato?>)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-regular fa-envelope"></i></span> Crear nuevo token vía e-mail</button>

  <button type="button" class="btn btn-labeled2 btn-primary text-light mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,3,<?=$formato?>)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-brands fa-telegram"></i></span>Crear nuevo token Telegram</button>
  </th>
  
  </tr>

  <tr class="no-hover">
  <th class="align-middle text-center bg-light p-0">
  <div class="input-group">
  <input type="text" class="form-control border-0 bg-light" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
  <button class="btn btn-outline-success " type="button" onclick="AutorizacionFormato(<?=$GET_idReporte;?>,'C')">Firmar solicitud</button>
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
  if($status == 3){
  if($Session_IDUsuarioBD == 354){
  ?>

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: .8em;" width="100%">
  
  <thead class="tables-bg">
  <tr><th class="text-center align-middle">FIRMA DE VERIFICACIÓN</th></tr>
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
  <button type="button" class="btn btn-labeled2 btn-success float-end" onclick="Finalizar(<?=$GET_idReporte?>,'D')">
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