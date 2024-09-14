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
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" ></script>
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>selectize.css">

  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
  <script type="text/javascript" src="<?=RUTA_JS ?>alertify.js"></script> 

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
    sizeWindow(); 

    if(sessionStorage){
    if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {

    id = sessionStorage.getItem('idestacion');
    SelEstacion(id)     
    }   
     
    }  

  });

  function Regresar(){
   window.history.back();
  } 
  
  function SelEstacion(idEstacion) {
    sessionStorage.setItem('idestacion', idEstacion)

  function initializeDataTable(tableId) {
  let targets;
  targets = [15];


  $('#ListaTerminales').load('../public/admin/vistas/lista-terminales-tpv.php?idEstacion=' + idEstacion, function() {
    // Clonar y remover las filas antes de inicializar DataTables
    var $lastRows = $('#' + tableId + ' .ultima-fila').clone();
    $('#' + tableId + ' .ultima-fila').remove();

    $('#' + tableId).DataTable({
      "language": {
        "url": "<?=RUTA_JS2?>/es-ES.json"
      },
      "order": [[0, "asc"]],
      "lengthMenu": [25, 50, 75, 100],
      "columnDefs": [
        { "orderable": false, "targets": targets },
        { "searchable": false, "targets": targets }
      ],
      "drawCallback": function(settings) {
        // Remover cualquier fila 'ultima-fila' existente para evitar duplicados
        $('#' + tableId + ' .ultima-fila').remove();
        // Añadir las filas clonadas al final del tbody
        $('#' + tableId + ' tbody').append($lastRows.clone());
      }
    });
  });
  }

initializeDataTable('tabla_tpv_' + idEstacion);
}


 
 
  function Agregar(idEstacion){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('../public/admin/vistas/modal-agregar-terminales-tpv.php?idEstacion=' + idEstacion);
  }    
 
 function Guardar(idEstacion){

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

var EstadoTPV = $('#EstadoTPV').val();
var NoImpresiones = $('#NoImpresiones').val();
var TipoTPV = $('#TipoTPV').val();


if (Tpv != "") {
$('#Tpv').css('border', '');

if (Serie != "") {
$('#Serie').css('border', '');

if (Modelomarca != "") {
$('#Modelomarca').css('border', '');

if (NoLote != "") {
  $('#NoLote').css('border', '');

if (TipoC != "") {
$('#TipoC').css('border', '');

if (Afiliado != "") {
$('#Afiliado').css('border', '');

if (Telefono != "") {
$('#Telefono').css('border', '');

if (Estado != "") {
$('#Estado').css('border', '');

if (Rollos != "") {
$('#Rollos').css('border', '');

if (Cargadores != "") {
$('#Cargadores').css('border', '');

if (Pedestales != "") {
$('#Pedestales').css('border', '');


if (EstadoTPV != "") {
$('#EstadoTPV').css('border', '');

if (NoImpresiones != "") {
$('#NoImpresiones').css('border', '');

if (TipoTPV != "") {
$('#TipoTPV').css('border', '');

  var parametros = {
    "idEstacion" : idEstacion,
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
    "NoLote" : NoLote,
    "EstadoTPV" : EstadoTPV,
    "NoImpresiones" : NoImpresiones,
    "TipoTPV" : TipoTPV
    };
 
    $.ajax({
     data:  parametros,
     url:   '../public/admin/modelo/agregar-terminal-tpv.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

     if (response == 1) {
     SelEstacion(idEstacion);
     $('#Modal').modal('hide');  
     sizeWindow()
     alertify.success('Registro agregado exitosamente.')
     }

     }
     });


} else {
$('#TipoTPV').css('border', '2px solid #A52525');
}

} else {
$('#NoImpresiones').css('border', '2px solid #A52525');
}

} else {
$('#EstadoTPV').css('border', '2px solid #A52525');
}


} else {
$('#Pedestales').css('border', '2px solid #A52525');
}

} else {
$('#Cargadores').css('border', '2px solid #A52525');
}

} else {
$('#Rollos').css('border', '2px solid #A52525');
}


} else {
$('#Estado').css('border', '2px solid #A52525');
}

} else {
$('#Telefono').css('border', '2px solid #A52525');
}

} else {
$('#Afiliado').css('border', '2px solid #A52525');
}

} else {
$('#TipoC').css('border', '2px solid #A52525');
}

} else {
$('#NoLote').css('border', '2px solid #A52525');
}

} else {
$('#Modelomarca').css('border', '2px solid #A52525');
}

} else {
$('#Serie').css('border', '2px solid #A52525');
}

} else {
$('#Tpv').css('border', '2px solid #A52525');
}

}

    function Eliminar(idEstacion,id){

    var parametros = {
    "id" : id
    };

    alertify.confirm('',
    function(){


    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/eliminar-terminal-tpv.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    SelEstacion(idEstacion);  
    sizeWindow()
    alertify.success('Registro eliminado exitosamente.')    
    }

    }


 });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    }



    function ModalEditar(idEstacion,id){
    $('#Modal').modal('show');  
    $('#ContenidoModal').load('../public/admin/vistas/modal-editar-terminales-tpv.php?idEstacion=' + idEstacion + '&idEditar=' + id);
    }

    function Editar(idEstacion,id){

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

var EstadoTPV = $('#EstadoTPV').val();
var NoImpresiones = $('#NoImpresiones').val();
var TipoTPV = $('#TipoTPV').val();


if (Tpv != "") {
$('#Tpv').css('border', '');

if (Serie != "") {
$('#Serie').css('border', '');

if (Modelomarca != "") {
$('#Modelomarca').css('border', '');

if (NoLote != "") {
  $('#NoLote').css('border', '');

if (TipoC != "") {
$('#TipoC').css('border', '');

if (Afiliado != "") {
$('#Afiliado').css('border', '');

if (Telefono != "") {
$('#Telefono').css('border', '');

if (Estado != "") {
$('#Estado').css('border', '');

if (Rollos != "") {
$('#Rollos').css('border', '');

if (Cargadores != "") {
$('#Cargadores').css('border', '');

if (Pedestales != "") {
$('#Pedestales').css('border', '');


if (EstadoTPV != "") {
$('#EstadoTPV').css('border', '');

if (NoImpresiones != "") {
$('#NoImpresiones').css('border', '');

if (TipoTPV != "") {
$('#TipoTPV').css('border', '');


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
    "NoLote" : NoLote,
    "EstadoTPV" : EstadoTPV,
    "NoImpresiones" : NoImpresiones,
    "TipoTPV" : TipoTPV
    };

    $.ajax({
     data:  parametros,
     url:   '../public/admin/modelo/editar-terminal-tpv.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

     if (response == 1) {
     SelEstacion(idEstacion);
     $('#Modal').modal('hide'); 
     sizeWindow();
     alertify.success('Registro editado exitosamente.') 
     }

     }
     });

    } else {
$('#TipoTPV').css('border', '2px solid #A52525');
}

} else {
$('#NoImpresiones').css('border', '2px solid #A52525');
}

} else {
$('#EstadoTPV').css('border', '2px solid #A52525');
}


} else {
$('#Pedestales').css('border', '2px solid #A52525');
}

} else {
$('#Cargadores').css('border', '2px solid #A52525');
}

} else {
$('#Rollos').css('border', '2px solid #A52525');
}


} else {
$('#Estado').css('border', '2px solid #A52525');
}

} else {
$('#Telefono').css('border', '2px solid #A52525');
}

} else {
$('#Afiliado').css('border', '2px solid #A52525');
}

} else {
$('#TipoC').css('border', '2px solid #A52525');
}

} else {
$('#NoLote').css('border', '2px solid #A52525');
}

} else {
$('#Modelomarca').css('border', '2px solid #A52525');
}

} else {
$('#Serie').css('border', '2px solid #A52525');
}

} else {
$('#Tpv').css('border', '2px solid #A52525');
}

    }
 
    function ModalDetalle(idEstacion,id){      
    $('#Modal').modal('show');  
    $('#ContenidoModal').load('../public/admin/vistas/modal-detalle-terminales-tpv.php?idEstacion=' + idEstacion + '&idTPV=' + id);
    }

 
    function ModalFalla(idEstacion,id) {
    $('#Modal2').modal('show');  
    $('#ContenidoModal2').load('../public/admin/vistas/modal-falla-terminales-tpv.php?idEstacion=' + idEstacion + '&idTPV=' + id);
    }
    
    function ModalNuevaFalla(idEstacion,id){
    $('#ContenidoModal2').load('../public/admin/vistas/modal-nueva-falla-terminales-tpv.php?idEstacion=' + idEstacion + '&idTPV=' + id);  
    } 
 
    function GuardarFalla(idEstacion,id){
     var Falla = $('#Falla').val(); 

     var parametros = {
     "id" : id,
     "Falla" : Falla
      };

      if (Falla != "") {
  $('#Falla').css('border', '');



      $.ajax({
     data:  parametros,
     url:   '../public/admin/modelo/reporte-terminal-tpv.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

     if (response == 1) {
     ModalFalla(idEstacion,id);
     SelEstacion(idEstacion)
     sizeWindow()
     alertify.success('Falla agregada exitosamente.');

     }

     }
     });

    } else {
  $('#Falla').css('border', '2px solid #A52525');
  alertify.error('Falta seleccionar la falla');
  }

    }
    //-------------------------------------------------------------------------------

    function ModalDetalleFalla(idFalla,idTPV,idEstacion){
    $('#Modal2').modal('show');  
    $('#ContenidoModal2').load('../public/admin/vistas/modal-detalle-falla-terminales-tpv.php?idFalla=' + idFalla + '&idTPV=' + idTPV + '&idEstacion=' + idEstacion);
    }

    function ModalEditarFalla(idFalla,idTPV,idEstacion){
    $('#Modal2').modal('show');  
    $('#ContenidoModal2').load('../public/admin/vistas/modal-editar-falla-terminales-tpv.php?idFalla=' + idFalla + '&idTPV=' + idTPV + '&idEstacion=' + idEstacion);  
    } 

    function FinalizarFalla(idFalla,idTPV,idEstacion){

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
    var data = new FormData();
    var url = '../public/admin/modelo/finalizar-falla-terminal-tpv.php';

    FacturaPDF = document.getElementById("Factura");
    FacturaPDF_file = FacturaPDF.files[0];
    FacturaPDF_filePath = FacturaPDF.value;


      data.append('idEstacion', idEstacion);
      data.append('idTPV', idTPV);
      data.append('idFalla', idFalla);
      data.append('Falla', Falla);
      data.append('Atiende', Atiende);
      data.append('NoReporte', NoReporte);
      data.append('DiaReporte', DiaReporte);
      data.append('DiaSolucion', DiaSolucion);
      data.append('Costo', Costo);
      data.append('NuevaSerie', NuevaSerie);
      data.append('ModeloTPV', ModeloTPV);
      data.append('Conexion', Conexion);
      data.append('Observaciones', Observaciones);
      data.append('FacturaPDF_file', FacturaPDF_file);

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
      $(".LoaderPage").hide();
      ModalFalla(idEstacion,idTPV);
     SelEstacion(idEstacion);
     sizeWindow();
     alertify.success('Falla finalizada exitosamente.');

     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al finalizar la falla '); 
     }
     

    }); 


    }
  </script>
  </head>

