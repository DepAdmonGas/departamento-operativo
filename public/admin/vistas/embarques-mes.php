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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" ></script>
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>selectize.css">
  
  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow();
  if(sessionStorage){

  if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {
  idestacion = sessionStorage.getItem('idestacion');
  year = sessionStorage.getItem('year');
  mes = sessionStorage.getItem('mes');
  SelEstacion(idestacion,year,mes);

  }     
  }   

  });
  
  function Regresar(){
  sessionStorage.removeItem('idestacion');
  sessionStorage.removeItem('year');
  sessionStorage.removeItem('mes');
  window.history.back();
  }

  function SelEstacion(idEstacion,year,mes){
  let targets;
  targets = [4, 13, 14, 15, 16, 17, 18, 19, 20, 21];

  sizeWindow();
  sessionStorage.setItem('idestacion', idEstacion);
  sessionStorage.setItem('year', year);
  sessionStorage.setItem('mes', mes);

  $('#ListaEmbarques').load('../../../public/admin/vistas/lista-embarques-mes.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes, function() {
  $('#tabla_embarques_' + idEstacion).DataTable({
  "stateSave": true,
  "language": {
  "url": "<?= RUTA_JS2 ?>/es-ES.json"
  },
  "order": [[0, "desc"]],
  "lengthMenu": [15, 30, 50, 100],
  "columnDefs": [
  { "orderable": false, "targets": targets }, 
  { "searchable": false, "targets": targets }
  ]
  });
  });
  
  }

 
 
  function Mas(idReporte,idEstacion,year,mes){
  $('#Modal').modal('show');
  $('#ModalEmbarques').load('../../../app/vistas/contenido/1-corporativo/corte-diario/embarques/modal-embarques-mes.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes);
  } 
    
  function Embarque(val) {

  var Embarque = $('#Embarque').val();

  if(Embarque == "Pemex") {
  document.getElementById("TablaCocumentos").style.display = "none";
  document.getElementById("DivMerma").style.display = "none";

  }else if(Embarque == "Delivery") {
  document.getElementById("TablaCocumentos").style.display = "none";
  document.getElementById("DivMerma").style.display = "block";

  }else if(Embarque == "Pick Up") {
  document.getElementById("TablaCocumentos").style.display = "block";
  document.getElementById("DivMerma").style.display = "block";

  } else {
  document.getElementById("FacturasUP").style.display = "none";
  document.getElementById("TablaCocumentos").style.display = "none";
  document.getElementById("DivMerma").style.display = "none";
  }

  }

 function Guardar(IdReporte,idestacion,year,mes){

//----- PRIMERA SECCION FORMULARIO -----//
var Fecha = $('#Fecha').val();
var Embarque = $('#Embarque').val();
var Producto = $('#Producto').val();
var Documento = $('#Documento').val();
var NoDocumento = $('#NoDocumento').val();
var ImporteF = $('#ImporteF').val();
var PrecioLitro = $('#PrecioLitro').val();
var Tad = $('#Tad').val(); 

//----- TERCERA SECCION FORMULARIO -----//
var Chofer = $('#Chofer').val();
var Unidad = $('#Unidad').val();

var selectChofer = $('#Chofer').selectize()[0].selectize;
    var choferValor = selectChofer.getValue();

    var selectUnidad = $('#Unidad').selectize()[0].selectize;
    var unidadValor = selectUnidad.getValue();

//----- CUARTA SECCION FORMULARIO -----//
var Merma  = $('#Merma').val();
var NombreTransporte = $('#NombreTransporte').val();


var data = new FormData(); 
var url = '../../../public/admin/modelo/agregar-embarques-mes.php';
 
Documento = document.getElementById("Documento");
Documento_file = Documento.files[0];
Documento_filePath = Documento.value;

//----- FACTURAS XML Y PDF -----//
PDF = document.getElementById("PDF");
PDF_file = PDF.files[0];
PDF_filePath = PDF.value;

XML = document.getElementById("XML");
XML_file = XML.files[0];
XML_filePath = XML.value;


//----- COMPROBANTE DE PAGO -----//
CoPa = document.getElementById("CoPa");
CoPa_file = CoPa.files[0];
CoPa_filePath = CoPa.value;


//----- NOTA DE CREDITO -----//
NCPDF = document.getElementById("NCPDF");
NCPDF_file = NCPDF.files[0];
NCPDF_filePath = NCPDF.value;

NCXML = document.getElementById("NCXML");
NCXML_file = NCXML.files[0];
NCXML_filePath = NCXML.value;

//----- COMPLEMENTO XML Y PDF -----//
ComPDF = document.getElementById("ComPDF");
ComPDF_file = ComPDF.files[0];
ComPDF_filePath = ComPDF.value;

ComXML = document.getElementById("ComXML");
ComXML_file = ComXML.files[0];
ComXML_filePath = ComXML.value;

 
if (Embarque != "") {
    $('#Embarque').css('border','');
    if (Producto != "") {
    $('#Producto').css('border','');
    if (Documento_filePath != "") {
    $('#Documento').css('border','');
    if (Chofer != "") {
    $('#Chofer').css('border','');
    if (Unidad != "") {
    $('#Unidad').css('border',''); 

data.append('IdReporte', IdReporte);

//----- PRIMERA SECCION FORMULARIO -----//
data.append('Fecha', Fecha);
data.append('Embarque', Embarque);
data.append('Producto', Producto);
data.append('Documento_file', Documento_file);
data.append('NoDocumento', NoDocumento);
data.append('ImporteF', ImporteF);
data.append('PrecioLitro', PrecioLitro);
data.append('Tad', Tad);
     
//----- SEGUNDA SECCION FORMULARIO -----//
data.append('PDF_file', PDF_file);
data.append('XML_file', XML_file);
data.append('CoPa_file', CoPa_file);
data.append('NCPDF_file', NCPDF_file);
data.append('NCXML_file', NCXML_file);

data.append('ComPDF_file', ComPDF_file);
data.append('ComXML_file', ComXML_file);

//----- TERCERA SECCION FORMULARIO -----//
data.append('Chofer', Chofer);
data.append('Unidad', Unidad);

//----- CUARTA SECCION FORMULARIO -----//
data.append('Merma', Merma);
data.append('NombreTransporte', NombreTransporte);


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
    $('#Modal').modal('hide');

    sizeWindow();
    alertify.success('Embarque agreado exitosamente')
    SelEstacion(idestacion,year,mes);
 
    });
 
      
    }else{
    $('#Unidad').css('border', '2px solid #A52525'); // Marcar error en select
    }
    }else{
    $('#Chofer').css('border', '2px solid #A52525'); // Marcar error en select
    }
    }else{
    $('#Documento').css('border','2px solid #A52525');
    }
    }else{
    $('#Producto').css('border','2px solid #A52525');
    }
    }else{
    $('#Embarque').css('border','2px solid #A52525');
    }

} 
 
