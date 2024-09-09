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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
 
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

        console.log(response)

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
    "tipoFirma" : tipoFirma,
    "TokenValidacion" : TokenValidacion
    };

    if(TokenValidacion != ""){
    $('#TokenValidacion').css('border',''); 

    $(".LoaderPage").show();

    $.ajax({ 
    data:  parametros,
    url:   '../public/recursos-humanos/modelo/firmar-formato.php',
    type:  'post', 
    beforeSend: function() {
    },
    complete: function(){ 

    },
    success:  function (response) {

    $(".LoaderPage").hide();

    if(response == 1){

    $('#ModalFinalizado').modal('show'); 

    }else{
    $('#ModalError').modal('show');
    alertify.error('Error al firmar');
    }

    }
    });

    }else{
    $('#TokenValidacion').css('border','2px solid #A52525'); 
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
  $Detalle = '<div class="text-center" style="font-size: 1em;"><small class="text-secondary">La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
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


<?php 
  if($status == 1){
  if($Session_IDUsuarioBD == 2){ ?>

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
}else if($Session_IDUsuarioBD == 2){
echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-2 mb-0"><div class="text-center alert alert-warning" role="alert">
   ¡Aun no es posible firmar! <br> La persona que autoriza debe finalizar el formato.
</div></div>';
}else{
  echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-2 mb-0"><div class="text-center alert alert-warning" role="alert">
   ¡No cuentas con los permisos para firmar!
</div></div>';
}
}

?>




  </div>
  </div>


  </div>
  </div>

  <div class="col-12 mb-3">
  <div class="col-12 cardAG p-3 container">
    


  <!---------- FORMULARIOS DE FIRMAS ---------->
  <div class="col-12">
 

<?php  if($formato == 2){ ?>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-2">
<tbody>
<tr>
  <td>Ref. Alta y baja de personal</td>
  <td rowspan="3" class="text-center align-middle" width="250"><b>REESTRUCTURACIÓN DE PERSONAL.</b></td>
  <td class="align-middle">Sucursal:</td>
  <td class="align-middle">Grupo Admongas</td>
</tr>
<tr>
  <td class="align-middle">Departamento de Recursos Humanos</td>
  <td class="align-middle">Fecha:</td>
  <td class="align-middle"><?=FormatoFecha($explode[0]).', '.$HoraFormato;?></td>
</tr>
<tr>
  <td class="align-middle">Depto.Operativo</td>
  <td class="align-middle">No. De control:</td>
  <td class="align-middle"><b>010</b></td>
</tr>
</tbody>
</table>
</div>

<hr>

<div class="row">
<div class="col-12 mb-2">

<b>Lic. Alejandro Guzmán</b></br>
<b>Departamento de Recursos Humanos</b>

<div class="mt-2">Buenos días por medio del presente solicito de su amable apoyo para realizar las siguientes altas de personal:</div>


<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 mt-3">
<thead class="tables-bg">
  <tr>
    <th class="align-middle text-center" width="200">Nombre del empleado</th>
    <th class="align-middle text-center">Cambio a</th>
    <th class="align-middle text-end">Salario diario</th>
    <th class="align-middle text-center">A partir de</th>
    <th class="align-middle text-center">Detalle</th>
  </tr>
</thead> 
<tbody>
<?php
$sql_lista = "SELECT * FROM op_rh_formatos_restructuracion WHERE id_formulario = '".$GET_idFormato."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$personal = NombrePersonal($row_lista['id_personal'],$con);
$estacion = NombreEstacion($row_lista['id_estacion'],$con);

echo '<tr>';
echo '<td class="align-middle text-center">'.$personal['nombre'].'</td>';
echo '<td class="align-middle">'.$estacion.'</td>';
echo '<td class="align-middle text-end">'.number_format($row_lista['sd'],2).'</td>';
echo '<td class="align-middle">'.FormatoFecha($row_lista['fecha']).'</td>';
echo '<td class="align-middle">'.$row_lista['detalle'].'</td>';
echo '</tr>';
}
}else{
echo "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>
<div class="mt-3 text-center">
Sin más por el momento quedo de usted.
</div>

<hr>


<?php }else if($formato == 3){?>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 mt-2">
<tbody>
<tr>
  <td>Ref. Incidencias de personal</td>
  <td rowspan="3" class="text-center align-middle" width="250"><b>INCIDENCIA FALTA</b></td>
  <td class="align-middle">Sucursal:</td>
  <td class="align-middle">Grupo Admongas</td>
</tr>
<tr>
  <td class="align-middle">Departamento de Recursos Humanos</td>
  <td class="align-middle">Fecha:</td>
  <td class="align-middle"><?=FormatoFecha($explode[0]).', '.$HoraFormato;?></td>
</tr>
<tr>
  <td class="align-middle">Depto.Operativo</td>
  <td class="align-middle">No. De control:</td>
  <td class="align-middle"><b>011</b></td>
</tr>
</tbody>
</table>
</div>



<div class="row">
<div class="col-12 mb-2">

<b>Lic. Alejandro Guzmán</b></br>
<b>Departamento de Recursos Humanos</b>

<div class="mt-2">Buenos días por medio del presente solicito de su amable apoyo para realizar las siguientes altas de personal:</div>


<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 mt-3">
<thead class="tables-bg">
  <tr>
  <th>Nombre del empleado</th>
  <th>Días de falta</th>
  <th>Observaciónes</th>
  </tr>
</thead> 
<tbody>
<?php
$sql_lista = "SELECT * FROM op_rh_formatos_falta WHERE id_formulario = '".$GET_idFormato."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$personal = NombrePersonal($row_lista['id_personal'],$con);

echo '<tr>';
echo '<td class="align-middle">'.$personal['nombre'].'</td>';
echo '<td class="align-middle">'.$row_lista['dias_falta'].'</td>';
echo '<td class="align-middle">'.$row_lista['observaciones'].'</td>';
echo '</tr>';
}
}else{
echo "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>


<div class="mt-3 text-center">
Sin más por el momento quedo de usted.
</div>
<hr>


<?php }else if($formato == 4){?>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0">
<tbody>
<tr>
  <td>Ref. Incidencias de personal</td>
  <td rowspan="3" class="text-center align-middle" width="250"><b>BAJA DE PERSONAL</b></td>
  <td class="align-middle">Sucursal:</td>
  <td class="align-middle">Grupo Admongas</td>
</tr>
<tr>
  <td class="align-middle">Departamento de Recursos Humanos</td>
  <td class="align-middle">Fecha:</td>
  <td class="align-middle"><?=FormatoFecha($explode[0]).', '.$HoraFormato;?></td>
</tr>
<tr>
  <td class="align-middle">Depto.Operativo</td>
  <td class="align-middle">No. De control:</td>
  <td class="align-middle"><b>011</b></td>
</tr>
</tbody>
</table>
</div>


<hr>

<div class="row">
<div class="col-12 mb-2">

<b>Lic. Alejandro Guzmán</b></br>
<b>Departamento de Recursos Humanos</b>

<div class="mt-2">Buenos días por medio del presente solicito de su amable apoyo para realizar las siguientes altas de personal:</div>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 mt-3">
<thead class="tables-bg">
  <tr>
  <th>Nombre del empleado</th>
  <th>Baja</th>
  </tr>
</thead> 
<tbody>
<?php
$sql_lista = "SELECT * FROM op_rh_formatos_baja WHERE id_formulario = '".$GET_idFormato."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$personal = NombrePersonal($row_lista['id_personal'],$con);

echo '<tr>';
echo '<td class="align-middle">'.$personal['nombre'].'</td>';
echo '<td class="align-middle">'.$row_lista['baja'].'</td>';
echo '</tr>';
}
}else{
echo "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>
<div class="mt-3 text-center">
Sin más por el momento quedo de usted.
</div>

<hr>


<?php }else if($formato == 5){?>

<?php
$sqlDetalle = "SELECT * FROM op_rh_formatos_vacaciones WHERE id_formulario = '".$GET_idFormato."' ";
$resultDetalle = mysqli_query($con, $sqlDetalle);
$numeroDetalle = mysqli_num_rows($resultDetalle);

while($rowDetalle = mysqli_fetch_array($resultDetalle, MYSQLI_ASSOC)){
$idusuario = $rowDetalle['id_usuario']; 
$numdias = $rowDetalle['num_dias'];
$fechainicio = $rowDetalle['fecha_inicio'];
$fechatermino = $rowDetalle['fecha_termino'];
$fecharegreso = $rowDetalle['fecha_regreso'];
$observaciones2 = $rowDetalle['observaciones'];
}

if($observaciones2 == ""){
$observaciones = "Sin observaciones";
}else{
$observaciones = $observaciones2;
}

$Personal = NombrePersonal($idusuario,$con);
?>
 
 
<div class="table-responsive">
<table class="custom-table mb-3" style="font-size: 12.5px;" width="100%">
<tr>
<td class="font-weight-bold tables-bg"><b>Área o Departamento:</b></td>
<td class="font-weight-bold tables-bg"><b>Nombre completo:</b></td>
<td class="font-weight-bold tables-bg"><b>Número de días a disfrutar:</b></td>
</tr>
<tr>
<td class="bg-light"><?=NombreEstacion($Localidad,$con);?></td>
<td class="bg-light"><?=$Personal['nombre'];?></td>
<td class="bg-light"><?=$numdias;?></td>
</tr>

<tr>
<th class="tables-bg">Del:</th>
<td class="tables-bg"><b>Al:</b></td>
<th class="tables-bg">Regresando el:</th>
</tr>
<tr>
<td class="bg-light"><?=FormatoFecha($fechainicio);?></td>
<td class="bg-light"><?=FormatoFecha($fechatermino);?></td>
<td class="bg-light"><?=FormatoFecha($fecharegreso);?></td>
</tr>

</table>
</div>
 

<div class="table-responsive">
<table class="custom-table" style="font-size: 12.5px;" width="100%">
<thead class="tables-bg">
<tr> <th class="align-middle text-center">Observaciones</th> </tr>
</thead>
<tbody>
<tr class="no-hover">
<th class="align-middle text-center fw-normal bg-light"><?=$observaciones?></th>
</tr>
</tbody>
</table>
</div>

<hr>

<?php }else if($formato == 6){?>

<div><b>Lic. Alejandro Guzmán</b> <br> <b>Departamento de Recursos Humanos</b> </div>
<p class="mt-2">Por medio del presente, solicito su apoyo para el ajuste salarial al siguiente colaborador:</p>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0">
<thead class="tables-bg">
  <tr>
  <th>Apartir del</th>
  <th>Nombre del empleado</th>
  <th>Sueldo</th>
  <th>Puesto</th>
  </tr>
</thead> 
<tbody>
<?php
$sql_lista = "SELECT * FROM op_rh_formatos_ajuste_salarial WHERE id_formulario = '".$GET_idFormato."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$personal = NombrePersonal($row_lista['id_personal'],$con);

echo '<tr>';
echo '<td class="align-middle">'.FormatoFecha($row_lista['fecha']).'</td>';
echo '<td class="align-middle">'.$personal['nombre'].'</td>';
echo '<td class="align-middle">$'.number_format($row_lista['sueldo'],2).'</td>';
echo '<td class="align-middle">'.$personal['puesto'].'</td>';
echo '</tr>';
}
}else{
echo "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

<p class="text-center mt-3">Sin más por el momento quedo de usted.</p>
<hr>
<?php } ?>
  </div>

  <!---------- FIRMAS ---------->
  <div class="col-12">
  <div class="row">     

  <?php 
  if($formato != 5){

  if($status == 1){
  if($Session_IDUsuarioBD == 318){ ?>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
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

  <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" onclick="CrearToken(<?=$GET_idFormato;?>,1)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-solid fa-comment-sms"></i></span>Crear nuevo token SMS</button>

  <button type="button" class="btn btn-labeled2 btn-success text-white ms-2 mt-2" onclick="CrearToken(<?=$GET_idFormato;?>,2)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-brands fa-whatsapp"></i></span>Crear nuevo token Whatsapp</button>

  <!--
  <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" onclick="CrearTokenEmail(<?=$GET_idFormato;?>)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-regular fa-envelope"></i></span>Crear token vía email</button>
  -->
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
  <button class="btn btn-outline-success " type="button" onclick="AutorizacionFormato(<?=$GET_idFormato;?>,'B')">Firmar solicitud</button>
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
echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-2 mb-0"><div class="text-center alert alert-warning" role="alert">
   ¡Aun no es posible firmar! <br> La persona que elabora el formato debe finalizar la solicitud.
</div></div>';
}else{
  echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-2 mb-0"><div class="text-center alert alert-warning" role="alert">
   ¡No cuentas con los permisos para firmar!
</div></div>';
}
}
}
?>


   