<body> 
<div class="LoaderPage"></div>

  <!---------- CONTENIDO Y BARRA DE NAVEGACION ---------->
  <div class="wrapper">
  <!---------- BARRA DE NAVEGACION ---------->
  <nav id="sidebar">

  <div class="sidebar-header " >
  <img class="text-center" src="<?php echo RUTA_IMG_ICONOS."Logo.png";?>" style="width: 100%;">
  </div>

  <ul class="list-unstyled components">
    
    <li>
    <a class="pointer" href="<?=SERVIDOR_ADMIN?>">
    <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i>Menu
    </a>
    </li>


  <li>
    <a class="pointer" onclick="Regresar()">
    <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
    </a>
  </li>


    <?php

  $sql_listaestacion = "SELECT id, nombre, numlista FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);

   while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
    $id = $row_listaestacion['id'];
    $estacion = $row_listaestacion['nombre'];



  if ($session_nompuesto == "Comercializadora") {


    
    if($Session_IDUsuarioBD == 28){

      if($id == 6 || $id == 7){
        echo '  
        <li>
          <a class="pointer" onclick="SelEstacion('.$id.')">
          <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
          '.$estacion.'
          </a>
        </li>';
      }

    }else{
      echo '  
      <li>
        <a class="pointer" onclick="SelEstacion('.$id.')">
        <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
        '.$estacion.'
        </a>
      </li>';

    }

  
  }else{
    echo '  
    <li>
      <a class="pointer" onclick="SelEstacion('.$id.')">
      <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
      '.$estacion.'
      </a>
    </li>';
  
  }




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
  <a class="text-dark" onclick="history.back()">Terminales punto de venta</a>
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
  <a class="dropdown-item" href="../perfil">
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
  <div class="col-12" id="ListaTerminales"></div>
  </div>
  </div> 
  </div>


</div>

  <!---------- MODAL ---------->
  <div class="modal right fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
  <div class="modal-content" id="ContenidoModal"></div>
  </div>
  </div>
  
  <!---------- MODAL ----------> 
  <div class="modal fade" id="Modal2" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="ContenidoModal2">
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

