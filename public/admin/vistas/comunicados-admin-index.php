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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

 
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
   ListaComunicados();
  });


  function Regresar(){
   window.history.back();
  }
 
  
  function ListaComunicados(){
  $('#DivComunicados').load('../public/admin/vistas/lista-comunicados.php');
  }
 
 
  function detalleComunicado(idComunicado){
	$('#ModalPDF').modal('show'); 
    $('#DivComunicadoPDF').load('../public/admin/vistas/modal-detalle-comunicados.php?idComunicado=' + idComunicado);

  }
 

  function NewComunicado(){
   $('#Modal').modal('show');  
   $('#DivContenidoComunicados').load('../public/admin/vistas/modal-formulario-comunicados.php');
  }

  function DocumentoComunicado(){

  var Fecha = $('#fechaComunicado').val();
  var Titulo = $('#tituloComunicado').val();
  var Documento = $('#ArchivoComunicado').val();

  var data = new FormData();
  var url = '../public/admin/modelo/agregar-comunicado-admin.php';

  Documento = document.getElementById("ArchivoComunicado");
  Documento_file = Documento.files[0];
  Documento_filePath = Documento.value;


  //----- AJAX - COMUNICADO -----//
  if(Fecha != ""){
  $('#fechaComunicado').css('border',''); 

  if(Titulo != ""){
  $('#tituloComunicado').css('border','');

  if(Documento_filePath != ""){
  $('#Documento_filePath').css('border',''); 


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
      alertify.success('El comunicado se ha creado de manera exitosa.');
       $(".LoaderPage").hide();
       $('#Modal').modal('hide'); 
       ListaComunicados();
     
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al crear un nuevo comunicado'); 
      $('#Modal').modal('hide'); 
     }
     

    }); 

  }else{
  $('#ArchivoComunicado').css('border','2px solid #A52525'); 
  }
  
  }else{
  $('#tituloComunicado').css('border','2px solid #A52525'); 
  }

  }else{
  $('#fechaComunicado').css('border','2px solid #A52525'); 
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
    <div class="col-11">
     <h5>Comunicados</h5>
    </div>

    <div class="col-1">
     <img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="NewComunicado()">
    </div>

    </div>

    </div>
    </div>

  <hr>

<div id="DivComunicados"></div>

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>



<div class="modal" id="Modal">
<div class="modal-dialog">
<div class="modal-content" style="margin-top: 83px;">

<div id="DivContenidoComunicados"></div>

</div>
 </div>
  </div>

 

<div class="modal fade bd-example-modal-lg" id="ModalPDF">
<div class="modal-dialog modal-lg">
<div class="modal-content" style="margin-top: 83px;">

<div id="DivComunicadoPDF"></div>

</div>
 </div>
  </div>



  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>


  </body>
  </html>
           