<?php 
if($formato != 5){
if($status == 2){

$sql_firma = "SELECT * FROM op_rh_formatos_firma WHERE id_formato = '".$GET_idFormato."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);

  while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){
  $explode = explode(' ', $row_firma['fecha']);

  if($row_firma['tipo_firma'] == "A"){
  $TipoFirma = "Elaboró";
  $Detalle = '<div class="border p-1 text-center"><img src="'.RUTA_IMG.'/firma/'.$row_firma['firma'].'" width="70%"></div>';

  }else if($row_firma['tipo_firma'] == "B"){
  $TipoFirma = "Vo.Bo";
  $Detalle = '<div class="border-bottom text-center p-2"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';

  }

    echo '<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">';
    echo '<div class="border p-3">';
    echo '<h6 class="mt-2 text-secondary text-center">'.$TipoFirma.'</h6><hr>';
    echo $Detalle;
    echo '<div class="text-center mt-2">'.Personal($row_firma['id_usuario'],$con).'</div>';
    echo '</div>';
    echo '</div>';
    }

  ?>

  

<?php if($Session_IDUsuarioBD == 2){ ?>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
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

  <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" onclick="CrearToken(<?=$GET_idFormato;?>,1)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-solid fa-comment-sms"></i></span>Crear nuevo token SMS</button>

  <button type="button" class="btn btn-labeled2 btn-success text-white ms-2 mt-2" onclick="CrearToken(<?=$GET_idFormato;?>,2)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-brands fa-whatsapp"></i></span>Crear nuevo token Whatsapp</button>

  <!--
  <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" onclick="CrearTokenEmail(<?=$GET_idFormato;?>)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-regular fa-envelope"></i></span>Crear token vía email</button>
  -->
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
  <button class="btn btn-outline-success " type="button" onclick="AutorizacionFormato(<?=$GET_idFormato;?>,'C')">Firmar solicitud</button>
  </div>
  </div>
  </th>
  </tr>


  </tbody>
  </table>
  </div>
  </div>



 
<?php }else{
echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-2 mb-0"><div class="text-center alert alert-warning" role="alert">
   ¡No cuentas con los permisos para firmar!
</div></div>';
} 
?>

<?php 
} 
}else{
?>



<?php if($Session_IDUsuarioBD == 2){ ?>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
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

  <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" onclick="CrearToken(<?=$GET_idFormato;?>,1)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-solid fa-comment-sms"></i></span>Crear nuevo token SMS</button>

  <button type="button" class="btn btn-labeled2 btn-success text-white ms-2 mt-2" onclick="CrearToken(<?=$GET_idFormato;?>,2)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-brands fa-whatsapp"></i></span>Crear nuevo token Whatsapp</button>

  <!--
  <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" onclick="CrearTokenEmail(<?=$GET_idFormato;?>)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-regular fa-envelope"></i></span>Crear token vía email</button>
  -->
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
  <button class="btn btn-outline-success " type="button" onclick="AutorizacionFormato(<?=$GET_idFormato;?>,'C')">Firmar solicitud</button>
  </div>
  </div>
  </th>
  </tr>


  </tbody>
  </table>
  </div>
  </div>

  <?php }else{
  echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-2 mb-0"><div class="text-center alert alert-warning" role="alert">
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


  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalFinalizado">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
  <div class="modal-body">
    
  <h5 class="text-info">El token fue validado correctamente.</h5>
  <div class="text-secondary">El formato fue firmado.</div>

  </div>

  <div class="modal-footer">
	<button type="button" class="btn btn-labeled2 btn-success" onclick="Regresar()">
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>


</body>
</html>