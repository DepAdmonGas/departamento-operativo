<?php
require('app/help.php');

$sql = "SELECT * FROM op_acuse_recepcion WHERE id = '".$GET_idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$explode = explode(' ', $row['fecha_creacion']);
$Fecha = $explode[0];
$Empresa = $row['empresa'];
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

  ListaDocumentos(<?=$GET_idReporte;?>);

  });  


 function ListaDocumentos(idReporte){
  $('#ListaDocumentos').load('../../public/acuses-recepcion/vistas/lista-documentos.php?idReporte=' + idReporte);
 }

  function Regresar(){
  window.history.back();
  }

  function Guardar(idReporte){

    var NomDocumento = $('#NomDocumento').val();
    var NumPaginas = $('#NumPaginas').val();

    if( $('#Original').prop('checked') ) {
    ValOriginal = 1;
    }else{
    ValOriginal = 0;
    }

    if( $('#Copia').prop('checked') ) {
    ValCopia = 1;
    }else{
    ValCopia = 0;
    }

    var parametros = {
    "idReporte" : idReporte,
    "NomDocumento" : NomDocumento,
    "NumPaginas" : NumPaginas,
    "ValOriginal" : ValOriginal,
    "ValCopia" : ValCopia
    };

    if(NomDocumento != ""){
    $('#NomDocumento').css('border',''); 
    if(NumPaginas != ""){
    $('#NumPaginas').css('border',''); 

    $.ajax({
        data:  parametros,
        url:   '../../public/acuses-recepcion/modelo/agregar-documentos.php',
        type:  'post',
        beforeSend: function() {
        },
        complete: function(){

        },
        success:  function (response) {

          if(response == 1){

            $('#NomDocumento').val('');
            $('#NumPaginas').val('');
            $('#Original').prop("checked", false);
            $('#Copia').prop("checked", false);

            ListaDocumentos(idReporte)
            alertify.success('Documento agregado exitosamente.');

          }
        }
        });

    }else{
    $('#NumPaginas').css('border','2px solid #A52525'); 
    } 
    }else{
    $('#NomDocumento').css('border','2px solid #A52525'); 
    } 

  }

  function Eliminar(idReporte,idDocumento){

    var parametros = {
    "id" : idDocumento,
    "dato" : 2
    }; 

alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   '../../public/acuses-recepcion/modelo/eliminar-acuse-recepcion.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {

   ListaDocumentos(idReporte)  
   alertify.success('Documento eliminado exitosamente.');

    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();  

  }

  function EliminarAcuse(idReporte){
     var parametros = {
    "id" : idReporte,
    "dato" : 1
    }; 

alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   '../../public/acuses-recepcion/modelo/eliminar-acuse-recepcion.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {

      Regresar()
    
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();  
  }

  function Finalizar(idReporte){

var DataEmpresa = $('#DataEmpresa').val();

if(DataEmpresa != ""){
$('#DataEmpresa').css('border',''); 

var parametros = {
    "id" : idReporte,
    "DataEmpresa" : DataEmpresa,
    "dato" : 1
    };

    alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   '../../public/acuses-recepcion/modelo/finalizar-acuse-recepcion.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {

      Regresar()
    
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea finalizar el acuse de recepción?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}else{
$('#DataEmpresa').css('border','2px solid #A52525'); 
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
  <div class="cardAG p-3 container">
  <div class="row">


  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item" onclick="history.back()"><a class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Acuses de Recepción</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Formulario Acuses de Recepción</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-1">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Formulario Acuses de Recepción</h3>
  </div>
  
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-1">
  <div class="text-end">
  <button type="button" class="btn btn-labeled2 btn-danger ms-2" onclick="EliminarAcuse(<?=$GET_idReporte;?>)">
  <span class="btn-label2"><i class="fa-regular fa-trash-can"></i></span>Eliminar acuse</button>

  <button type="button" class="btn btn-labeled2 btn-success ms-2" onclick="Finalizar(<?=$GET_idReporte;?>)">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Finalizar Acuse</button>
  </div>
  </div>

  </div>

  <hr>
  </div>


  <div class="col-12 mb-3">
  <div class="text-secondary">Fecha:</div>
  <?=$ClassHerramientasDptoOperativo->FormatoFecha($Fecha)?>
  </div>

  <div class="col-12">
  <div class="mb-1 text-secondary mb-1">Empresa:</div>
  <input class="form-control rounded-0" type="text" multiple list="Empresa" id="DataEmpresa" value="<?=$Empresa;?>" />
  <datalist id="Empresa">
  <?php 
  $sql = "SELECT razonsocial FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
  $result = mysqli_query($con, $sql);
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  echo '<option value="'.$row['razonsocial'].'">'.$row['razonsocial'].'</option>';
  }
  ?>
  </datalist>
  </div>


  <div class="col-12">
  <hr>

  <div class="row">
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
  <h5>Documentos a entregar</h5>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
  <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Guardar(<?=$GET_idReporte;?>)">
  <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar documento</button>
  </div>

  <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12  mb-3">
    <div class="mb-2 text-secondary mt-2">Nombre del documento:</div>
    <textarea class="form-control rounded-0" rows="1" id="NomDocumento"></textarea>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12  mb-3">
    <div class="mb-2 text-secondary mt-2">Número paginas:</div>
    <input type="number" class="form-control rounded-0" id="NumPaginas">
  </div>

  <div class="col-xl-1 col-lg-1 col-md-1 col-sm-6 mb-3">
    <div class="mb-2 text-secondary mt-2 text-center">Original:</div>
    <div class="text-center"><input type="checkbox" id="Original" /></div>
  </div>

  <div class="col-xl-1 col-lg-1 col-md-1 col-sm-6 mb-3">
    <div class="mb-2 text-secondary mt-2 text-center">Copia:</div>
    <div class="text-center"><input type="checkbox" id="Copia" /></div>
  </div>

  <div class=" col-12" id="ListaDocumentos"></div>
  </div>
  </div>


  </div>
  </div>
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
