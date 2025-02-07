<?php
require('app/help.php');

  function IdReporte($GET_idEstacion,$GET_year,$GET_mes,$con){
  $idmes = 0;
  $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$GET_idEstacion."' AND year = '".$GET_year."' ";
  $result_year = mysqli_query($con, $sql_year);
  while($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)){
  $idyear = $row_year['id'];
  }

  $sql_mes = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '".$idyear."' AND mes = '".$GET_mes."' ";
  $result_mes = mysqli_query($con, $sql_mes);
  while($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)){
  $idmes = $row_mes['id'];
  }
 
  return $idmes;
  } 
 
  $IdReporte = IdReporte($GET_idEstacion,$GET_year,$GET_mes,$con);


  if($GET_mes == 1){
  $MesAnte = 12;
  $yearAnte = $GET_year - 1;

  }else{
  $MesAnte = $GET_mes - 1;
  $yearAnte = $GET_year;
  }

  $IdReporteAnt = IdReporte($GET_idEstacion,$yearAnte,$MesAnte,$con);

  if(ValidaFin($IdReporte,$con) == 0){
  AGregarDiretorio($IdReporte,$IdReporteAnt,$con);  
  }

  $comentario = Comentario($IdReporte,$con);

  function Comentario($IdReporte,$con){
  $sql = "SELECT id,comentario FROM op_factura_telcel_comentario WHERE id_mes = '".$IdReporte."' ";
  $result = mysqli_query($con, $sql);
  $num = mysqli_num_rows($result);

  if($num == 0){

  $sql_insert = "INSERT INTO op_factura_telcel_comentario (
    id_mes,
    comentario
    )
    VALUES 
    (
    '".$IdReporte."',
    ''
    )";
  mysqli_query($con, $sql_insert);

  }

  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
   $comentario = $row['comentario'];
   }

   return $comentario;
  }

  function ValidaFin($IdReporte,$con){

  $sql = "SELECT * FROM op_directorio_fin WHERE id_mes = '".$IdReporte."' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);  

  return $numero;
  }


  function AGregarDiretorio($IdReporte,$IdReporteA,$con){

  $sql_lista = "SELECT * FROM op_directorio WHERE id_mes = '".$IdReporteA."' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if($numero_lista > 0){

  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
  $sql_insert = "INSERT INTO op_directorio (
      id_mes,
      cuenta,
      puesto,
      clave
      )
      VALUES 
      (
      '".$IdReporte."',
      '".$row_lista['cuenta']."',
      '".$row_lista['puesto']."',
      '".$row_lista['clave']."'
      )";

  mysqli_query($con, $sql_insert);

  }

  $sqlFin = "INSERT INTO op_directorio_fin (id_mes) VALUES ('".$IdReporte."')";
  mysqli_query($con, $sqlFin);

  }

  }


  function statusDocs($idReporte,$detalle,$con){
  $sql_detalleDoc = "SELECT detalle FROM op_factura_telcel WHERE id_mes = '".$idReporte."' AND detalle = '".$detalle."' ";
  $result_detalleDoc = mysqli_query($con, $sql_detalleDoc);
  return $numero_detalleDoc = mysqli_num_rows($result_detalleDoc);

  }

  $statusFactura = statusDocs($IdReporte,'Factura',$con);
  $statusPago = statusDocs($IdReporte,'Pago',$con);
  

  if($statusFactura > 0){
  if($statusPago > 0){
  $alertDoc = '<span class="badge rounded-pill bg-success float-end">Pagado</span>'; 

  }else{
  $alertDoc = '<span class="badge rounded-pill bg-warning float-end">Factura disponible</span>'; 
  }

  }else{
    $alertDoc = '<span class="badge rounded-pill bg-danger float-end">Sin factura</span>'; 
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
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  ListaDirectorio(<?=$IdReporte;?>);
  ListaFacturas(<?=$IdReporte;?>);

  }); 

  function Regresar(){
   window.history.back();
  } 

  function ListaDirectorio(IdReporte){
  $('#ListaDirectorio').load('../../../../public/admin/vistas/lista-directorio.php?IdReporte=' + IdReporte);
  } 
  
  function ListaFacturas(IdReporte){
  $('#ListaFacturas').load('../../../../public/admin/vistas/lista-facturas-telcel.php?IdReporte=' + IdReporte);
  }

