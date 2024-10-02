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
  $(referencia).load('app/vistas/contenido/2-recursos-humanos/organigrama/contenido-organigrama.php?idEstacion=' + idEstacion + "&idOrganigrama=" + idOrganigrama);

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