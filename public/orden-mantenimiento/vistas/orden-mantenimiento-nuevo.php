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

  Evidencias(<?=$GET_idReporte;?>);
  });

  function Regresar(){
  window.history.back();
  }

  function Evidencias(idReporte){

   $('#ListaEvidencias').load('../../public/orden-mantenimiento/vistas/lista-orden-mantenimiento-evidencias.php?idReporte=' + idReporte);
 
  }

  function EditTM(idReporte, categoria, valor){

    if(categoria == 12){
    if (document.getElementById('Area' + idReporte).checked)
    {
    valor = 1;
    }else{
    valor = 0;
    }
    }else if(categoria == 13){
    if (document.getElementById('Trabajo' + idReporte).checked)
    {
    valor = 1;
    }else{
    valor = 0;
    }
    }else{
    valor = valor;
    }

    var parametros = {
    "idReporte" : idReporte,
    "categoria" : categoria,
    "valor" : valor
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/orden-mantenimiento/modelo/editar-orden-mantenimiento.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){
    },
    success:  function (response) {

    }
    });

  }

  function EditTA(c,idReporte,categoria){

    var parametros = {
    "idReporte" : idReporte,
    "categoria" : categoria,
    "valor" : c.value
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/orden-mantenimiento/modelo/editar-orden-mantenimiento.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){
    },
    success:  function (response) {
    }
    });

  }
 
  function btnModal(idReporte){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('../../public/orden-mantenimiento/vistas/modal-entregables.php?idReporte=' + idReporte);
  }

  function GuardarArhivo(idReporte){

  var Archivo = $('#Archivo').val();
  var Detalle = $('#Detalle').val();

  var EvidenciasM = document.getElementById("Archivo");
  var FileEvidencia = EvidenciasM.files[0];
  var PathProtocolo = EvidenciasM.value;
  var ext = $("#Archivo").val().split('.').pop();

  var data = new FormData();
  var url = '../../public/orden-mantenimiento/modelo/agregar-evidencias-mantenimiento.php';

  if (Archivo != "") {
  $('#Archivo').css('border','');
  if (Detalle != "") {
  $('#Detalle').css('border','');
  if (ext == "JPG" || ext == "jpg" || ext == "jpeg" || ext == "PNG" || ext == "png") {
  $('#result').html('');

  data.append('idReporte', idReporte);
  data.append('Detalle', Detalle);
  data.append('FileEvidencia', FileEvidencia);

  $(".LoaderPage").show();

    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false,
    }).done(function(data){


    $('#Modal').modal('hide');
    $(".LoaderPage").hide();
    alertify.success('Entregable agregada');
    Evidencias(idReporte);

    });

  }else{
  $('#result').html('<small class="text-danger">Solo se aceptan formato JPG y PNG</small>');
  }
  }else{
  $('#Detalle').css('border','2px solid #A52525');
  }
  }else{
  $('#Archivo').css('border','2px solid #A52525');
  }


  }

  function Eliminar(idReporte,id){

    var parametros = {
  "id" : id
  };

  alertify.confirm('',
  function(){

    $.ajax({
    data:  parametros,
    url:   '../../public/orden-mantenimiento/modelo/eliminar-evidencia.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    Evidencias(idReporte);
    }else{
     alertify.error('Error al eliminar la evidencia');  
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

  }

function Finalizar(idReporte){

var ctx = document.getElementById("canvas");
var image = ctx.toDataURL();
document.getElementById('base64').value = image;

var base64 = $('#base64').val();

var data = new FormData();
var url = '../../public/orden-mantenimiento/modelo/finalizar-orden-mantenimiento.php';

data.append('idReporte', idReporte);
data.append('tipoFirma', 'A');
data.append('base64', base64);

alertify.confirm('',
 function(){

$(".LoaderPage").show();

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
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al finalizar'); 
     }
     
    });

    },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea finalizar la orden de compra?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

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

    <h5>Orden de Mantenimiento</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

   <div class="row">
  
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
    
  <div class="border p-3">
  
  <div class="table-responsive"> 
   <table class="table table-sm table-bordered mb-3" style="font-size: .9em;">
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

    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mb-1">
      <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="TipoServicio" id="Predictivo" value="1" onChange="EditTM(<?=$GET_idReporte;?>, 1, 1)" <?php if($tipomantenimiento == 1){echo 'checked';} ?> >
      <label class="form-check-label" for="Predictivo">Predictivo</label>
    </div>
    </div>


    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mb-1">
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="TipoServicio" id="Preventivo" value="2" onChange="EditTM(<?=$GET_idReporte;?>, 1, 2)" <?php if($tipomantenimiento == 2){echo 'checked';} ?>>
      <label class="form-check-label" for="Preventivo">Preventivo</label>
    </div>
    </div>

        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mb-1">
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="TipoServicio" id="Correctivo" value="3" onChange="EditTM(<?=$GET_idReporte;?>, 1, 3)" <?php if($tipomantenimiento == 3){echo 'checked';} ?>>
      <label class="form-check-label" for="Correctivo">Correctivo</label>
    </div>
    </div>


    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mb-1">
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="TipoServicio" id="Emergente" value="4" onChange="EditTM(<?=$GET_idReporte;?>, 1, 4)" <?php if($tipomantenimiento == 4){echo 'checked';} ?>>
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
      <input class="form-check-input" type="radio" name="Trabajo" id="Si" value="1" onChange="EditTM(<?=$GET_idReporte;?>, 2, 1)" <?php if($ordentrabajo == 1){echo 'checked';} ?> >
      <label class="form-check-label" for="Si">SI</label>
    </div>
    </div>

    <div class="col-4 mb-1">
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="Trabajo" id="No" value="2" onChange="EditTM(<?=$GET_idReporte;?>, 2, 2)" <?php if($ordentrabajo == 2){echo 'checked';} ?> >
      <label class="form-check-label" for="No">NO</label>
    </div>
    </div>

    <div class="col-4 mb-1">
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="Trabajo" id="Ambas" value="3" onChange="EditTM(<?=$GET_idReporte;?>, 2, 3)" <?php if($ordentrabajo == 3){echo 'checked';} ?> >
      <label class="form-check-label" for="Ambas">AMBAS</label>
    </div>
    </div>

    </div>
  </div>


<div class="table-responsive">
        <table class="table table-sm table-bordered mb-0" style="font-size: .9em;">
        <tr class="tables-bg">
            <th class="align-middle">Descripción</th>
            <th class="text-center align-middle ">Pruebas de seguimiento SRV</th>
          </tr>
        <tr>
          <td class="align-middle">Marco Normativo</td>
          <td class="align-middle bg-light p-0">
          <textarea class="form-control rounded-0" onKeyUp="EditTA(this,<?=$GET_idReporte;?>,7)" ><?=$marconormativo;?></textarea>
          </td>
        </tr>
        <tr>
            <td class="align-middle">Entrada en vigor:</td>
           <td class="align-middle bg-light p-0">
          <textarea class="form-control rounded-0" onKeyUp="EditTA(this,<?=$GET_idReporte;?>,8)"><?=$entradavigor;?></textarea>
          </td>
          </tr>
          <tr>
            <td class="align-middle">Estatus del tramite</td>
            <td class="align-middle bg-light p-0">
          <textarea class="form-control rounded-0" onKeyUp="EditTA(this,<?=$GET_idReporte;?>,9)"><?=$estatustramite;?></textarea>
          </td>
          </tr>
       </table>
  </div>

    </div>
    </div>
    


  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">

    <div class="border p-3">

    <div class="row">
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
         
<div class="table-responsive">
      <table class="table table-sm table-bordered mb-2" style="font-size: .9em;">
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
    $checkedTT = 'checked';
    }else{
    $checkedTT = '';
    }

  echo '<tr>
       <td>'.$row_tt['trabajo'].'</td>
       <td class="align-middle text-center" width="30"><input type="checkbox" '.$checkedTT.' id="Trabajo'.$idTT.'" onChange="EditTM('.$idTT.', 13, 0)"></td>
       <td class="p-0 m-0"><input type="text" class="form-control rounded-0 border-0" value="'.$row_tt['detalle'].'" onKeyUp="EditTA(this,'.$idTT.',14)" /></td>
       </tr>';

  }
  ?>
  </tbody>
       </table>
        </div>
        </div>



  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">

        <div class="table-responsive">
          <table class="table table-sm table-bordered" style="font-size: .9em;">
          <tr class="tables-bg">
            <th colspan="2" class="text-center align-middle">Área</th>
          </tr>
          <tbody>
  <?php  
  $sql_lista = "SELECT * FROM op_orden_mantenimiento_area WHERE id_mantenimiento = '".$GET_idReporte."' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

    $id  = $row_lista['id'];

    if($row_lista['estatus'] == 1){
    $checked = 'checked';
    }else{
    $checked = '';
    }

  echo '<tr>
       <td>'.$row_lista['area'].'</td>
       <td class="align-middle text-center" width="30"><input type="checkbox" '.$checked.' id="Area'.$id.'" onChange="EditTM('.$id.', 12, 0)"></td>
       </tr>';
 
  }
  ?>
  </tbody>
       </table>
     </div>

        </div> 
       </div>