function Eliminar(idReporte,id,idEstacion,year,mes){

var parametros = {
"idReporte": idReporte,
"id": id,
"accion" : "elimina-embarque"
};

alertify.confirm('',
function(){

$.ajax({
data: parametros,
url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
//url: '../../../public/corte-diario/modelo/eliminar-embarque-mes.php',
type: 'post',
beforeSend: function () {
$(".LoaderPage").show();

},
complete: function () {

},
success: function (response) {
if (response == 1) {
$(".LoaderPage").hide();
SelEstacion(idEstacion,year,mes);
sizeWindow();
alertify.success('Registro eliminado exitosamente.')

}else{
alertify.error('Error al eliminar')
$(".LoaderPage").hide();

}

}
});

},
   function(){

   }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}


function Editar(idReporte,id,idestacion,year,mes){
$('#Modal').modal('show'); 
$('#ModalEmbarques').load('../../../app/vistas/contenido/1-corporativo/corte-diario/embarques/modal-editar-embarques-mes.php?idReporte=' + idReporte + '&id='+id+'&idestacion=' + idestacion + '&year=' + year + '&mes=' + mes);
} 

function EditarE(idReporte,id,idestacion,year,mes){

//----- PRIMERA SECCION FORMULARIO -----//
var Fecha = $('#Fecha').val();
var Embarque = $('#Embarque').val();
var Producto = $('#Producto').val();
var Documento = $('#Documento').val();
var NoDocumento = $('#NoDocumento').val();
var ImporteF = $('#ImporteF').val();
var PrecioLitro = $('#PrecioLitro').val();
var Tad = $('#Tad').val(); 

//----- TERCERA SECCION FORMULARIO -----//
var Chofer = $('#Chofer').val();
var Unidad = $('#Unidad').val();

//----- CUARTA SECCION FORMULARIO -----//
var Merma  = $('#Merma').val();
var NombreTransporte = $('#NombreTransporte').val();
 

var data = new FormData();
var url = '../../../public/admin/modelo/editar-embarques-mes.php';

Documento = document.getElementById("Documento");
Documento_file = Documento.files[0];
Documento_filePath = Documento.value;

//----- FACTURAS XML Y PDF -----//
PDF = document.getElementById("PDF");
PDF_file = PDF.files[0];
PDF_filePath = PDF.value;

XML = document.getElementById("XML");
XML_file = XML.files[0];
XML_filePath = XML.value;


//----- COMPROBANTE DE PAGO -----//
CoPa = document.getElementById("CoPa");
CoPa_file = CoPa.files[0];
CoPa_filePath = CoPa.value;


//----- NOTA DE CREDITO -----//
NCPDF = document.getElementById("NCPDF");
NCPDF_file = NCPDF.files[0];
NCPDF_filePath = NCPDF.value;

NCXML = document.getElementById("NCXML");
NCXML_file = NCXML.files[0];
NCXML_filePath = NCXML.value;


//----- COMPLEMENTO XML Y PDF -----//
ComPDF = document.getElementById("ComPDF");
ComPDF_file = ComPDF.files[0];
ComPDF_filePath = ComPDF.value;

ComXML = document.getElementById("ComXML");
ComXML_file = ComXML.files[0];
ComXML_filePath = ComXML.value;

    if (Embarque != "") {
    $('#Embarque').css('border','');
    if (Producto != "") {
    $('#Producto').css('border','');
    if (Chofer != "") {
    $('#Chofer').css('border','');
    if (Unidad != "") {
    $('#Unidad').css('border',''); 

data.append('id', id);

//----- PRIMERA SECCION FORMULARIO -----//
data.append('Fecha', Fecha);
data.append('Embarque', Embarque);
data.append('Producto', Producto);
data.append('Documento_file', Documento_file);
data.append('NoDocumento', NoDocumento);
data.append('ImporteF', ImporteF);
data.append('PrecioLitro', PrecioLitro);
data.append('Tad', Tad);

//----- SEGUNDA SECCION FORMULARIO -----//
data.append('PDF_file', PDF_file);
data.append('XML_file', XML_file);
data.append('CoPa_file', CoPa_file);
data.append('NCPDF_file', NCPDF_file);
data.append('NCXML_file', NCXML_file);
data.append('ComPDF_file', ComPDF_file);
data.append('ComXML_file', ComXML_file);

//----- TERCERA SECCION FORMULARIO -----//
data.append('Chofer', Chofer);
data.append('Unidad', Unidad);

//----- CUARTA SECCION FORMULARIO -----//
data.append('Merma', Merma);
data.append('NombreTransporte', NombreTransporte);

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
    $('#Modal').modal('hide');
    sizeWindow();
    SelEstacion(idestacion,year,mes);
    alertify.success('Registro editado exitosamente.')
    });

    }else{
    $('#Unidad').css('border', '2px solid #A52525'); // Marcar error en select
    }

    }else{
    $('#Chofer').css('border', '2px solid #A52525'); // Marcar error en select
    }

    }else{
    $('#Producto').css('border','2px solid #A52525');
    }
    
    }else{
    $('#Embarque').css('border','2px solid #A52525');
    }

  }

  function ModalComentario(idReporte,id,idEstacion,year,mes){
   $('#ModalComentario').modal('show');  
   $('#DivModalComentario').load('../../../app/vistas/contenido/1-corporativo/corte-diario/embarques/modal-comentarios-embarques.php?idReporte=' + idReporte + '&id=' + id + '&idestacion=' + idEstacion + '&year=' + year + '&mes=' + mes);  
  }
 

  function GuardarComentario(idReporte,id,idEstacion,year,mes,idUsuario) {

  var Comentario = $('#Comentario').val();

  var parametros = {
    "id": id,
    "idUsuario": idUsuario,
    "Comentario": Comentario,
    "accion": "agregar-comentario-embarques"
  };

  if (Comentario != "") {
    $('#Comentario').css('border', '');

    $.ajax({
      data: parametros,
      url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
      //url:   '../../public/corte-diario/modelo/agregar-comentario-embarques.php',
      type: 'post', 
      beforeSend: function () {
      },
      complete: function () {

      },
      success: function (response) {

       if(response == 1){
        $('#Comentario').val('');
          SelEstacion(idEstacion,year,mes); 
          sizeWindow();   
          alertify.success('Comentario agregado exitosamente.');
          $('#DivModalComentario').load('../../../app/vistas/contenido/1-corporativo/corte-diario/embarques/modal-comentarios-embarques.php?idReporte=' + idReporte + '&id=' + id + '&idestacion=' + idestacion + '&year=' + year + '&mes=' + mes);         
         } else {
          alertify.error('Error al agregar el comentario.');

       }

      }
    });

  } else {
    $('#Comentario').css('border', '2px solid #A52525');
  }
  }


