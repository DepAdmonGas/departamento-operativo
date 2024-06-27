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
  
  TPVLista();

  });  

  function Regresar(){
   window.history.back();
  }

  function TPVLista() {
    $('#TPVLista').load('public/corte-diario/vistas/lista-terminales-tpv.php', function () {
        function initializeDataTable(tableId) {
            // Clonar y remover las filas antes de inicializar DataTables
            var $lastRows = $('#' + tableId + ' tr.ultima-fila').clone();
            $('#' + tableId + ' tr.ultima-fila').remove();
    
            // Inicializar DataTables
            $('#' + tableId).DataTable({
                "language": {
                    "url": "<?=RUTA_JS2?>" + "/es-ES.json"
                },
                "order": [[0, "desc"]],
                "lengthMenu": [15, 30, 50, 100],
                "columnDefs": [
                    { "orderable": false,},
                    { "searchable": false,}
                ],
                "drawCallback": function(settings) {
                    // Remover cualquier fila 'ultima-fila' existente para evitar duplicados
                    $('#' + tableId + ' tr.ultima-fila').remove();
                    // Añadir las filas clonadas al final del tbody
                    $('#' + tableId + ' tbody').append($lastRows.clone());
                }
            });
    
            // Añadir las filas clonadas al final del tbody inicial
            $('#' + tableId + ' tbody').append($lastRows);
        }
        // Inicializar ambas tablas
        initializeDataTable('terminales-punto-venta');
    });

}
  function Agregar(){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('public/corte-diario/vistas/modal-agregar-terminales-tpv.php');
  }  

 function Guardar(){ 
 
var Tpv = $('#Tpv').val();
var Serie = $('#Serie').val();
var Modelomarca = $('#Modelomarca').val();
var TipoC = $('#TipoC').val();
var Afiliado = $('#Afiliado').val();
var Telefono = $('#Telefono').val();
var Estado = $('#Estado').val();
var Rollos = $('#Rollos').val();
var Cargadores = $('#Cargadores').val();
var Pedestales = $('#Pedestales').val();
var NoLote = $('#NoLote').val();

  var parametros = {
    "Tpv" : Tpv,
    "Serie" : Serie,
    "Modelomarca" : Modelomarca,
    "TipoC" : TipoC,
    "Afiliado" : Afiliado,
    "Telefono" : Telefono,
    "Estado" : Estado,
    "Rollos" : Rollos,
    "Cargadores" : Cargadores,
    "Pedestales" : Pedestales,
    "NoLote" : NoLote
    };

    $.ajax({
     data:  parametros,
     url:   'public/corte-diario/modelo/agregar-terminal-tpv.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

     if (response == 1) {
     TPVLista();
     $('#Modal').modal('hide');  
     alertify.success('Registro agregado exitosamente.');
     }

     }
     });

}

    function Eliminar(id){

    var parametros = {
    "id" : id
    };

alertify.confirm('',
  function(){

    $.ajax({
    data:  parametros,
    url:   'public/corte-diario/modelo/eliminar-terminal-tpv.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    TPVLista(); 
    alertify.success('Registro eliminado exitosamente.')     
    }

    }
   });

  },
  function(){
  }).setHeader('Eliminar información').set({transition:'zoom',message: '¿Desea eliminar la infomración seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}




    function ModalEditar(id){
    $('#Modal').modal('show');  
    $('#ContenidoModal').load('public/corte-diario/vistas/modal-editar-terminales-tpv.php?idEditar=' + id);
    }

    function Editar(id){

var Tpv = $('#Tpv').val();
var Serie = $('#Serie').val();
var Modelomarca = $('#Modelomarca').val();
var TipoC = $('#TipoC').val();
var Afiliado = $('#Afiliado').val();
var Telefono = $('#Telefono').val();
var Estado = $('#Estado').val();
var Rollos = $('#Rollos').val();
var Cargadores = $('#Cargadores').val();
var Pedestales = $('#Pedestales').val();
var NoLote = $('#NoLote').val();

  var parametros = {
    "idEditar" : id,
    "Tpv" : Tpv,
    "Serie" : Serie,
    "Modelomarca" : Modelomarca,
    "TipoC" : TipoC,
    "Afiliado" : Afiliado,
    "Telefono" : Telefono,
    "Estado" : Estado,
    "Rollos" : Rollos,
    "Cargadores" : Cargadores,
    "Pedestales" : Pedestales,
    "NoLote" : NoLote
    };

    $.ajax({
     data:  parametros,
     url:   'public/corte-diario/modelo/editar-terminal-tpv.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

     if (response == 1) {
     TPVLista();
     $('#Modal').modal('hide'); 
     alertify.success('Registro editado exitosamente.') 
     }

     }
     });

    }
 
    function ModalDetalle(id){      
    $('#Modal').modal('show');  
    $('#ContenidoModal').load('public/corte-diario/vistas/modal-detalle-terminales-tpv.php?idTPV=' + id);
    }
  

    function ModalFalla(id) {
    $('#Modal').modal('show');  
    $('#ContenidoModal').load('public/corte-diario/vistas/modal-falla-terminales-tpv.php?idTPV=' + id);
    }
 
    function ModalNuevaFalla(id){
    $('#ContenidoModal').load('public/corte-diario/vistas/modal-nueva-falla-terminales-tpv.php?idTPV=' + id);  
    }

    function GuardarFalla(id){
     var Falla = $('#Falla').val(); 

     var parametros = {
     "id" : id,
     "Falla" : Falla
      };

      $.ajax({
     data:  parametros,
     url:   'public/corte-diario/modelo/reporte-terminal-tpv.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

     if (response == 1) {
     ModalFalla(id);
     TPVLista();
     alertify.success('Registro agregado exitosamente.')
     }

     }
     });

    }
    //-------------------------------------------------------------------------------
 
    function ModalDetalleFalla(idFalla,idTPV){
    $('#Modal').modal('show');  
    $('#ContenidoModal').load('public/corte-diario/vistas/modal-detalle-falla-terminales-tpv.php?idFalla=' + idFalla + '&idTPV=' + idTPV ); 
    }
 
    function ModalEditarFalla(idFalla,idTPV){
    $('#Modal').modal('show');  
    $('#ContenidoModal').load('public/corte-diario/vistas/modal-editar-falla-terminales-tpv.php?idFalla=' + idFalla + '&idTPV=' + idTPV );   
    }

    function FinalizarFalla(idFalla,idTPV){

    var Falla = $('#Falla').val();
    var Atiende = $('#Atiende').val();
    var NoReporte = $('#NoReporte').val();
    var DiaReporte = $('#DiaReporte').val();
    var DiaSolucion = $('#DiaSolucion').val();
    var Costo = $('#Costo').val();
    var NuevaSerie = $('#NuevaSerie').val();
    var ModeloTPV = $('#ModeloTPV').val();
    var Conexion = $('#Conexion').val();
    var Observaciones = $('#Observaciones').val();


    var parametros = {
      "idTPV" : idTPV,
      "idFalla" : idFalla,
      "Falla" : Falla,     
      "Atiende" : Atiende,
      "NoReporte" : NoReporte,
      "DiaReporte" : DiaReporte,
      "DiaSolucion" : DiaSolucion,
      "Costo" : Costo,
      "NuevaSerie" : NuevaSerie,
      "ModeloTPV" : ModeloTPV,
      "Conexion" : Conexion,
      "Observaciones" : Observaciones
      };

     $.ajax({
     data:  parametros,
     url:   'public/corte-diario/modelo/finalizar-falla-terminal-tpv.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

     if (response == 1) {
     ModalFalla(idTPV);
     TPVLista();
     alertify.success('Falla finalizada exitosamente.');
     }

     }
     });

    }
  </script>
  </head>
  <!---------- LIBRERIAS DEL DATATABLE ---------->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
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

     <h5>Terminales punto de venta</h5>
    
    </div>
    </div>

    </div>

    <div class="col-1">
    <img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="ml-2" onclick="Agregar()">
    </div>

    </div>

  <hr>

 <div id="TPVLista"></div>
  
  </div>
  </div>
  </div>

  </div>
  </div>

  </div>

<div class="modal" id="Modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="margin-top: 83px;">
      <div id="ContenidoModal"></div>    
    </div>
  </div>
</div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>
<!---------- LIBRERIAS DEL DATATABLE ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>
  </body>
  </html>



                      
