<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

function IdReporte($idEstacion,$GET_year,$GET_mes,$con){
   $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$idEstacion."' AND year = '".$GET_year."' ";
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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  

  <style media="screen">
  .tableFixHead{
    overflow-y: scroll;
  }
  .tableFixHead thead th{
    position: sticky;
    top: 0px;
    box-shadow: 2px 2px 7px #ECECEC;
  } 
  </style>
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  var margint = -550;
  var ventana_alto = $(document).height();
  ResultAlto = ventana_alto - margint;
  box = document.getElementsByClassName('tableFixHead')[0];
  box.style.height = ResultAlto + 'px';

  ReporteAceites(<?=$GET_idEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>);

  });
 
  function Regresar(){
   window.history.back();
  }

  function Aceites(){window.location.href = "../../../../administracion/aceites";}

  function ReporteAceites(idEstacion,year,mes){
    $('#DivReporteAceites').html('<div class="text-center mt-5 pt-5"><img class="mt-5 pt-5" width="50px" src="../../../../imgs/iconos/load-img.gif"></div>');
  $('#DivReporteAceites').load('../../../../public/admin/vistas/reporte-aceites-mes.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes);

  }  

  function EditBodega(val,idaceite){

     var bodega = val.value;

      var parametros = {
    "type" : "bodega",
    "idaceite" : idaceite,
    "bodega" : bodega
    };

     $.ajax({
     data:  parametros,
     url:   '../../public/corte-diario/modelo/editar-reporte-aceites.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

      if (response == 0) {
        ReporteAceites(<?=$GET_year;?>,<?=$GET_mes;?>);
      }else{
        InventarioInicial(idaceite);
        InventarioFinal(idaceite);
        diferencia(idaceite);
      }

     }
     });

  }
 
  function EditExibidor(val,idaceite){

     var exibidor = val.value;

      var parametros = {
    "type" : "exibidor",
    "idaceite" : idaceite,
    "exibidor" : exibidor
    };

     $.ajax({
     data:  parametros,
     url:   '../../public/corte-diario/modelo/editar-reporte-aceites.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

      if (response == 0) {
        ReporteAceites(<?=$GET_year;?>,<?=$GET_mes;?>);
      }else{
        InventarioInicial(idaceite);
        InventarioFinal(idaceite);
        diferencia(idaceite);
      }

     }
     });

  }

  function InventarioInicial(idaceite){

  var bodega = $("#bodega-" + idaceite).val();
  var exibidor = $("#exibidor-" + idaceite).val();

  total = parseInt(bodega) + parseInt(exibidor);


  $("#inventarioi-" + idaceite).text(number_format(total,2));

  }

    function number_format(amount, decimals) {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
}

function EditPedido(val,idaceite){

     var pedido = val.value;

      var parametros = {
    "type" : "pedido",
    "idaceite" : idaceite,
    "pedido" : pedido
    };

     $.ajax({
     data:  parametros,
     url:   '../../public/corte-diario/modelo/editar-reporte-aceites.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

      if (response == 0) {
        ReporteAceites(<?=$GET_year;?>,<?=$GET_mes;?>);
      }else{
      InventarioFinal(idaceite);
      diferencia(idaceite);
      }

     }
     });

  }

  function EditVentas(val,idaceite){

     var ventas = val.value;

      var parametros = {
    "type" : "ventas",
    "idaceite" : idaceite,
    "ventas" : ventas
    };

     $.ajax({
     data:  parametros,
     url:   '../../public/corte-diario/modelo/editar-reporte-aceites.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

      if (response == 0) {
        ReporteAceites(<?=$GET_year;?>,<?=$GET_mes;?>);
      }else{
      InventarioFinal(idaceite);
      diferencia(idaceite);
      diffactura(idaceite);
      }

     }
     });

  }

  function InventarioFinal(idaceite){

  var inventarioi = $("#inventarioi-" + idaceite).text();
  var pedido = $("#pedido-" + idaceite).val();
  var ventas = $("#ventas-" + idaceite).val();

  total = parseInt(inventarioi) + parseInt(pedido) - parseInt(ventas);
  $("#inventariof-" + idaceite).text(number_format(total,2));

  }

  function EditFisico(val,idaceite){

     var fisico = val.value;

      var parametros = {
    "type" : "fisico",
    "idaceite" : idaceite,
    "fisico" : fisico
    };

     $.ajax({
     data:  parametros,
     url:   '../../public/corte-diario/modelo/editar-reporte-aceites.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

      if (response == 0) {
        ReporteAceites(<?=$GET_year;?>,<?=$GET_mes;?>);
      }else{
      diferencia(idaceite);
      }

     }
     });

  }

