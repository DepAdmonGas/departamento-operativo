<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$sql = "SELECT * FROM op_rh_formatos WHERE id = '".$GET_idFormato."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$explode = explode(' ', $row['fecha']);
$HoraFormato = date("g:i a",strtotime($explode[1]));
$Localidad = $row['id_localidad'];
$formato = $row['formato'];

$status = $row['status'];
}




$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$Localidad."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

function Puesto($idPuesto,$con){
$sql = "SELECT puesto FROM op_rh_puestos WHERE id = '".$idPuesto."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$puesto = $row['puesto'];
}
return $puesto;
}

if($formato == 1){
$Titulo = 'Firmar Formato Alta '.$estacion;
}else if($formato == 2){
$Titulo = 'Firmar Formato Restructuración Personal '.$estacion;
}else if($formato == 3){
$Titulo = 'Firmar Formato Falta Personal '.$estacion;  
}else if($formato == 4){
$Titulo = 'Firmar Formato Baja Personal '.$estacion;    
}else if($formato == 5){
$Titulo = 'Firmar Formato Solicitud de Vacaciones '.$estacion;    
}else if($formato == 6){
$Titulo = 'Firmar Formato Ajuste Salarial '.$estacion;    
}

function NombrePersonal($id,$con){

$sql_personal = "SELECT nombre_completo, puesto FROM op_rh_personal WHERE id = '".$id."' ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);
while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$nombre = $row_personal['nombre_completo'];
$puesto = Puesto($row_personal['puesto'],$con); 
}
return $arrayName = array('nombre' => $nombre, 'puesto' => $puesto);
}