<div class="table-responsive">
       <table class="table table-sm table-bordered mt-2 mb-3" style="font-size: .9em;">
         <tr class="tables-bg">
           <th class="text-white">Descripción del trabajo realizado</th>
         </tr>
         <tr>
           <td class="p-0"><textarea class="form-control rounded-0" onKeyUp="EditTA(this,<?=$GET_idReporte;?>,10)"><?=$descripcion;?></textarea></td>
         </tr>
       </table>
</div>

 

  <div class="border p-3 mb-3">
    <h6 >SEGUIMIENTO A LA ORDEN DE SERVICIO:</h6>
    <hr>

  <div class="form-check">
    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="1" onChange="EditTM(<?=$GET_idReporte;?>, 3, 1)" <?php if($seguimiento == 1){echo 'checked';} ?>>
    <label class="form-check-label" for="exampleRadios1">
      1. Detenida por falta de refacciones
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="2" onChange="EditTM(<?=$GET_idReporte;?>, 3, 2)" <?php if($seguimiento == 2){echo 'checked';} ?>>
    <label class="form-check-label" for="exampleRadios2">
      2. En proceso     
    </label>
  </div>
  <div class="form-check disabled">
    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="3" onChange="EditTM(<?=$GET_idReporte;?>, 3, 3)" <?php if($seguimiento == 3){echo 'checked';} ?> >
    <label class="form-check-label" for="exampleRadios3">
      3. No autorizada para su reparación
    </label>
  </div>
  <div class="form-check disabled">
    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" value="4" onChange="EditTM(<?=$GET_idReporte;?>, 3, 4)" <?php if($seguimiento == 4){echo 'checked';} ?>>
    <label class="form-check-label" for="exampleRadios4">
      4. Terminada
    </label>
  </div>