function Precios(year,mes){
window.location.href = "../../formato-precios/" + year + "/" + mes;
}
function ResumenAnalisisC(year,mes){
window.location.href = "../../analisis-compra/" + year + "/" + mes;
}

function AnalisisC(idEstacion,year,mes){
window.location.href = "../../analisis-compra/" + idEstacion + "/" + year + "/" + mes;
}

  </script>
  </head>

<body> 
<div class="LoaderPage"></div>

  <!---------- CONTENIDO Y BARRA DE NAVEGACION ---------->
 <div class="wrapper"> 

  <!---------- BARRA DE NAVEGACION ---------->
  <nav id="sidebar">
          
  <div class="sidebar-header text-center">
  <img class="" src="<?=RUTA_IMG_LOGOS."Logo.png";?>" style="width: 100%;">
  </div>

    <ul class="list-unstyled components">
   
      <?php
      
      if($Session_IDUsuarioBD == 509){
        $referencia = "href= ../../importacion ";
        $nombreBar2 = "Menu";

      }else if($session_nompuesto == "Contabilidad"){
        $referencia = "href=".PORTAL." ";
        $nombreBar2 = "Portal";
      }else{
        $referencia = "href=".SERVIDOR_ADMIN." ";
        $nombreBar2 = "Menu";
      }
      ?>
 
    <li>
    <a class="pointer" <?=$referencia?>>
    <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i><?=$nombreBar2?>
    </a>
    </li>


  <li>
    <a class="pointer" onclick="Regresar()">
    <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
    </a>
  </li>

  <?php
  $sql_listaestacion = "SELECT id, nombre FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);

  while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
  $id = $row_listaestacion['id'];
  $estacion = $row_listaestacion['nombre'];

  if ($session_nompuesto == "Contabilidad") {
  if($_SESSION["id_usuario"] == 419){

  }else{
      
  if ($id == 1 || $id == 2 || $id == 3 || $id == 4 || $id == 5 || $id == 14) {

  echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.','.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';

  }

  }

  }else if ($session_nompuesto == "Comercializadora") {
      
  if ($id == 6 || $id == 7 ) {
  
  echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.','.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';

      }

    }else {

      if ($Session_IDUsuarioBD == 293) {
      if ($id == 2) {
          echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.','.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }
      }else if ($Session_IDUsuarioBD == 294) {
      if ($id == 1) {
          echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.','.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }
      
      }else if ($Session_IDUsuarioBD == 295) {
      if ($id == 3) {
          echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.','.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }
      }else if ($Session_IDUsuarioBD == 296) {
      if ($id == 4) {
          echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.','.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }
      }else if ($Session_IDUsuarioBD == 297) {
      if ($id == 5) {
          echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.','.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }
      }else{
          echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.','.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }
    }
  
   }

   if ($Session_IDUsuarioBD == 419) {
?>

<li>
    <a class="pointer" onclick="SelEstacion(14,<?=$GET_year;?>,<?=$GET_mes;?>)">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    Bosque Real
    </a>
</li>

<?php
}

