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

  var margint = 140;
  var ventana_alto = $(document).height();
  ResultAlto = ventana_alto -margint;
  box = document.getElementsByClassName('tableFixHead')[0];
  box.style.height = ResultAlto + 'px';

  ListaMonedero(<?=$GET_year;?>,<?=$GET_mes;?>);
  });
 
  function Regresar(){
   window.history.back();
  }
 
function ListaMonedero(year,mes){

  $('#Monedero').load('../../public/corte-diario/vistas/lista-resumen-monedero.php?year=' + year + '&mes=' + mes);
}

function ListaModal(IdReporte){
$('#Modal').modal('show');
 
  $('#ListaDocumento').load('../../public/corte-diario/vistas/lista-monedero-documento.php?IdReporte=' + IdReporte);
}  

  function Editar(IdReporte,id){
   $('#ListaDocumento').load('../../public/corte-diario/vistas/editar-monedero-documento.php?IdReporte=' + IdReporte + '&id=' + id); 
  }

  function Cancelar(IdReporte){
  $('#ListaDocumento').load('../../public/corte-diario/vistas/lista-monedero-documento.php?IdReporte=' + IdReporte);
}
 
function EditarInfo(IdReporte,id){

  var Fecha = $('#Fecha').val();
    var Cilote = $('#Cilote').val();
    var Diferencia = $('#Diferencia').val();

    var data = new FormData();
    var url = '../../app/controlador/controladorCorteDiario.php/';
    //var url = '../../public/corte-diario/modelo/editar-documento-monedero.php';

    PDF = document.getElementById("PDF");
    PDF_file = PDF.files[0];
    PDF_filePath = PDF.value;

    XML = document.getElementById("XML");
    XML_file = XML.files[0];
    XML_filePath = XML.value;

    EXCEL = document.getElementById("EXCEL");
    EXCEL_file = EXCEL.files[0];
    EXCEL_filePath = EXCEL.value;


    data.append('id', id);
    data.append('Fecha', Fecha);
    data.append('Cilote', Cilote);
    data.append('Diferencia', Diferencia);
    data.append('XML_file', XML_file);
    data.append('PDF_file', PDF_file);
    data.append('EXCEL_file', EXCEL_file);
    data.append('accion','editar-documento-monedero');
    
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
      Cancelar(IdReporte);

    });

      }

function Edi(IdReporte,id){
   $('#ListaDocumento').load('../../public/corte-diario/vistas/editar-monedero-documento-edi.php?IdReporte=' + IdReporte + '&id=' + id); 
  }

  function GuardarC(IdReporte,id){

    var Complemento = $('#Complemento').val();

    var data = new FormData();
    data.append("accion", "guardar-documento-edi");
    var url = '../../app/controlador/controladorCorteDiario.php';
    //var url = '../../public/corte-diario/modelo/agregar-documento-monedero-edi.php';

    PDF = document.getElementById("PDF");
    PDF_file = PDF.files[0];
    PDF_filePath = PDF.value;

    XML = document.getElementById("XML");
    XML_file = XML.files[0];
    XML_filePath = XML.value;


    data.append('id', id);
    data.append('Complemento', Complemento);
    data.append('XML_file', XML_file);
    data.append('PDF_file', PDF_file);
    
    $(".LoaderPage").show();

    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){
      console.log(data);
      $(".LoaderPage").hide();
      Edi(IdReporte,id);

    });

      }

       function EliminarEdi(IdReporte,iddoc,id){

    var parametros = {
  "IdReporte" : IdReporte,
  "iddoc" : iddoc,
    "id" : id
    };

       $.ajax({
     data:  parametros,
     url:   '../../public/corte-diario/modelo/eliminar-documento-monedero-edi.php',
     type:  'post',
     beforeSend: function() {
    $(".LoaderPage").show();
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {

    $(".LoaderPage").hide();
   
    Edi(IdReporte,iddoc);
    
    }else{
    alertify.error('Error al eliminar')
    $(".LoaderPage").hide();

    }

     }
     });

  }
  </script>
 
  <style media="screen">

  .tableFixHead{
overflow-x: scroll;
  overflow-y: scroll;
}

.tableFixHead thead th{
  position: sticky;
  top: 0px;
  box-shadow: 2px 2px 4px #ECECEC;
}

.tableStyle{
  box-shadow: 0px 0px 0px #ECECEC;
}
  </style>

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

      <h5>
      Resumen Monedero, <?=nombremes($GET_mes);?> <?=$GET_year;?>
      </h5>

    </div>

    </div>

    </div>


    <div class="col-1">
    <img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>icon-lista.png" onclick="ListaModal(<?=$IdReporte;?>)">
    </div>

  </div>

  <hr>

  <div class="tableFixHead">
  <div id="Monedero"></div>
  </div>         

 
  </div>
  </div>
  </div>

  </div>
  </div>

  </div>


<div class="modal" id="Modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="margin-top: 83px;">
      <div class="modal-header">
        <h5 class="modal-title">Facturas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <div id="ListaDocumento"></div>
        
        

      </div>
    </div>
  </div>
</div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>


  </body>
  </html>