<div class="mt-1">
  Trabajo terminado en tiempo y forma: <br> <b>Si</b> <input type="radio" name="TrabajoTerminado" onChange="EditTM(<?=$GET_idReporte;?>, 4, 1)" <?php if($trabajoterminado == 1){echo 'checked';} ?>> <b>No</b> <input type="radio" name="TrabajoTerminado" onChange="EditTM(<?=$GET_idReporte;?>, 4, 2)" <?php if($trabajoterminado == 2){echo 'checked';} ?>>
</div>

<div class="mt-2">
Contrato vigente con el prestador de servicio: <br> <b>Si</b> <input type="radio" name="ContratoVigente" onChange="EditTM(<?=$GET_idReporte;?>, 5, 1)" <?php if($contratovigente == 1){echo 'checked';} ?>> <b>No</b> <input type="radio" name="ContratoVigente" onChange="EditTM(<?=$GET_idReporte;?>, 5, 2)" <?php if($contratovigente == 2){echo 'checked';} ?>>
</div>

<div class="mt-2">
Garantia de trabajos: <br><b>Si</b> <input type="radio" name="GarantiaTrabajo" onChange="EditTM(<?=$GET_idReporte;?>, 6, 1)" <?php if($garantiatrabajo == 1){echo 'checked';} ?>> <b>No</b> <input type="radio" name="GarantiaTrabajo" onChange="EditTM(<?=$GET_idReporte;?>, 6, 2)" <?php if($garantiatrabajo == 2){echo 'checked';} ?>>
</div>
</div>



  <div id="ListaEvidencias"></div>


<div class="table-responsive">
       
       <table class="table table-sm table-bordered mb-0" style="font-size: .9em;">
         <tr class="tables-bg">
           <th>Observaciones del trabajo realizado</th>
         </tr>

         <tr>
           <td class="p-0"><textarea class="form-control rounded-0" onKeyUp="EditTA(this,<?=$GET_idReporte;?>,11)"><?=$obervaciones;?></textarea></td>
         </tr>

       </table>
</div>

       <hr>

          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
          <div class="mb-2 text-secondary text-center">Elaboró</div>
          <div id="signature-pad" class="signature-pad mt-2" >
          <div class="signature-pad--body">
          <canvas style="width: 100%; height: 150px; border: 1px black solid;" id="canvas"></canvas>
          </div>
          <input type="hidden" name="base64" value="" id="base64">
          </div> 
          <div class="text-end mt-2">
          <button class="btn btn-info btn-sm text-white" onclick="resizeCanvas()"><small>Limpiar</small></button>
          </div>
          </div>

          <hr>

        <div class="text-end">
        <button type="button" class="btn btn-primary" onclick="Finalizar(<?=$GET_idReporte;?>)">Finalizar</button>
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



  <div class="modal" id="Modal">
  <div class="modal-dialog">
  <div class="modal-content" style="margin-top: 83px;">
  <div id="ContenidoModal"></div>    
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
