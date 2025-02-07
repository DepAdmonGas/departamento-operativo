<?php
require 'app/vistas/contenido/header.php';
?>

  <script type="text/javascript">
  $(document).ready(function ($) {
  $(".LoaderPage").fadeOut("slow");

  SelEstacion(<?= $Session_IDEstacion; ?>,0);
  if (<?= $Session_IDEstacion ?> == 2){
  SelEstacion(9, 0)
  }
  });
  
  function SelEstacion(idEstacion, idOrganigrama) {
  if (idEstacion == 9) {
  referencia = '#ContenidoOrganigrama2';
  }else{
  referencia = '#ContenidoOrganigrama';
  }

  //$('#ContenidoOrganigrama').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-organigrama.php?idEstacion=' + idEstacion + "&idOrganigrama=" + idOrganigrama);
  $(referencia).load('app/vistas/contenido/2-recursos-humanos/organigrama/contenido-organigrama.php?idEstacion=' + idEstacion + "&idOrganigrama=" + idOrganigrama, function() {
  // Una vez que el contenido de #ContenidoOrganigrama se haya cargado
  $('#tabla_plantilla').load('app/vistas/contenido/2-recursos-humanos/organigrama/lista-plantilla-estacion.php?idEstacion=' + idEstacion, function() {
  // Una vez que #tabla_plantilla se haya cargado completamente
  // Aquí es más seguro llamar a buscarNombres
  let dato = "";
  buscarNombres(dato, idEstacion);
  });
  });

  }

  function Mas(idEstacion) {
  $('#Modal').modal('show');
  //$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-organigrama-estacion.php?idEstacion=' + idEstacion);
  $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/organigrama/modal-agregar-organigrama.php?idEstacion=' + idEstacion);
  }

  function Guardar(idEstacion) {

    var seleccionArchivos = document.getElementById("seleccionArchivos");
    var seleccionArchivos_file = seleccionArchivos.files[0];
    var seleccionArchivos_filePath = seleccionArchivos.value;

    var Observaciones = $('#Observaciones').val();

    var input = $("#seleccionArchivos").val()
    var extencion = input.split(".").pop().toLowerCase();


    //var URL = "public/recursos-humanos/modelo/agregar-organigrama-estacion.php";
    var URL = "app/controlador/2-recursos-humanos/controladorOrganigrama.php";
    var data = new FormData();

    data.append('idEstacion', idEstacion);
    data.append('seleccionArchivos_file', seleccionArchivos_file);
    data.append('Observaciones', Observaciones);
    data.append('accion', 'guardar-organigrama');

    if (input != "") {

      $("#seleccionArchivos").css('border', '');

      if (extencion == "jpg" || extencion == "png" || extencion == "jpeg" || extencion == "JPG" || extencion == "PNG" || extencion == "JPEG") {

        $("#Mensaje").html('');

        $.ajax({
          url: URL,
          type: 'POST',
          contentType: false,
          data: data,
          processData: false,
          cache: false
        }).done(function (data) {

          if (data == 1) {
            SelEstacion(idEstacion, 0);
            alertify.success('Organigrama agregado exitosamente.');

            $('#Modal').modal('hide');

          } else {
            alertify.error('Error al agregar organigrama.');
          }
        });


      } else {
        alertify.error('La imagen debe ser .JPG o .PNG');
      }
    } else {
      $("#seleccionArchivos").css('border', '2px solid #A52525');
    }
  }

  function Eliminar(idEstacion, idOrganigrama) {

    alertify.confirm('',
      function () {

        var parametros = {
          "idOrganigrama": idOrganigrama,
          "accion": "eliminar-organigrama"
        }; 

        $.ajax({
          data: parametros,
          url: 'app/controlador/2-recursos-humanos/controladorOrganigrama.php',
          //url: 'public/recursos-humanos/modelo/eliminar-organigrama-estacion.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {
            if (response == 1) {
              SelEstacion(idEstacion, 0);
              alertify.success('Organigrama eliminado exitosamente.');
            } else {
              alertify.danger('Error al eliminar organigrama.');
            }

          }
        });

      },
      function () {

      }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

  }



  function datosRazonSocial(e, id, num){
  var valor = e.value;
  
  var parametros = {
  "valor": valor,
  "id": id,
  "num": num
  };


  $.ajax({
  data: parametros,
  url:   'public/recursos-humanos/modelo/editar-organigrama-info-estacion.php',
  type: 'post',
  beforeSend: function () {
         
  },
  complete: function () {

  },
  success: function (response) {

  if (response == 1) {
  alertify.success('Información actualizada exitosamente.')

  } else {
  alertify.error('Error al editar la información.')

  }

  }
  });

  }


  
  //---------- CONTENIDO SELECT USUARIOS (DINAMICO) ---------
  function buscarNombres(e, idEstacion) {
  
  let dato = e.value;

  let parametros = {
  "dato" : dato,
  "idEstacion" : idEstacion
  };

  $.ajax({
  data:  parametros,
  url:   'app/vistas/contenido/2-recursos-humanos/organigrama/select-plantilla-usuarios.php',
  type: 'GET',
  beforeSend: function() {

  },
  complete: function(){

  },
  success:  function (response) {

  $('#listaNombres_' + idEstacion).html(response);

  }
  });

  }

  //---------- VALIDAR PLANTILLA DEL ORGANIGRAMA ---------
  function datosPlantilla(e, idPlantilla, idEstacion, consulta) {
    
    // Si consulta es 2, solo validar y mostrar un mensaje
    if (consulta == 2) {
    var empleado = $('#NombresCompleto_' + idPlantilla).val(); // Obtener el nombre completo seleccionado
    var empleadoId = null; // Variable para almacenar el id del empleado
    // Buscar el id del empleado correspondiente al nombre seleccionado en el datalist específico
    $('#listaNombres_' + idEstacion + ' option').each(function() {
    if ($(this).val() === empleado) {
    empleadoId = $(this).data('id');
    return false; // Salir del bucle si se encuentra el empleado
    }
    });
  
    if (empleadoId) {
    actualizarDatos(idPlantilla, empleadoId, consulta);
      
    }else{
    actualizarDatos(idPlantilla, empleado, 3);
  
    }
    
      
    }else{
    var valor = e.value;
  
    if(valor == ""){
    alertify.error('Debes de ingresar la descripcion del puesto');
  
    }else{
    actualizarDatos(idPlantilla, valor, consulta);
  
    }
  
    }
  
    }
  
    //---------- VALIDAR PLANTILLA DEL ORGANIGRAMA ---------
    function actualizarDatos(idPlantilla, valor, consulta){
    
    var parametros = {
    "idPlantilla" : idPlantilla,
    "valor" : valor,
    "consulta" : consulta
    };
          
    $.ajax({
    data:  parametros,
    url:  'public/recursos-humanos/modelo/editar-fila-plantilla.php',
    type: 'post',   
    beforeSend: function () {
        // Puedes añadir algún indicador de carga aquí
    },
    complete: function () {
  
    },
    success: function (response) {
  
    if(response == 1){
  
    if(consulta == 2 || consulta == 3){
    location.reload();
  
    }else{
    alertify.success('Registro actualizado exitosamente.');
  
    }
  
    }else{
    alertify.error('Error al actualizar el registro.');
  
    }
  
    }
    });
    
    }


  function ModalCP(idPlantilla){
$('#Modal').modal('show');  
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-contrato-perfil.php?idPlantilla=' + idPlantilla); 
}


