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
  <link href="<?=RUTA_CSS2;?>navbar-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <script src="<?=RUTA_JS?>size-window.js"></script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  
 

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow();
  if(sessionStorage){
    if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {

      idestacion = sessionStorage.getItem('idestacion');
      year = sessionStorage.getItem('year');
      mes = sessionStorage.getItem('mes');

      $('#ListaEmbarques').load('../../../public/admin/vistas/lista-embarques-mes.php?idEstacion=' + idestacion + '&year=' + year + '&mes=' + mes);
         
    }     
    }   

    });

  function Regresar(){
   sessionStorage.removeItem('idestacion');
   sessionStorage.removeItem('year');
   sessionStorage.removeItem('mes');
   window.history.back();
  }

  function SelEstacion(idestacion,year,mes){
    sizeWindow();
    sessionStorage.setItem('idestacion', idestacion);
    sessionStorage.setItem('year', year);
    sessionStorage.setItem('mes', mes);
 
    $('#ListaEmbarques').load('../../../public/admin/vistas/lista-embarques-mes.php?idEstacion=' + idestacion + '&year=' + year + '&mes=' + mes);
  } 
 
function Mas(IdReporte,idestacion,year,mes){

$('#Modal').modal('show');
$('#DivEmbarques').load('../../../public/admin/vistas/modal-embarques-mes.php?IdReporte=' + IdReporte + '&idestacion=' + idestacion + '&year=' + year + '&mes=' + mes);
} 
    
 function Embarque(val){ 

 var Embarque  = $('#Embarque').val();

 if(Embarque == "Pemex"){
 document.getElementById("FacturasUP").style.display = "none";
 document.getElementById("ComprobantePagoUp").style.display = "none";
 document.getElementById("ComprobantePagoUp").style.display = "none";
 document.getElementById("NotaCreditoUp").style.display = "none";
 document.getElementById("ComplementoUp").style.display = "none";
 document.getElementById("DivMerma").style.display = "none";


 }else if (Embarque == "Delivery") {
 document.getElementById("FacturasUP").style.display = "none";
 document.getElementById("ComprobantePagoUp").style.display = "none";
 document.getElementById("ComprobantePagoUp").style.display = "none";
 document.getElementById("NotaCreditoUp").style.display = "none";
 document.getElementById("ComplementoUp").style.display = "none";
 document.getElementById("DivMerma").style.display = "block";


 }else if(Embarque == "Pick Up"){
 document.getElementById("FacturasUP").style.display = "block";
 document.getElementById("ComprobantePagoUp").style.display = "block";
 document.getElementById("ComprobantePagoUp").style.display = "block";
 document.getElementById("NotaCreditoUp").style.display = "block";
 document.getElementById("ComplementoUp").style.display = "block";
 document.getElementById("DivMerma").style.display = "block";

 }else{
 document.getElementById("FacturasUP").style.display = "none";
 document.getElementById("ComprobantePagoUp").style.display = "none";
 document.getElementById("ComprobantePagoUp").style.display = "none";
 document.getElementById("NotaCreditoUp").style.display = "none";
 document.getElementById("ComplementoUp").style.display = "none";
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
$('#Documento').css('border','2px solid #A52525');
}
}else{
$('#Producto').css('border','2px solid #A52525');
}
}else{
$('#Embarque').css('border','2px solid #A52525');
}

 }

 function Eliminar(idReporte,id,idestacion,year,mes){

    var parametros = {
  "idReporte" : idReporte,
    "id" : id
    };

       $.ajax({
     data:  parametros,
     url:   '../../../public/admin/modelo/eliminar-embarque-mes.php',
     type:  'post',
     beforeSend: function() {
    $(".LoaderPage").show();
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {

    $(".LoaderPage").hide();
   
    SelEstacion(idestacion,year,mes);
    sizeWindow();
    alertify.success('Registro eliminado exitosamente.')

    }else{
    alertify.error('Error al eliminar')
    $(".LoaderPage").hide();

    }

     }
     });

  } 

  function Editar(idReporte,id,idestacion,year,mes){
  $('#Modal').modal('show'); 
  $('#DivEmbarques').load('../../../public/admin/vistas/modal-editar-embarques-mes.php?idReporte=' + idReporte + '&id='+id+'&idestacion=' + idestacion + '&year=' + year + '&mes=' + mes);
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

  }

  function ModalComentario(idReporte,id,idestacion,year,mes){
   $('#Modal').modal('show');  
    $('#DivEmbarques').load('../../../public/admin/vistas/modal-comentarios-embarques.php?idReporte=' + idReporte + '&id=' + id + '&idestacion=' + idestacion + '&year=' + year + '&mes=' + mes);  
  }
 
  function GuardarComentario(idReporte,id,idestacion,year,mes){

  var Comentario = $('#Comentario').val();

    var parametros = {
    "id" : id,
    "Comentario" : Comentario
    };

    if(Comentario != ""){
    $('#Comentario').css('border',''); 

    $.ajax({
    data:  parametros,
    url:   '../../../public/admin/modelo/agregar-comentario-embarques.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    $('#Comentario').val('');
    SelEstacion(idestacion,year,mes); 
    sizeWindow();    
    $('#DivEmbarques').load('../../../public/admin/vistas/modal-comentarios-embarques.php?idReporte=' + idReporte + '&id=' + id + '&idestacion=' + idestacion + '&year=' + year + '&mes=' + mes);  
    }else{
     alertify.error('Error al agregar comentario');  
    }

    }
    });

    }else{
    $('#Comentario').css('border','2px solid #A52525'); 
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
  
  <div class="col-12 mb-3">
  <div id="ListaEmbarques" class="cardAG">
    
    <div class="p-3">
    <div class="" style="font-size: 1.1em"><b>ANEXO IV: EXPEDIENTE DE TRANPORTE PARA LA RECLAMACION DE PRODUCTO</b></div>
    <hr>
    <div class="mb-2"><b>Estación de servicio debe recabar:</b></div>
    <div class="mb-2">De manera enunciativa mas no limitativa, el expediente de transporte de cada entrega deberá contar con al menos los siguientes documentos:</div>

    <div class="mb-2">
    1.  Hoja 1 “Acta de Balance (Estación)”<br>
    2.  Factura final de producto.<br>
    3.  Nota de Embarque de Axfaltec.<br>
    4.  Check List. “LISTA DE VERIFICACIÓN DE LA DESCARGA”<br>
    5.  Tirillas de inventarios (Veeder Root) inicial, final y de aumento.<br>
    6.  Reporte de ventas (de ser el caso de acuerdo al punto 10 de checklist)<br>
    7.  Firmas autógrafas de ambas partes.<br>
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

      <div id="DivEmbarques"></div>
   
    </div>
  </div>
</div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>

 