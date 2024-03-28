
<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

  function IdReporte($GET_idEstacion,$GET_year,$GET_mes,$con){
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


  ListaResumen(<?=$IdReporte;?>,<?=$GET_mes;?>);
  ListaResumenTotal(<?=$IdReporte;?>,<?=$GET_mes;?>);

  ListaControl(<?=$IdReporte;?>);
  ListaPrefijos(<?=$GET_idEstacion;?>,<?=$IdReporte;?>);
  PrefijoTotal(<?=$GET_idEstacion;?>,<?=$IdReporte;?>);
   
  }); 

  function Regresar(){  
   window.history.back();
  }

 function ListaResumen(IdReporte,mes){ 
  $('#ListaResumen').load('../../../../public/admin/vistas/resumen-control-volumetrico.php?IdReporte=' + IdReporte + '&Mes=' + mes);
  }

    function ListaResumenTotal(IdReporte,mes){
  $('#ListaResumenTotal').load('../../../../public/admin/vistas/resumen-control-volumetrico-total.php?IdReporte=' + IdReporte + '&Mes=' + mes);
  } 

  function Comentario(id){
  var Comentario = $('#Comentario' + id).val();

  var parametros = {
    "id" : id,
    "Comentario" : Comentario
    };

      $.ajax({
     data:  parametros,
     url:   '../../../../public/admin/modelo/agregar-comentario-control-volumetrico.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {

    }else{
    alertify.error('Error al eliminar')
   
    }

     }
     });
  
  }

  function Edit(dato,dif,id,total,IdReporte,mes){

  var input = $('#' + dato + id).val();
  
  var parametros = {
    "dato" : dato,
    "id" : id,
    "input" : input
    };

     $.ajax({
     data:  parametros,
     url:   '../../../../public/admin/modelo/editar-control-volumetrico.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {

      if(dif == 1){
      var Diferencia = $('#1'+ id).val() - $('#2' + id).val();;
      $('#D' + dif + id).text(Diferencia); 
      }else if(dif == 2){
      var Diferencia = $('#3'+ id).val() - $('#4' + id).val();;
      $('#D' + dif + id).text(Diferencia); 
      }else if(dif == 3){
      var Diferencia = $('#5'+ id).val() - $('#6' + id).val();;
      $('#D' + dif + id).text(Diferencia); 
      }else if(dif == 4){
      var Diferencia = $('#7'+ id).val() - $('#8' + id).val();;
      $('#D' + dif + id).text(Diferencia); 
      }else if(dif == 5){
      var Diferencia = $('#9'+ id).val() - $('#10' + id).val();;
      $('#D' + dif + id).text(Diferencia); 
      }

     
    ListaResumenTotal(IdReporte,mes);

    }else{
    alertify.error('Error al actualizar')
   
    }

     }
     });

  }

function EditAceites(val,type,IdReporte){
 
Total = val.value;

var parametros = {
    "type" : type,
    "Total" : Total,
    "IdReporte" : IdReporte
    };

       $.ajax({
     data:  parametros,
     url:   '../../../../public/admin/modelo/editar-control-volumetrico-aceite.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {

    var Diferencia = $('#Volumetrico').val() - $('#Contables').val();;
      $('#DiferenciaA').text(Diferencia); 




    }else{
    alertify.error('Error al editar')
   
    }

     }
     });

}
 
//------------------------------------------------------------------------------------------------------------------
  function ListaControl(IdReporte){

    $('#ListaControl').load('../../../../public/admin/vistas/lista-control-volumetrico.php?IdReporte=' + IdReporte);
  }
 
  function btnModal(){
  $('#Modal').modal('show');
  }

    function Guardar(IdReporte){

    var NombreDocumento = $('#NombreDocumento').val();
    var Documento = $('#Documento').val();

    var Fecha = $('#Fecha').val();
    var Anexos = $('#Anexos').val();

    var data = new FormData();
    var url = '../../../../public/admin/modelo/agregar-control-volumetrico.php';

    Documento = document.getElementById("Documento");
    Documento_file = Documento.files[0];
    Documento_filePath = Documento.value;

    if (Documento_filePath != "") {
    $('#Documento').css('border','');

    data.append('IdReporte', IdReporte);
    data.append('Documento_file', Documento_file);
    data.append('Fecha', Fecha);
    data.append('Anexos', Anexos);

    $(".LoaderPage").show();

    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

      $(".LoaderPage").hide();

    ListaControl(IdReporte);
    $('#Documento').css('border','');
    $('#Documento').val('');
    $('#Modal').modal('hide');

    });

    }else{
    $('#Documento').css('border','2px solid #A52525');
    }
    
  }

    function Eliminar(idReporte,id){

    var parametros = {
  "idReporte" : idReporte,
    "id" : id
    };

       $.ajax({
     data:  parametros,
     url:   '../../../../public/admin/modelo/eliminar-control-volumetrico.php',
     type:  'post',
     beforeSend: function() {
    $(".LoaderPage").show();
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {

    $(".LoaderPage").hide();
   
    ListaControl(idReporte);

    }else{
    alertify.error('Error al eliminar')
    $(".LoaderPage").hide();

    }

     }
     });

  }

//------------------------------------------------------------------------------------------------------------------------
  function ListaPrefijos(idEstacion,IdReporte){
    $('#ListaPrefijo').load('../../../../public/admin/vistas/lista-control-volumetrico-prefijo.php?IdReporte=' + IdReporte  + '&idEstacion=' + idEstacion);
  }

    function PrefijoTotal(idEstacion,IdReporte){

  $('#PrefijoTotal').load('../../../../public/admin/vistas/control-volumetrico-total-prefijo.php?IdReporte=' + IdReporte + '&idEstacion=' + idEstacion);

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

    <h5>Control volumétrico, <?=nombremes($GET_mes);?> <?=$GET_year;?></h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

  
  
<div class="row">

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">

<div id="ListaResumen" ></div>
<div id="ListaResumenTotal" ></div>

</div>



<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">

<div id="ListaPrefijo"></div>
<div id="PrefijoTotal"></div>
</div>

</div>


  </div>
  </div>
  </div>

  </div>
  </div>

  </div>



<div class="modal" id="Modal">
  <div class="modal-dialog" style="margin-top: 83px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar anexos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <div class="mb-1 text-secondary">Agregar fecha</div>
        <input type="date" class="form-control" id="Fecha">

        <div class="mb-1 mt-2 text-secondary">Agregar anexo</div>
        <select class="form-control" id="Anexos">
          <option></option>
          <option>Tirilla de inventarios</option>
          <option>Control de despachos</option>
          <option>Control volumétrico</option>
          <option>Acuse de recepción controles volumétricos</option>
          <option>Acuse de aceptación controles volumétricos</option>
          <option>Jarreo</option>
        </select>

        <div class="mb-1 mt-2 text-secondary">Agregar documento</div>
        <input class="form-control" type="file" id="Documento">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Guardar(<?=$IdReporte;?>)">Guardar</button>
      </div>
    </div>
  </div>
</div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>