?> 
</ul>

</nav>


 
  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
 <nav class="navbar navbar-expand navbar-light navbar-bg" >
  
  <i class="fa-solid fa-bars menu-btn rounded pointer" 
  id="sidebarCollapse"></i>

  <div class="pointer">
  <a class="text-dark" onclick="history.back()">Embarques, <?=nombremes($GET_mes);?> <?=$GET_year;?></a>
  </div>
 
   
  <div class="navbar-collapse collapse">

  <div class="dropdown-divider"></div>

  <ul class="navbar-nav navbar-align">

  <li class="nav-item dropdown">
  <a class=" dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
  <i class="align-middle" data-feather="settings"></i>
  </a>

 
  <a class="nav-link dropdown-toggle d-none d-sm-inline-block pointer" data-bs-toggle="dropdown">
  
  <img src="<?=RUTA_IMG_ICONOS."usuarioBar.png";?>" class="avatar img-fluid rounded-circle"/>

  <span class="text-dark" style="padding-left: 10px;">
  <?=$session_nompuesto;?>  
  </span>
  </a>
  
  <div class="dropdown-menu dropdown-menu-end">
  
  <div class="user-box">

  <div class="u-text">
  <p class="text-muted">Nombre de usuario:</p>
  <h4><?=$session_nomusuario;?></h4>
  </div>

  </div>


  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="../../../perfil">
  <i class="fa-solid fa-user" style="padding-right: 5px;"></i>Perfil
  </a>
 
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=RUTA_SALIR2?>salir">
  <i class="fa-solid fa-power-off" style="padding-right: 5px;"></i> Cerrar Sesión
  </a>

  </div>
  </li>
  
  </ul>
  </div>

  </nav>
 
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">  
  
  <div id="ListaEmbarques" class="col-12"> </div>
  </div>
  </div> 

  </div>


  <!---------- MODAL COVID (RIGHT)---------->  
  <div class="modal right fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
  <div class="modal-content" id="ModalEmbarques"></div>
  </div>
  </div>

  <!---------- MODAL ----------> 
  <div class="modal fade" id="ModalComentario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
  <div class="modal-content" id="DivModalComentario">
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

 