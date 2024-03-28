<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

function IdReporte($Session_IDEstacion,$GET_year,$GET_mes,$con){
   $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$Session_IDEstacion."' AND year = '".$GET_year."' ";
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

   $IdReporte = IdReporte($Session_IDEstacion,$GET_year,$GET_mes,$con);
?>
<html lang="es">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?php echo RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?php echo RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>alertify.css">
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>themes/default.rtl.css">
  <link href="<?php echo RUTA_CSS ?>bootstrap.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>bootstrap-select.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?php echo RUTA_JS ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <style media="screen">
  .LoaderPage {
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url('../../imgs/iconos/load-img.gif') 50% 50% no-repeat rgb(249,249,249);
  }
  </style>
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  ListaDocumento(<?=$IdReporte;?>);

  });

  function Regresar(){
   window.history.back();
  }

  function Modal(){
  $('#Modal').modal('show');
  }

   function Guardar(idReporte){
    var Documento = $('#Documento').val();

    var data = new FormData();
    var url = '../../public/corte-diario/modelo/agregar-control-despacho.php';

    Documento = document.getElementById("Documento");
    Documento_file = Documento.files[0];
    Documento_filePath = Documento.value;

    if (Documento_filePath != "") {
    $('#Documento').css('border','');

    data.append('idReporte', idReporte);
    data.append('Documento_file', Documento_file);

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
    ListaDocumento(idReporte);
    $('#Documento').css('border','');
    $('#Documento').val('');
    $('#Modal').modal('hide');
    $(".LoaderPage").hide();
  }else{
    $(".LoaderPage").hide();
    $('#Documento').val('');
     alertify.error('Error al agregar el documento');
  }

    });

    }else{
    $('#Documento').css('border','2px solid #A52525');
    }
    
  }

  function ListaDocumento(IdReporte){
 $('#DivReporte').load('../../public/corte-diario/vistas/lista-cotrol-despacho.php?IdReporte=' + IdReporte);
  }

  
  </script>
  </head>
  <body>
<div class="LoaderPage"></div>
<div class="p-4">
<div class="card">
<div class="card-body">
    <div class="border-bottom pb-5">
    <div class="float-left"><h5 class="card-title"><img class="pr-2" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()"> Control de despacho, <?=nombremes($GET_mes);?> <?=$GET_year;?></h5></div> 

    <div class="float-right"><img src="<?=RUTA_IMG_ICONOS;?>mas.png" onclick="Modal()"></div> 

    </div>

<div id="DivReporte"></div>

</div>
</div>
</div>

<div class="modal" id="Modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar documento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <div class="mb-2 text-secondary">Agregar documento</div>
        <input type="file" id="Documento">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Guardar(<?=$IdReporte;?>)">Guardar</button>
      </div>
    </div>
  </div>
</div>

  <script src="<?php echo RUTA_JS ?>bootstrap.min.js"></script>
  </body>
  </html>

