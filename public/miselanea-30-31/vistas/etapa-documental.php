<?php
require('app/help.php');

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
  <link href="<?=RUTA_CSS2;?>navbar-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="<?=RUTA_JS?>size-window.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
  <script type="text/javascript" src="<?=RUTA_JS ?>alertify.js"></script> 


  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow()
  if(sessionStorage){
  if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {
  idestacion = sessionStorage.getItem('idestacion');
  idYear = sessionStorage.getItem('idYear');
  SelEstacion(idestacion,idYear);   
  }
  }

  });

function Regresar(){window.history.back();}

function SelEstacion(idEstacion,idYear){
sizeWindow()
sessionStorage.setItem('idestacion', idEstacion);
sessionStorage.setItem('idYear', idYear);

$('#ListaDocumentos').load('../../public/miselanea-30-31/vistas/lista-etapa-documental.php?idEstacion=' + idEstacion + '&idYear=' + idYear);
}


function SelEstacion(idEstacion,idYear){
  let targets;
  targets = [2];

  $('#ListaDocumentos').load('../../public/miselanea-30-31/vistas/lista-etapa-documental.php?idEstacion=' + idEstacion + '&idYear=' + idYear, function() {
  $('#tabla_documentos_' + idEstacion + '_' + idYear).DataTable({
  "language": {
  "url": "<?=RUTA_JS2?>/es-ES.json"
  },
  "order": [[0, "asc"]],
  "lengthMenu": [25, 50, 75, 100],
  "columnDefs": [
  { "orderable": false, "targets": targets },
  { "searchable": false, "targets": targets }
  ]
  });
  });
  
  }


function Modal(idDocumento,idEstacion,idYear){
$('#ModalDocumento').modal('show');  
$('#DivContenido').load('../../public/miselanea-30-31/vistas/modal-documentos.php?idDocumento=' + idDocumento + '&idEstacion=' + idEstacion + '&idYear=' + idYear);
}

function Guardar(idDocumento,idEstacion,idYear){

var Detalle = $('#Detalle').val();
Documento = document.getElementById("Documento");
Documento_file = Documento.files[0];
Documento_filePath = Documento.value;

if(Detalle != ""){
$('#Detalle').css('border','');

if(Documento_filePath != ""){
$('#Documento').css('border','');

var data = new FormData();
var url = '../../public/miselanea-30-31/modelo/agregar-documento.php';

data.append('idEstacion', idEstacion);
data.append('idYear', idYear);
data.append('idDocumento', idDocumento);
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

    if(data == 1){
SelEstacion(idEstacion,idYear)
$('#DivContenido').load('../../public/miselanea-30-31/vistas/modal-documentos.php?idDocumento=' + idDocumento + '&idEstacion=' + idEstacion + '&idYear=' + idYear);
alertify.success('Documento agregado exitosamente.')
     }else{
      alertify.error('Error al guardar el documento'); 
     }
     
    }); 

}else{
$('#Documento').css('border','2px solid #A52525'); 
}

}else{
$('#Detalle').css('border','2px solid #A52525'); 
}

}

function Eliminar(idDocumento,id,idEstacion,idYear){

    var parametros = {
        "id" : id
        };

        alertify.confirm('',
        function(){

        $.ajax({
        data:  parametros,
        url:   '../../public/miselanea-30-31/modelo/eliminar-documento.php',
        type:  'post',
        beforeSend: function() {
        },
        complete: function(){

        },
        success:  function (response) {

          if(response == 1){
            SelEstacion(idEstacion,idYear)
          $('#DivContenido').load('../../public/miselanea-30-31/vistas/modal-documentos.php?idDocumento=' + idDocumento + '&idEstacion=' + idEstacion + '&idYear=' + idYear);
          alertify.success('Documento eliminado exitosamente.')

        
        }else{
          alertify.error('Error al eliminar');    
          }

        }
        });

      },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el documento seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}

  </script>
  </head> 
  
  <body>

  <div class="LoaderPage"></div>
  
 <div class="wrapper">

<!---------- SIDE BAR (LEFT) ---------->  
  <nav id="sidebar">
  
  <div class="sidebar-header text-center">
  <img class="" src="<?=RUTA_IMG_LOGOS."Logo.png";?>" style="width: 100%;">
  </div>

  <ul class="list-unstyled components">
   
    <li>
    <a class="pointer" onclick="history.back()">
    <i class="fa-solid fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
    </a>
    </li>
   
  <?php

  $FInicio = date("Y").'-'.date("m").'-01';
  $FTermino = date("Y-m-t", strtotime($FInicio));

  $sql_listaestacion = "SELECT id, nombre, volumetrico FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);
  while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
  $id = $row_listaestacion['id'];
  $estacion = $row_listaestacion['nombre'];


  echo '<li>
    <a class="pointer" onclick="SelEstacion('.$id.','.$GET_idYear.')">
    <i class="fa-solid fa-gas-pump"" aria-hidden="true" style="padding-right: 10px;"></i>'.$estacion.'
    </a>
    </li> ';

  }
  ?> 

    <li>
    <a class="pointer" onclick="SelEstacion(9,<?=$GET_idYear;?>)">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>Ventura Puente
    </a>
    </li>

  </ul>
   
  </nav>

  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <?php include_once "public/navbar/navbar-principal.php";?>
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">

  <div class="row">  
  
  <div class="col-12" id="ListaDocumentos"></div> 

  </div>
  </div>
  </div>

 </div>

  <!---------- MODAL ----------> 
  <div class="modal fade" id="ModalDocumento" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
  <div class="modal-content" id="DivContenido">
  </div>
  </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

  </body>
  </html>