function btnModal(IdReporte){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('../../../../public/admin/vistas/modal-agregar-factura-telcel.php?IdReporte=' + IdReporte); 
  }  
    
  function Guardar(IdReporte){
    var Detalle = $('#Detalle').val();
    var Documento = $('#Documento').val();

    var data = new FormData();
    var url = '../../../../public/admin/modelo/agregar-factura-telcel.php';

    Documento = document.getElementById("Documento");
    Documento_file = Documento.files[0];
    Documento_filePath = Documento.value;

    if (Detalle != "") {
    $('#Detalle').css('border','');
    if (Documento_filePath != "") {
    $('#Documento').css('border','');

    data.append('IdReporte', IdReporte);
    data.append('Detalle', Detalle);
    data.append('Documento_file', Documento_file);

    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

    ListaFacturas(IdReporte);
    location.reload()
    alertify.success('Registro agregado exitosamente.');
    $('#Documento').css('border','');
    $('#Documento').val('');
    $('#Modal').modal('hide');
    
    });

    }else{
    $('#Documento').css('border','2px solid #A52525');
    }
    }else{
    $('#Detalle').css('border','2px solid #A52525');
    }
    
  }

  function Comentario(val,idreporte){

  var comentario = val.value;

    var parametros = {
    "comentario" : comentario,
    "idreporte" : idreporte
    };

         $.ajax({
     data:  parametros,
     url:   '../../../../public/admin/modelo/agregar-comentario-factura-telcel.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {


     }
     });


  }

  function btnModalDirectorio(IdReporte,id){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('../../../../public/admin/vistas/modal-agregar-directorio-telcel.php?IdReporte=' + IdReporte + '&id=' + id);   
  }
  
  function GuardarDirectorio(IdReporte,id){

    var Cuenta = $('#Cuenta').val();
    var Puesto = $('#Puesto').val();
    var Clave = $('#Clave').val();

    var parametros = {
    "IdReporte" : IdReporte,
    "id" : id,
    "Cuenta": Cuenta,
    "Puesto" : Puesto,
    "Clave" : Clave
    };

    if (Cuenta != "") {
    $('#Cuenta').css('border','');
    if (Puesto != "") {
    $('#Puesto').css('border','');
    if (Clave != "") {
    $('#Clave').css('border','');

    $.ajax({
    data:  parametros,
    url:   '../../../../public/admin/modelo/agregar-directorio-telcel.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    $('#Modal').modal('hide');  
    ListaDirectorio(IdReporte) 
    alertify.success('Registro actualizado exitosamente.');
    }else{
    alertify.success('Error al agregar');    
    }

    }
    });

  }else{
    $('#Clave').css('border','2px solid #A52525');
    }
    }else{
    $('#Puesto').css('border','2px solid #A52525');
    }
  }else{
    $('#Cuenta').css('border','2px solid #A52525');
    }

  }

  function EliminarFactura(IdReporte,id){

  var parametros = {
    "idFactura" : id
    };


alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   '../../../../public/admin/modelo/eliminar-factura-telcel.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    ListaFacturas(IdReporte);
    alertify.success('Registro eliminado exitosamente.'); 
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el archivo seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();


  }

  function Eliminar(IdReporte,id){

    var parametros = {
    "id" : id
    };


alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   '../../../../public/admin/modelo/eliminar-directorio-telcel.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

   if (response == 1) {
    ListaDirectorio(IdReporte)
    alertify.success('Registro eliminado exitosamente.');  
    }

    }
    });

  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la siguiente información?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

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

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.go(-1)"  class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Solicitud de cheques, <?=$ClassHerramientasDptoOperativo->nombremes($GET_mes);?> <?=$GET_year;?></a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Facturas Telcel, <?=$ClassHerramientasDptoOperativo->nombremes($GET_mes);?> <?=$GET_year;?> </li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase"> <?=$alertDoc?></li>
  </ol>
  </div>
  
  <div class="row"> 
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 mb-1"> 
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Facturas Telcel, <?=$ClassHerramientasDptoOperativo->nombremes($GET_mes);?> <?=$GET_year;?></h3> 
  </div>

  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mt-1"> 
  <?php if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Comercializadora" && $session_nompuesto != "Dirección de operaciones servicio social") { ?>
  <div class="text-end">
  <div class="dropdown d-inline ms-2">
  <button type="button" class="btn dropdown-toggle btn-primary" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-screwdriver-wrench"></i></button>
  <ul class="dropdown-menu">
  <li onclick="btnModalDirectorio(<?=$IdReporte;?>,0)"> <a class="dropdown-item pointer"><i class="fa-solid fa-address-book"></i></i> Agregar Directorio </a> </li>
  <li onclick="btnModal(<?=$IdReporte;?>)"><a class="dropdown-item pointer"><i class="fa-regular fa-file-lines"></i> Agregar Factura</a></li>
  </ul>
  </div>
  </div>
  <?php } ?>
  </div>

  </div>
  <hr>
  </div>

 
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
  <div id="ListaDirectorio"></div>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
  <div class="row"> 

  <div class="col-12 mb-3" id="ListaFacturas"></div>

  <div class="col-12">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 12.5px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">Observaciones:</th> </tr>
  </thead>
  <tbody>
  <tr class="no-hover">
  <th class="align-middle text-center bg-white p-0">  
  <textarea class="form-control border-0" placeholder="Escribe aqui tus observaciones..." style="height: 180px;" onkeyup="Comentario(this,<?=$IdReporte;?>)"><?=$comentario;?></textarea>
  </th>
  </tr>
  </tbody>
  </table>
  </div>
  </div>


  </div>
  </div>


  </div>
  </div>

  </div>


  <!---------- MODAL ----------> 
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="ContenidoModal">
  </div>
  </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>
  
  </body>
  </html>