function diferencia(idaceite){

  var inventariof = $("#inventariof-" + idaceite).text();
  var fisico = $("#fisico-" + idaceite).val();

  if (inventariof != 0.00) {
  if (fisico != "") {
  total = parseInt(fisico) - parseInt(inventariof);
  }else{
    total = -inventariof;
  }
  }else{
    total = 0;
  }

    $("#diferencia-" + idaceite).text(total + ".00");

}

function EditFacturados(val,idaceite){

     var facturado = val.value;

      var parametros = {
    "type" : "facturado",
    "idaceite" : idaceite,
    "facturado" : facturado
    };

     $.ajax({
     data:  parametros,
     url:   '../../public/corte-diario/modelo/editar-reporte-aceites.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

      if (response == 0) {
        ReporteAceites(<?=$GET_year;?>,<?=$GET_mes;?>);
      }else{
        factotal(idaceite);
        diffactura(idaceite);
      }

     }
     });

}

function EditMostrador(val,idaceite){

     var mostrador = val.value;

      var parametros = {
    "type" : "mostrador",
    "idaceite" : idaceite,
    "mostrador" : mostrador
    };

     $.ajax({
     data:  parametros,
     url:   '../../public/corte-diario/modelo/editar-reporte-aceites.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

      if (response == 0) {
        ReporteAceites(<?=$GET_year;?>,<?=$GET_mes;?>);
      }else{
      factotal(idaceite);
      diffactura(idaceite);
      }

     }
     });

}

function factotal(idaceite){
  
  var mostrador = $("#mostrador-" + idaceite).val();
  var facturado = $("#facturado-" + idaceite).val();

  total = parseInt(mostrador) + parseInt(facturado);


  $("#factotal-" + idaceite).text(number_format(total,2));
}

function diffactura(idaceite){
  
  var factotal = $("#factotal-" + idaceite).text();
  var ventas = $("#ventas-" + idaceite).val();

  total = parseInt(factotal) - parseInt(ventas);


  $("#diffactura-" + idaceite).text(number_format(total,2));
}
  
