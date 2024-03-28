<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}


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
  <div class="row">

  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3">

    <div class="row">
    <div class="col-11">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">
    <h5>Acuses de Recepción editar</h5>
    </div>
    </div>

    </div>
    </div>
    <hr>

    <div class="text-end">
    <button type="button" class="btn btn-sm btn-danger" onclick="EliminarAcuse(<?=$GET_idReporte;?>)">Eliminar acuse</button>
    </div>

    <div class="row">
      <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">

      <h5><?=FormatoFecha($Fecha);?></h5>

      <div class="mb-1 text-secondary mt-2 mb-2">Empresa:</div>
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
      <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12">

         <h5>Documentos a entregar</h5>

        <div class="border p-2">
        <div class="row">
          <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12">
            <div class="mb-2 text-secondary mt-2">Nombre del documento:</div>
            <textarea class="form-control rounded-0" rows="1" id="NomDocumento"></textarea>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
            <div class="mb-2 text-secondary mt-2">Número paginas:</div>
            <input type="number" class="form-control rounded-0" id="NumPaginas">
          </div>

          <div class="col-xl-1 col-lg-1 col-md-1 col-sm-6">
            <div class="mb-2 text-secondary mt-2 text-center">Original:</div>
            <div class="text-center"><input type="checkbox" id="Original" /></div>
          </div>

          <div class="col-xl-1 col-lg-1 col-md-1 col-sm-6">
            <div class="mb-2 text-secondary mt-2 text-center">Copia:</div>
            <div class="text-center"><input type="checkbox" id="Copia" /></div>
          </div>
        </div>

        <div class="text-end mt-2">
          <button type="button" class="btn btn-sm btn-primary" onclick="Guardar(<?=$GET_idReporte;?>)">Agregar documento</button>
        </div>

        <hr>

        <div id="ListaDocumentos"></div>

        </div>
        
      </div>
    </div>

    <hr>

    <div class="text-end">
    <button type="button" class="btn btn-success" onclick="Finalizar(<?=$GET_idReporte;?>)">Finalizar acuse de recepción</button>
    </div>

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>


    <div class="modal" id="Modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="ContenidoModal"></div>
      </div>
    </div>
  </div>

      <div class="modal" id="ModalComentario">
    <div class="modal-dialog">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="DivContenidoComentario"></div>
      </div>
    </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
