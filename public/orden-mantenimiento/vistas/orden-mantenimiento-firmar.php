<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}
 
$sql = "SELECT
op_orden_mantenimiento.id,
op_orden_mantenimiento.id_estacion,
op_orden_mantenimiento.id_usuario,
op_orden_mantenimiento.fecha,
op_orden_mantenimiento.folio,
op_orden_mantenimiento.codigo,
op_orden_mantenimiento.no_control,
op_orden_mantenimiento.tipo_mantenimiento,
op_orden_mantenimiento.tipo_trabajo,
op_orden_mantenimiento.seguimiento,
op_orden_mantenimiento.trabajo_terminado,
op_orden_mantenimiento.contrato_vigente,
op_orden_mantenimiento.garantia_trabajo,
op_orden_mantenimiento.marco_normativo,
op_orden_mantenimiento.entrada_vigor,
op_orden_mantenimiento.estatus_tramite,
op_orden_mantenimiento.descripcion,
op_orden_mantenimiento.obervaciones,
tb_estaciones.nombre,
tb_estaciones.razonsocial,
tb_estaciones.rfc,
tb_estaciones.direccioncompleta,
tb_estaciones.email
FROM op_orden_mantenimiento 
INNER JOIN tb_estaciones 
ON op_orden_mantenimiento.id_estacion = tb_estaciones.id WHERE op_orden_mantenimiento.id = '".$GET_idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$idEstacion = $row['id_estacion'];
$Codigo = $row['codigo'];
$NoControl = $row['no_control'];
$RazonSocial = $row['razonsocial'];
$RFC = $row['rfc'];
$Email = $row['email'];
$Direccion = $row['direccioncompleta'];
$explode = explode(" ", $row['fecha']);
$Fecha = $explode[0];

$tipomantenimiento = $row['tipo_mantenimiento'];
$ordentrabajo = $row['tipo_trabajo']; 
$seguimiento = $row['seguimiento']; 
$trabajoterminado = $row['trabajo_terminado']; 
$contratovigente = $row['contrato_vigente']; 
$garantiatrabajo = $row['garantia_trabajo'];

$marconormativo = $row['marco_normativo'];
$entradavigor = $row['entrada_vigor'];
$estatustramite = $row['estatus_tramite'];
$descripcion = $row['descripcion'];
$obervaciones = $row['obervaciones'];
}

function Evidencia($idReporte,$Detalle,$con)
{

$Contenido .= '<div class="row">';
$sql = "SELECT * FROM op_orden_mantenimiento_entregables
WHERE id_mantenimiento = '".$idReporte."' AND detalle = '".$Detalle."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

$Contenido .= '<div class="col-6 bg-light">
<img width="100%" src="../../archivos/'.$row['archivo'].'" />
</div>';

}
$Contenido .= '</div>';
return $Contenido;
}

function Personal($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}

function FirmaSC($idReporte,$tipoFirma,$con){
$sql_lista = "SELECT * FROM op_orden_mantenimiento_firma WHERE id_mantenimiento = '".$idReporte."' AND tipo_firma = '".$tipoFirma."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}

$firmaC = FirmaSC($GET_idReporte,'C',$con);
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


  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  });

  function Regresar(){
  window.history.back();
  }