function NombreEstacion($id,$con){
$sql_listaestacion = "SELECT id, localidad FROM op_rh_localidades WHERE id = '".$id."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$return = $row_listaestacion['localidad'];  
}
return $return;
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
 
  <style media="screen">
  .grayscale {
    filter: opacity(50%); 
  }
  </style>

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  $('[data-toggle="tooltip"]').tooltip();

  });

  function Regresar(){
  window.history.back();
  }

  function CrearToken(idFormato){
    $(".LoaderPage").show();

    var parametros = {
    "idFormato" : idFormato
    }; 
   
    $.ajax({
    data:  parametros,
    url:   '../public/recursos-humanos/modelo/token-formatos.php',
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
 

    function FirmarFormato(idFormato,tipoFirma){

    var ctx = document.getElementById("canvas");
    var image = ctx.toDataURL();
    document.getElementById('base64').value = image;
    var base64 = $('#base64').val();
    var canvas = $('#canvas').val();

    var data = new FormData();
    var url = '../public/recursos-humanos/modelo/firmar-formato-elaboro.php';

    data.append('idFormato', idFormato);
    data.append('tipoFirma', tipoFirma);
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

     }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea finalizar el formato?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();


    }



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

     function CrearTokenEmail(idReporte){
    $(".LoaderPage").show();

    var parametros = {
    "idReporte" : idReporte
    };

    $.ajax({
    data:  parametros,
    url:   '../public/recursos-humanos/modelo/token-email.php',
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

      <h5>
    <?=$Titulo;?>
      </h5>

    </div>

    </div>
    </div>

    </div>

  <hr>


<div class="row justify-content-md-center">
<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12"> 

<?php if($formato == 1){ ?>
<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-2 mt-2">
<tbody>
<tr>
  <td>Alta del personal</td>
  <td rowspan="3" class="text-center align-middle"><b>ALTA DE PERSONAL</b></td>
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
  <td class="align-middle"><b>001</b></td>
</tr>
</tbody>
</table>  
</div>   

<hr>


<b>Lic. Alejandro Guzmán</b></br>
<b>Departamento de Recursos Humanos</b>
<div class="mt-2"> Buenos días por medio del presente solicito de su amable apoyo para realizar las siguientes altas de personal:</div>


<div class="table-responsive">
<table class="table table-sm table-bordered mt-3 pb-0 mb-0">
<thead class="tables-bg">
<tr>
        <th class="align-middle">Fecha de ingreso</th>
        <th class="align-middle">Nombre empleado</th>
        <th class="align-middle">Estación</th>

        <th class="align-middle">Puesto</th>
        <th class="align-middle">Identificacion Oficial</th>

        <th class="align-middle">CURP</th>
        <th class="align-middle">RFC</th>
        <th class="align-middle">NSS</th>
        <th class="align-middle text-end">Salario diario</th>
    <th class="align-middle">Detalle</th>
    <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>archivo-tb.png"></th>
  </tr>
</thead> 
<tbody>
<?php
$sql_lista = "SELECT * FROM op_rh_formatos_alta WHERE id_formulario = '".$GET_idFormato."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];


$Fecha = $row_lista['fecha_ingreso'];
$NombreC = $row_lista['nombres'].' '.$row_lista['apellido_p'].' '.$row_lista['apellido_m'];
$puesto = Puesto($row_lista['puesto'],$con);
$ine = $row_lista['ine'];
$curp = $row_lista['curp'];
$rfc = $row_lista['rfc'];
$nss = $row_lista['nss'];

$extensionCurp = pathinfo($curp, PATHINFO_EXTENSION);
$extensionRfc = pathinfo($rfc, PATHINFO_EXTENSION);
$extensionNss = pathinfo($nss, PATHINFO_EXTENSION);

if($extensionCurp == "pdf" || $extensionCurp == "jpg" || $extensionCurp == "png" || $extensionCurp == "txt" || $extensionCurp == "xml" || $extensionCurp == "jpeg"){
$detalleCurp = '<a href="'.RUTA_ARCHIVOS.'/documentos-personal/curp/'.$curp.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="CURP"></a>';

}else{
$detalleCurp = $curp;

}
  

if($extensionRfc == "pdf" || $extensionRfc == "jpg" || $extensionRfc == "png" || $extensionRfc == "txt" || $extensionRfc == "xml" || $extensionRfc == "jpeg"){
$detalleRfc = '<a href="'.RUTA_ARCHIVOS.'/documentos-personal/rfc/'.$rfc.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="RFC"></a>';

}else{
$detalleRfc = $rfc;

}
 

if($extensionNss == "pdf" || $extensionNss == "jpg" || $extensionNss == "png" || $extensionNss == "txt" || $extensionNss == "xml" || $extensionNss == "jpeg"){
$detalleNss = '<a href="'.RUTA_ARCHIVOS.'/documentos-personal/nss/'.$nss.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Numero de Seguro Social"></a>';

}else{
$detalleNss = $nss;

}
 

if($ine != ""){
$detalleIne = '<a href="'.RUTA_ARCHIVOS.'/documentos-personal/ine/'.$ine.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Identificacion Oficial"></a>';

}else{
$detalleIne = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
}



echo '<tr class="text-center align-middle">';
echo '<td class="align-middle">'.FormatoFecha($Fecha).'</td>';
echo '<td class="align-middle">'.$NombreC.'</td>';
echo '<td class="align-middle">'.$estacion.'</td>';
echo '<td class="align-middle">'.$puesto.'</td>';
echo '<td class="align-middle">'.$detalleIne.'</td>';
echo '<td class="align-middle">'.$detalleCurp.'</td>';
echo '<td class="align-middle">'.$detalleRfc.'</td>';
echo '<td class="align-middle">'.$detalleNss.'</td>';
echo '<td class="align-middle text-right">'.number_format($row_lista['sd'],2).'</td>';
echo '<td class="align-middle">'.$row_lista['detalle'].'</td>';
echo '<td class="align-middle text-center"><a class="pointer" href="'.RUTA_IMG_ICONOS.''.$Documento.'" download><img src="'.RUTA_IMG_ICONOS.'archivo-tb.png" data-toggle="tooltip" data-placement="top" title="Archivos"></a></td>';
echo '</tr>';
}
}else{
echo "<tr><td colspan='15' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>

</tbody>
</table>
</div>


<div class="mt-3 text-center">
Sin más por el momento quedo de usted.
</div>
<hr>



<?php }else if($formato == 2){ ?>

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
$observaciones = $rowDetalle['observaciones'];
}

$Personal = NombrePersonal($idusuario,$con);
?>
 

<div class="table-responsive">
  <table class="table table-bordered">
    <tr>
      <td class="font-weight-bold">Área o Departamento:</td>
      <td><?=NombreEstacion($Localidad,$con);?></td>
    </tr>
    <tr>
      <td class="font-weight-bold">Nombre completo:</td>
      <td><?=$Personal['nombre'];?></td>
    </tr>
    <tr>
      <td class="font-weight-bold">Número de días a disfrutar:</td>
      <td><?=$numdias;?></td>
    </tr>
    <tr>
      <td class="font-weight-bold">Del:</td>
      <td><?=FormatoFecha($fechainicio);?></td>
    </tr>
    <tr>
      <td class="font-weight-bold">Al:</td>
      <td><?=FormatoFecha($fechatermino);?></td>
    </tr>
    <tr>
      <td class="font-weight-bold">Regresando el:</td>
      <td><?=FormatoFecha($fecharegreso);?></td>
    </tr>
  </table>
</div>
 

<div class="font-weight-bold mb-1">Observaciones:</div>
<div class="border p-2"><?=$observaciones;?></div>
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

 

<div class="row">     

<?php if($status == 1){ ?>
<?php if($Session_IDUsuarioBD == 318){ ?>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
<div class="border p-3 mt-3">
<div class="mb-2 text-secondary text-center">FIRMA DE AUTORIZACIÓN</div>
<hr>
<h4 class="text-primary align-middle text-center">Token Móvil</h4>
<small class="text-secondary">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno</small>
<button class="btn btn-sm btn-light" onclick="CrearToken(<?=$GET_idFormato;?>)"><small>Crear nuevo token</small></button>
<button class="btn btn-sm btn-light" onclick="CrearTokenEmail(<?=$GET_idFormato;?>)"><small>Crear token vía email</small></button>
<div class="input-group mt-3">
  <input type="text" class="form-control" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button" onclick="AutorizacionFormato(<?=$GET_idFormato;?>,'B')">Firmar solicitud</button>
  </div>
</div>
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
?>


   

<?php if($status == 2){ ?>



<?php

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

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
<div class="border p-3 ">
<div class="mb-2 text-secondary text-center">FIRMA DE AUTORIZACIÓN</div>
<hr>
<h4 class="text-primary align-middle text-center">Token Móvil</h4>
<small class="text-secondary">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno</small>
<button class="btn btn-sm btn-light" onclick="CrearToken(<?=$GET_idFormato;?>)"><small>Crear nuevo token</small></button>
<button class="btn btn-sm btn-light" onclick="CrearTokenEmail(<?=$GET_idFormato;?>)"><small>Crear token vía email</small></button>
<div class="input-group mt-3">
  <input type="text" class="form-control" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button" onclick="AutorizacionFormato(<?=$GET_idFormato;?>,'C')">Firmar solicitud</button>
  </div>
</div>
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
    <div class="modal-content" style="margin-top: 83px;">
      <div class="modal-body">

       <h5 class="text-info">El token fue validado correctamente.</h5>
       <div class="text-secondary">El formato fue firmado.</div>


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
       <div class="text-secondary">El formato no fue firmado.</div>


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