function GuardarCP(idPlantilla){
var NomDocumento = $('#NomDocumento').val();

var Archivo = document.getElementById("Archivo");
var seleccionArchivos_file = Archivo.files[0];
var seleccionArchivos_filePath = Archivo.value;

var input = $("#Archivo").val()
var extencion = input.split(".").pop().toLowerCase();

var URL = "public/recursos-humanos/modelo/agregar-organigrama-documentos.php";
var data = new FormData();
 
if(NomDocumento != "" ){
if( extencion == "pdf" || extencion == "PDF" ){

data.append('idPlantilla', idPlantilla);
data.append('seleccionArchivos_file', seleccionArchivos_file);
data.append('NomDocumento', NomDocumento);
 
$.ajax({
url: URL,
type: 'POST',
contentType: false,
data: data,
processData: false,
cache: false
}).done(function(data){

alertify.success('Documentacion actualizada exitosamente.');
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-contrato-perfil.php?idPlantilla=' + idPlantilla); 

});

}else{
$("#Respuesta").html('<div class="alert alert-warning text-center" role="alert">Solo se permiten archivos en formato PDF</div>');
}
}else{
$("#NomDocumento").css('border','2px solid #A52525');
}

}


function EliminarCP(idPlantilla, tipo){
var parametros = {
"idPlantilla" : idPlantilla,
"tipo" : tipo
};

 alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/eliminar-organigrama-contrato-perfil.php',
    type:  'post',
    beforeSend: function() {

    },
    complete: function(){
 
    },
    success:  function (response) {

    if (response == 1) {
    alertify.success('Documento eliminado exitosamente.');
    $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-contrato-perfil.php?idPlantilla=' + idPlantilla); 

    }else{
    alertify.error('Error al eliminar');
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
}

</script>

<body>
  <div class="LoaderPage"></div>


  <!---------- DIV - CONTENIDO ---------->
  <div id="content">
    <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
    <?php include_once "public/navbar/navbar-perfil.php"; ?>
    <!---------- CONTENIDO PAGINA WEB---------->
    <div class="contendAG">

      <div class="row">
        <div class="col-12" id="ContenidoOrganigrama"></div>
        <div class="col-12" id="ContenidoOrganigrama2"></div>
      </div>


    </div>
  </div>

  </div>


  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="ContenidoModal">
  </div>
  </div>
  </div>



</body>
<!---------- FUNCIONES - NAVBAR ---------->
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</html>