function CrearToken(idReporte){
    $(".LoaderPage").show();

    var parametros = {
    "idReporte" : idReporte
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/orden-mantenimiento/modelo/token-orden-mantenimiento.php',
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

    function FirmarSolicitud(idReporte,tipoFirma){

    var TokenValidacion = $('#TokenValidacion').val();

    var parametros = {
    "idReporte" : idReporte,
    "tipoFirma" : tipoFirma,
    "TokenValidacion" : TokenValidacion
    };

  if(TokenValidacion != ""){
  $('#TokenValidacion').css('border',''); 

    $(".LoaderPage").show();

      $.ajax({
    data:  parametros,
    url:   '../../public/orden-mantenimiento/modelo/firmar-orden-mantenimiento.php',
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
     alertify.error('Error al firmar la orden de mantenimiento');
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
  <div class="row">

  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3">

    <div class="row">
    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">
    <h5>Orden de mantenimiento</h5>
    </div>
    </div>

    </div>
    </div>

  <hr> 

   <div class="row">
  
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
    
  <div class="border p-3">
   
   <div class="table-responsive">
   <table class="table table-sm table-bordered " style="font-size: .9em;">
    <tr>
      <td>Ref. Operativo</td>
      <td rowspan="3" class="text-center align-middle"><h5>Orden de Mantenimiento</h5></td>
      <td>Estación:</td>
      <td><b><?=$RazonSocial;?></b></td>
    </tr>
    <tr>
      <td>Dep. Almacen</td>
       <td>Fecha:</td>
       <td><b><?=FormatoFecha($Fecha);?></b></td>
    </tr>

    <tr>
      <td>Código: <b><?=$Codigo;?></b></td>
      <td>No. De control:</td>
      <td><b><?=$NoControl;?></b></td>
    </tr>
     
   </table> 
  </div>

   <div class="table-responsive"> 
      <table class="table table-sm table-bordered mb-3" style="font-size: .9em;">
          <tr class="tables-bg">
            <th colspan="2" class="text-center align-middle">DATOS DE LA ESTACIÓN DE SERVICIO</th>
          </tr>
        <tr>
          <td class="align-middle"><b>Razón social:</b></td>
          <td class="align-middle bg-light"><?=$RazonSocial;?></td>
        </tr>
        <tr>
          <td class="align-middle"><b>RFC.</b></td>
          <td class="align-middle bg-light"><?=$RFC;?></td>
        </tr>
        <tr>
          <td class="align-middle"><b>Dirección:</b></td>
          <td class="align-middle bg-light"><?=$Direccion;?></td>
        </tr>
        <tr>
          <td class="align-middle"><b>Contacto:</b></td>
          <td class="align-middle bg-light"><?=$Email;?></td>
        </tr>
       </table>
  </div>


  <div class="border p-3 mb-3">
      <h6>TIPO DE MANTENIMIENTO</h6>

      <hr>


    <div class="row">

    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-1 mb-2">
      <div class="form-check form-check-inline">
      <?php if($tipomantenimiento == 1){echo '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';} ?>
      <label class="form-check-label" for="Predictivo">Predictivo</label>
    </div>
    </div>


    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-1 mb-2">
    <div class="form-check form-check-inline">
      <?php if($tipomantenimiento == 2){echo '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';} ?>
      <label class="form-check-label" for="Preventivo">Preventivo</label>
    </div>
    </div>

        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-1 mb-2">
    <div class="form-check form-check-inline">
      <?php if($tipomantenimiento == 3){echo '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';} ?>
      <label class="form-check-label" for="Correctivo">Correctivo</label>
    </div>
    </div>


    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-1 mb-2">
    <div class="form-check form-check-inline">
      <?php if($tipomantenimiento == 4){echo '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';} ?>
      <label class="form-check-label" for="Emergente">Emergente</label>
    </div>
    </div>

    </div>


</div>

  <div class="border p-3 mb-3">
    <h6>LA ORDEN DE TRABAJO SE PUEDE ATENDER INTERNAMENTE</h6>
<hr>


    <div class="row">
    <div class="col-4 mb-1">
      <div class="form-check form-check-inline">
      <?php if($ordentrabajo == 1){echo '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';} ?>
      <label class="form-check-label" for="Si">SI</label>
    </div>
    </div>

    <div class="col-4 mb-1">
    <div class="form-check form-check-inline">
      <?php if($ordentrabajo == 2){echo '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';} ?>
      <label class="form-check-label" for="No">NO</label>
    </div>
    </div>

    <div class="col-4 mb-1">
    <div class="form-check form-check-inline">
      <?php if($ordentrabajo == 3){echo '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';} ?>
      <label class="form-check-label" for="Ambas">AMBAS</label>
    </div>
    </div>

    </div>


</div>

<div class="table-responsive">
        <table class="table table-sm table-bordered mb-0" style="font-size: .9em;">
        <tr class="tables-bg">
            <th class="align-middle">Descripción</th>
            <th class="text-center align-middle">Pruebas de seguimiento SRV</th>
          </tr>
        <tr>
          <td class="align-middle">Marco Normativo</td>
          <td class="align-middle bg-light">
          <?=$marconormativo;?>
          </td>
        </tr>
        <tr>
          <td class="align-middle">Entrada en vigor:</td>
          <td class="align-middle bg-light">
          <?=$entradavigor;?>
          </td>
          </tr>
          <tr>
          <td class="align-middle">Estatus del tramite</td>
          <td class="align-middle bg-light">
          <?=$estatustramite;?>
          </td>
          </tr>
       </table>
  </div>

    </div>
    </div>

  
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
  <div class="border p-3">

    <div class="row">
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">


<div class="table-responsive">
          <table class="table table-sm table-bordered " style="font-size: .9em;">
          <tr class="tables-bg">
            <th colspan="2" class="text-center align-middle">Tipo de trabajo a realizar</th>
            <th class="text-center align-middle">Prestador autorizado, No. De Autorización</th>
          </tr>
        <tbody>
  <?php  
  $sql_tt = "SELECT * FROM op_orden_mantenimiento_trabajo WHERE id_mantenimiento = '".$GET_idReporte."' ";
  $result_tt = mysqli_query($con, $sql_tt);
  $numero_tt = mysqli_num_rows($result_tt);
  while($row_tt = mysqli_fetch_array($result_tt, MYSQLI_ASSOC)){

    $idTT  = $row_tt['id'];

    if($row_tt['estatus'] == 1){
    $checkedTT = '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';
    }else{
    $checkedTT = '';
    }

  echo '<tr>
       <td class="align-middle">'.$row_tt['trabajo'].'</td>
       <td class="align-middle text-center">'.$checkedTT.'</td>
       <td class="align-middle">'.$row_tt['detalle'].'</td>
       </tr>';

  }
  ?>
  </tbody>
       </table>
      </div>
        </div>

  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
        <div class="table-responsive">
          <table class="table table-sm table-bordered" style="font-size: .9em;">
          <tr class="tables-bg">
            <td colspan="2" class="text-center align-middle"><b>Área</b></td>
          </tr>
          <tbody>
  <?php  
  $sql_lista = "SELECT * FROM op_orden_mantenimiento_area WHERE id_mantenimiento = '".$GET_idReporte."' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

    $id  = $row_lista['id'];

    if($row_lista['estatus'] == 1){
    $checked = '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';
    }else{
    $checked = '';
    }

  echo '<tr>
       <td>'.$row_lista['area'].'</td>
       <td class="align-middle text-center" width="30">'.$checked.'</td>
       </tr>';
  }
  ?>
  </tbody>
       </table>
      </div>

        </div> 
       </div>

<div class="table-responsive">
       <table class="table table-sm table-bordered mb-3" style="font-size: .9em;">
         <tr class="tables-bg">
           <th>Descripción del trabajo realizado</th>
         </tr>
         <tr>
           <td class="p-2"><?=$descripcion;?></td>
         </tr>
       </table>
</div>


  <div class="border p-3 mt-1">
    <h6 >SEGUIMIENTO A LA ORDEN DE SERVICIO:</h6>
    <hr>

<div class="table-responsive">
       <table width="100%">
         <tbody>
           <tr>
             <td width="35"><?php if($seguimiento == 1){echo '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';} ?></td>
             <td class="align-middle">1. Detenida por falta de refacciones</td>
           </tr>
           <tr>
             <td width="35"><?php if($seguimiento == 2){echo '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';} ?></td>
             <td class="align-middle">2. En proceso</td>
           </tr>
           <tr>
             <td width="35"><?php if($seguimiento == 3){echo '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';} ?></td>
             <td class="align-middle">3. No autorizada para su reparación</td>
           </tr>
           <tr>
             <td width="35"><?php if($seguimiento == 4){echo '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';} ?></td>
             <td class="align-middle">4. Terminada</td>
           </tr>
         </tbody>
       </table>
</div>

<div class="table-responsive">
       <table width="100%">
         <tbody>
           <tr>
             <td>Trabajo terminado en tiempo y forma:</td>
             <td width="30"><?php if($trabajoterminado == 1){echo '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';} ?></td>
             <td><b>SI</b></td>
             <td width="30"><?php if($trabajoterminado == 2){echo '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';} ?></td>
             <td><b>NO</b></td>
           </tr>
           <tr>
             <td>Contrato vigente con el prestador de servicio:</td>
             <td width="30"><?php if($contratovigente == 1){echo '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';} ?></td>
             <td><b>SI</b></td>
             <td width="30"><?php if($contratovigente == 2){echo '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';} ?></td>
             <td><b>NO</b></td>
           </tr>
           <tr>
             <td>Garantia de trabajos:</td>
             <td width="30"><?php if($garantiatrabajo == 1){echo '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';} ?></td>
             <td><b>SI</b></td>
             <td width="30"><?php if($garantiatrabajo == 2){echo '<img src="'.RUTA_IMG_ICONOS.'icon-check.png">';} ?></td>
             <td><b>NO</b></td>
           </tr>
         </tbody>
       </table>
  </div>
</div>


<div class="table-responsive">
        <table class="table table-sm table-bordered mt-3" style="font-size: .9em;">
         <tr class="tables-bg">
           <th colspan="2">Entregables del trabajo realizado</th>
         </tr>
         <tr class="bg-light">
           <td class="text-center"><b>Antes</b></td>
           <td class="text-center"><b>Despues</b></td>
         </tr>
         <tbody>
          <tr>
            <td class="p-3">
            <?=Evidencia($GET_idReporte,'Antes',$con);?>
            </td>
            <td class="p-3">
            <?=Evidencia($GET_idReporte,'Despues',$con);?>
            </td>
          </tr>
         </tbody>
       </table>
    </div>

<div class="table-responsive">
       <table class="table table-sm table-bordered mt-2 mb-3" style="font-size: .9em;">
         <tr class="tables-bg">
           <th>Observaciones del trabajo realizado</th>
         </tr>
         <tr>
           <td class="p-2"><?=$obervaciones;?></td>
         </tr>
       </table>
  </div>

       <hr>

    <div class="row">
    <?php if($Session_IDUsuarioBD == 19 AND $depto != 5){ ?>
    <?php if($firmaC == 0){ ?>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
<div class="border p-3">
<div class="mb-2 text-secondary text-center">Firma responsable de almacén</div>
<hr>
<h4 class="text-primary text-center">Token Móvil</h4>
<small class="text-secondary">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno</small>
<button class="btn btn-sm mb-2" onclick="CrearToken(<?=$GET_idReporte;?>)"><small>Crear token</small></button>

<hr>
<div class="input-group mt-3">
  <input type="text" class="form-control" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button" onclick="FirmarSolicitud(<?=$GET_idReporte;?>,'C')">Firmar solicitud</button>
  </div>
</div>
</div>
</div>
<?php }?>
<?php }?>


    <?php

    $sql_firma = "SELECT * FROM op_orden_mantenimiento_firma WHERE id_mantenimiento = '".$GET_idReporte."' ";
    $result_firma = mysqli_query($con, $sql_firma);
    $numero_firma = mysqli_num_rows($result_firma);
    while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

    $explode = explode(' ', $row_firma['fecha']);

    if($row_firma['tipo_firma'] == "A"){
    $TipoFirma = "Elaboró";
    $Detalle = '<div class="border p-1 text-center"><img src="../../imgs/firma/'.$row_firma['firma'].'" width="50%"></div>';

    }else if($row_firma['tipo_firma'] == "B"){
    $TipoFirma = "Responsable técnico de la estación";
    $Detalle = '<div class="border p-1 text-center"><img src="../../imgs/firma/'.$row_firma['firma'].'" width="50%"></div>';

    }else if($row_firma['tipo_firma'] == "C"){
    $TipoFirma = "Responsable de Almacén";
    $Detalle = '<div class="border-bottom text-center p-1"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';

    }

    echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 p-1">';
    echo '<div class="border p-2">';
    echo '<h6 class="mt-2 text-secondary text-center">'.$TipoFirma.'</h6><hr>';
    echo $Detalle;
    echo '<div class="text-center mt-2">'.Personal($row_firma['id_usuario'],$con).'</div>';
    echo '</div>';
    echo '</div>';
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
  </div>

  </div>


     <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalFinalizado">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 83px;">
      <div class="modal-body">

       <h5 class="text-info">El token fue validado correctamente.</h5>
       <div class="text-secondary">La orden de mantenimiento fue firmada.</div>

      <div class="text-end">
      <button type="button" class="btn btn-primary" onclick="Regresar()">Aceptar</button>
      </div>

      </div>
    </div>
  </div>
</div>

  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalError">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 83px;">
      <div class="modal-body">

       <h5 class="text-danger">El token no fue aceptado, vuelva a generar uno nuevo o inténtelo mas tarde </h5>
       <div class="text-secondary">La orden de mantenimiento no fue firmada.</div>

      <div class="text-end">
      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
      </div>

      </div>
    </div>
  </div>
</div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