function ListaModal(IdReporte,year,mes){
$('#Modal').modal('show');
  $('#ListaDocumento').load('../../../../public/admin/vistas/lista-aceites-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
}   
 
function Nuevo(IdReporte,year,mes){ 
 $('#ListaDocumento').load('../../../../public/admin/vistas/formulario-aceites-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
}  
  
function Cancelar(IdReporte,year,mes){
  $('#ListaDocumento').load('../../../../public/admin/vistas/lista-aceites-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
}

function Guardar(IdReporte,year,mes){

    var data = new FormData();
    var url = '../../../../public/admin/modelo/agregar-documento-aceite.php';
 
    Ficha = document.getElementById("Ficha");
    Ficha_file = Ficha.files[0];
    Ficha_filePath = Ficha.value;
 
    Imagen = document.getElementById("Imagen");
    Imagen_file = Imagen.files[0];
    Imagen_filePath = Imagen.value;

    Factura = document.getElementById("Factura");
    Factura_file = Factura.files[0];
    Factura_filePath = Factura.value;
 
    data.append('IdReporte', IdReporte);
    data.append('year', year);
    data.append('mes', mes);
    data.append('Ficha_file', Ficha_file);
    data.append('Imagen_file', Imagen_file);
    data.append('Factura_file', Factura_file);
    
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
      Cancelar(IdReporte,year,mes)
    });

}

function Eliminar(IdReporte,year,mes,id){

    var parametros = {
  "IdReporte" : IdReporte,
    "id" : id
    };


    alertify.confirm('',
  function(){

       $.ajax({
     data:  parametros,
     url:   '../../../../public/admin/modelo/eliminar-documento-aceite.php',
     type:  'post',
     beforeSend: function() {
    $(".LoaderPage").show();
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {

    $(".LoaderPage").hide();
   
    Cancelar(IdReporte,year,mes)
    }else{
    alertify.error('Error al eliminar')
    $(".LoaderPage").hide();

    }

     }
 });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el documento seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    }






  function Editar(IdReporte,year,mes,id){
   $('#ListaDocumento').load('../../../../public/admin/vistas/editar-aceite-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes + '&id=' + id);  
  }
 
 
  function EditarInfo(IdReporte,year,mes,id){

 var data = new FormData();
    var url = '../../../../public/admin/modelo/editar-documento-aceite.php';
 
    Ficha = document.getElementById("Ficha");
    Ficha_file = Ficha.files[0];
    Ficha_filePath = Ficha.value;

    Imagen = document.getElementById("Imagen");
    Imagen_file = Imagen.files[0];
    Imagen_filePath = Imagen.value;

    Factura = document.getElementById("Factura");
    Factura_file = Factura.files[0];
    Factura_filePath = Factura.value;

    data.append('id', id);
    data.append('year', year);
    data.append('mes', mes);
    data.append('Ficha_file', Ficha_file);
    data.append('Imagen_file', Imagen_file);
    data.append('Factura_file', Factura_file);
    
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


    function DocumentacionAceites(IdReporte,year,mes){
    $('#Modal').modal('show');
    $('#ListaDocumento').load('../../../../public/admin/vistas/lista-aceites-facturas.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
    }

 
    function GuardarFactura(IdReporte,year,mes){

    var fechaAceite = $('#fechaAceite').val();
    var conceptoAceite = $('#conceptoAceite').val();
    var facturaAceite = $('#facturaAceite').val();

    var data = new FormData();
    var url = '../../../../public/admin/modelo/agregar-factura-archivo-aceite.php';

    Factura = document.getElementById("facturaAceite");
    Factura_file = Factura.files[0];
    Factura_filePath = Factura.value;
 

    if (fechaAceite != "") {
    $('#fechaAceite').css('border','');

    if (conceptoAceite != "") {
    $('#conceptoAceite').css('border','');

    if (facturaAceite != "") {
    $('#facturaAceite').css('border','');

    data.append('IdReporte', IdReporte);
    data.append('fechaAceite', fechaAceite);
    data.append('conceptoAceite', conceptoAceite);
    data.append('Factura_file', Factura_file);

    
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
    $('#ListaDocumento').load('../../../../public/admin/vistas/lista-aceites-facturas.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
    alertify.success('Archivo agregado exitosamente')
    
    });


    }else{
    $('#facturaAceite').css('border','2px solid #A52525');  
    }

    }else{
    $('#conceptoAceite').css('border','2px solid #A52525');  
    }

    }else{
    $('#fechaAceite').css('border','2px solid #A52525');  
    }

    }


        function EliminarFacturaAceite(IdReporte,year,mes,id){


    var parametros = {
    "IdReporte" : IdReporte,
    "id" : id
    };


  alertify.confirm('',
  function(){
 
       $.ajax({
     data:  parametros,
     url:   '../../../../public/admin/modelo/eliminar-factura-archivo-aceite.php',
     type:  'post',
     beforeSend: function() {
    $(".LoaderPage").show();
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {

    $(".LoaderPage").hide();
    $('#ListaDocumento').load('../../../../public/admin/vistas/lista-aceites-facturas.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
    alertify.success('Archivo agregado exitosamente');

    }else{
    alertify.error('Error al eliminar')
    $(".LoaderPage").hide();

    }

     }
     });

  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el registro seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();


    }

  function Resumen(estacion,year,mes){
  var scrollTop = window.scrollY;
  sessionStorage.setItem('scrollTop', 0);  
  window.location.href =  "../../../resumen-mes/" + estacion + "/" + year + "/" + mes;
  }



  function aceitesKPI(idEstacion,year,mes){
  window.location.href = "../../../aceites-evaluacion/" + year + "/" + mes + "/" + idEstacion;
  
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

    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">

    <div class="col-12">
    <h5><?=$estacion?> - Aceites, <?=nombremes($GET_mes);?> <?=$GET_year;?></h5>
    </div>

    </div>

    </div>

    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
    
    <img class="float-end ms-2 pointer" width="26px" src="<?=RUTA_IMG_ICONOS;?>icon-lista.png" onclick="ListaModal(<?=$IdReporte;?>,<?=$GET_year;?>,<?=$GET_mes;?>)">
    <img class="float-end ms-2 pointer" width="26px" onclick="Resumen(<?=$GET_idEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>)" src="<?=RUTA_IMG_ICONOS;?>resumen.png">
    <img class="float-end ms-2 pointer" width="26px" src="<?=RUTA_IMG_ICONOS;?>aceite.png" onclick="Aceites()">
    <img class="float-end ms-2 pointer" width="26px" src="<?=RUTA_IMG_ICONOS;?>archivo-tb.png" onclick="DocumentacionAceites(<?=$GET_idEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>)">
    
    <?php
    if($session_nompuesto == "Dirección de operaciones"){ 
    ?>
    <img class="px-1 float-end pointer" width="35px" src="<?=RUTA_IMG_ICONOS;?>grafico.png" onclick="aceitesKPI(<?=$GET_idEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>)">
    <?php
    }
    ?>

    </div>

    </div>

  <hr>


  <div class="tableFixHead">
  <div id="DivReporteAceites"></div>
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
      

      <div id="ListaDocumento"></div>


    </div>
  </div>
</div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>
  </body>
  </html>

