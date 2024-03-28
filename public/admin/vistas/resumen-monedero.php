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
   $IdReporte = IdReporte($GET_idEstacion,$GET_year,$GET_mes,$con);
  

   $sql_listaestacion = "SELECT id, nombre FROM tb_estaciones WHERE id = '".$GET_idEstacion."'";
   $result_listaestacion = mysqli_query($con, $sql_listaestacion);
   while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
    $id = $row_listaestacion['id'];
    $estacion = $row_listaestacion['nombre'];
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  
  <script type="text/javascript">
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  $('[data-toggle="tooltip"]').tooltip();

  var margint = -550;
  var ventana_alto = $(document).height();
  ResultAlto = ventana_alto - margint;
  box = document.getElementsByClassName('tableFixHead')[0];
  box.style.height = ResultAlto + 'px';

  ListaMonedero(<?=$GET_idEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>);
  });
  
  function Regresar(){
   window.history.back();
  }
 
function ListaMonedero(idEstacion,year,mes){

  $('#Monedero').load('../../../../public/admin/vistas/lista-resumen-monedero.php?year=' + year + '&mes=' + mes + '&idEstacion=' + idEstacion);
}
 
function ListaModal(IdReporte,year,mes){
$('#Modal').modal('show');
$('#ListaDocumento').load('../../../../public/admin/vistas/lista-monedero-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
} 
 
function Nuevo(IdReporte,year,mes){
 $('#ListaDocumento').load('../../../../public/admin/vistas/formulario-monedero-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
} 
  
function Cancelar(IdReporte,year,mes){
  $('#ListaDocumento').load('../../../../public/admin/vistas/lista-monedero-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
}

function Guardar(IdReporte,year,mes){
 
    var Fecha = $('#Fecha').val();
    var Cilote = $('#Cilote').val();
    var Diferencia = $('#Diferencia').val();

    var data = new FormData();
    var url = '../../../../public/admin/modelo/agregar-documento-monedero.php';
   
    PDF = document.getElementById("PDF");
    PDF_file = PDF.files[0];
    PDF_filePath = PDF.value;
 
    XML = document.getElementById("XML");
    XML_file = XML.files[0];
    XML_filePath = XML.value;

    if (Fecha != "") {
    $('#Fecha').css('border','');   
    if (Cilote != "") {
    $('#Cilote').css('border',''); 
    if (PDF_filePath != "") {
    $('#PDF').css('border','');
    if (XML_filePath != "") {
    $('#XML').css('border','');

    data.append('IdReporte', IdReporte);
    data.append('year', year);
    data.append('mes', mes);
    data.append('Fecha', Fecha);
    data.append('Cilote', Cilote);
    data.append('Diferencia', Diferencia);
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
 
    $(".LoaderPage").hide();
    Cancelar(IdReporte,year,mes);

    });

    }else{
    $('#XML').css('border','2px solid #A52525');
    }
    }else{
    $('#PDF').css('border','2px solid #A52525');
    }
    }else{
    $('#Cilote').css('border','2px solid #A52525');
    }
    }else{
    $('#Fecha').css('border','2px solid #A52525');
    }
    
}

  function Eliminar(IdReporte,year,mes,id){
  $('#Eliminar').tooltip('hide');

    var parametros = {
    "IdReporte" : IdReporte,
    "id" : id
    };
 
     $.ajax({
     data:  parametros,
     url:   '../../../../public/admin/modelo/eliminar-documento-monedero.php',
     type:  'post',
     beforeSend: function() {
    $(".LoaderPage").show();
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {

    $(".LoaderPage").hide();
    //alertify.success('Registro eliminado exitosamente.');  
    Cancelar(IdReporte,year,mes);

    }else{
    alertify.error('Error al eliminar')
    $(".LoaderPage").hide();

    }

     }
     });

  } 

  function Editar(IdReporte,year,mes,id){
   $('#Editar').tooltip('hide')
   $('#ListaDocumento').load('../../../../public/admin/vistas/editar-monedero-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes + '&id=' + id); 
  }
 
  function EditarInfo(IdReporte,year,mes,id){

  var Fecha = $('#Fecha').val();
    var Cilote = $('#Cilote').val();
    var Diferencia = $('#Diferencia').val();

    var data = new FormData();
    var url = '../../../../public/admin/modelo/editar-documento-monedero.php';

    PDF = document.getElementById("PDF");
    PDF_file = PDF.files[0];
    PDF_filePath = PDF.value;

    XML = document.getElementById("XML");
    XML_file = XML.files[0];
    XML_filePath = XML.value;

    EXCEL = document.getElementById("EXCEL");
    EXCEL_file = EXCEL.files[0];
    EXCEL_filePath = EXCEL.value;

    SoporteD = document.getElementById("SoporteD");
    SoporteD_file = SoporteD.files[0];
    SoporteD_filePath = SoporteD.value;

    data.append('id', id);
    data.append('Fecha', Fecha);
    data.append('Cilote', Cilote);
    data.append('Diferencia', Diferencia);
    data.append('XML_file', XML_file);
    data.append('PDF_file', PDF_file);
    data.append('EXCEL_file', EXCEL_file);
    data.append('SoporteD_file', SoporteD_file);
    
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
      Cancelar(IdReporte,year,mes);

    });

      }

    function Edi(IdReporte,year,mes,id){
    $('#DocEDI').tooltip('hide')
    $('#ListaDocumento').load('../../../../public/admin/vistas/editar-monedero-documento-edi.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes + '&id=' + id);
    }  

   function GuardarC(IdReporte,id){

    var Complemento = $('#Complemento').val();

    var data = new FormData();
    var url = '../../../../public/admin/modelo/agregar-documento-monedero-edi.php';

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
     url:   '../../../../public/admin/modelo/eliminar-documento-monedero-edi.php',
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

  function Resumen(idEstacion,year,mes){
  window.location.href = "../../../resumen-periodo-monedero/" + idEstacion + "/" + year + "/" + mes;
  }
 
       
  function monederoKPI(idEstacion,year,mes){
  window.location.href = "../../../resumen-monedero-evaluacion/" + year + "/" + mes + "/" + idEstacion;
 
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

    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    <div class="row">

    <div class="col-12">
    <h5><?=$estacion?> - Resumen Monedero, <?=nombremes($GET_mes);?> <?=$GET_year;?></h5>

  
    </div>
    </div>

    </div>  
 
 
    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">

    <img class="px-1 float-end pointer" src="<?=RUTA_IMG_ICONOS;?>icon-lista.png" onclick="ListaModal(<?=$IdReporte;?>,<?=$GET_year;?>,<?=$GET_mes;?>)">
    <img class="px-1 float-end pointer" src="<?=RUTA_IMG_ICONOS;?>resumen.png" onclick="Resumen(<?=$GET_idEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>)">

    <a href="../../../../public/admin/vistas/descargar-resumen-monedero.php?idEstacion=<?=$GET_idEstacion;?>&year=<?=$GET_year;?>&mes=<?=$GET_mes;?>" download>
    <img class="ms-2 float-end pointer" src="<?=RUTA_IMG_ICONOS;?>excel.png">
    </a> 

    <?php
    if($session_nompuesto == "Dirección de operaciones"){
    ?>

    <img class="px-1 float-end pointer" width="35px" src="<?=RUTA_IMG_ICONOS;?>grafico.png" onclick="monederoKPI(<?=$GET_idEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>)">
    
    <?php
    }
    ?>
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
  <div class="modal-dialog modal-lg" style="margin-top: 83px;">
    <div class="modal-content">
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
    <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>

