    <?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
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
   ListaProcedimientos('<?=$GET_modulo?>');

  });
 
  function Regresar(){
   window.history.back();
  }

  function NewProcedimiento(idModulo){
   $('#Modal').modal('show');  
   $('#DivContenidoProcedimientos').load('../../public/procedimientos/vistas/modal-formulario-procedimientos.php?idModulo=' + idModulo);
  }

  function ListaProcedimientos(idModulo){
  $('#DivProcedimientos').load('../../public/procedimientos/vistas/lista-procedimientos-modulo.php?idModulo=' + idModulo);
  }

  function detalleProcedimiento(idProcedimiento){
  $('#Modal').modal('show'); 
  $('#DivContenidoProcedimientos').load('../../public/procedimientos/vistas/modal-detalle-procedimiento.php?idProcedimiento=' + idProcedimiento);

  }
 
  function agregarProcedimiento(idModulo){

  var Fecha = $('#fechaProcedimiento').val();
  var Titulo = $('#tituloProcedimiento').val();
  var Documento = $('#ArchivoProcedimiento').val();

  var data = new FormData();
  var url = '../../public/procedimientos/modelo/agregar-procedimiento-modulo.php';

  Documento = document.getElementById("ArchivoProcedimiento");
  Documento_file = Documento.files[0];
  Documento_filePath = Documento.value;


  //----- AJAX - COMUNICADO -----//
  if(Fecha != ""){
  $('#fechaProcedimiento').css('border',''); 

  if(Titulo != ""){
  $('#tituloProcedimiento').css('border','');

  if(Documento_filePath != ""){
  $('#Documento_filePath').css('border',''); 


  data.append('idModulo', idModulo);
  data.append('Fecha', Fecha);
  data.append('Titulo', Titulo);
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
      alertify.success('El procedimiento ha sido agregado exitosamente.');
       $(".LoaderPage").hide();
       $('#Modal').modal('hide'); 
       ListaProcedimientos(idModulo);
     
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al crear el procedimiento'); 
      $('#Modal').modal('hide'); 
     }
     
 
    }); 

  }else{
  $('#ArchivoProcedimiento').css('border','2px solid #A52525'); 
  }
  
  }else{
  $('#tituloProcedimiento').css('border','2px solid #A52525'); 
  }

  }else{
  $('#fechaProcedimiento').css('border','2px solid #A52525'); 
  }

  }
  
  
  function eliminarProcedimiento(idProcedimiento,idModulo){

    var parametros = {
    "idProcedimiento" : idProcedimiento
    };


alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   '../../public/procedimientos/modelo/eliminar-procedimiento-modulo.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
       $(".LoaderPage").hide();
       $('#Modal').modal('hide'); 
       alertify.success('Procedimiento eliminado exitosamente.');  
       ListaProcedimientos(idModulo);

    }else{
     alertify.error('Error al eliminar el procedimiento.');  
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el procedimiento seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    

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
    <div class="col-11">
    <h5>Procedimientos <?=$GET_modulo?></h5>
    </div>

    <div class="col-1">
     <img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="NewProcedimiento('<?=$GET_modulo?>')">
    </div>

    </div>

    </div>
    </div>

  <hr>  

  <div id="DivProcedimientos"></div>

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>


  <div class="modal" id="Modal">
<div class="modal-dialog">
<div class="modal-content" style="margin-top: 83px;">

<div id="DivContenidoProcedimientos"></div>

</div>
 </div>
  </div>

 




  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>
  
  </body>
  </html>
   