<?php
require 'app/vistas/contenido/header.php';
?>
<style media="screen">
  .decorado:hover {
    text-decoration: none;
  }

  .grayscale {
    filter: opacity(50%);
  }
</style>

<script type="text/javascript">

  $(document).ready(function ($) {
    $(".LoaderPage").fadeOut("slow");

    SelEstacion(<?= $Session_IDEstacion; ?>)

  });
  function SelEstacion(idEstacion) {
    //$('#Permisos').load('public/recursos-humanos/vistas/contenido-recursos-humanos-permisos.php?idEstacion=' + idEstacion);
    $('#Permisos').load('app/vistas/contenido/2-recursos-humanos/permisos/contenido-permisos.php?idEstacion=' + idEstacion);
  }

  function Registro(idEstacion) {
    // ruta cambiada en index.php
    window.location.href = "recursos-humanos-permiso-nuevo/" + idEstacion;
  }

  function Eliminar(idPermiso, idEstacion) {

    var parametros = {
      "idPermiso": idPermiso,
      "accion":"eliminar-permiso"
    };

    alertify.confirm('',
      function () {

        $.ajax({
          data: parametros,
          //url: 'public/recursos-humanos/modelo/eliminar-permisos.php',
          url: 'app/controlador/2-recursos-humanos/controladorPermisos.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {
            console.log(response);
            if (response == 1) {
              SelEstacion(idEstacion)
              alertify.success('Registro eliminado exitosamente.');

            } else {
              alertify.error('Error al eliminar');
            }

          }
        });

      },
      function () {

      }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

  }
  // checar, ya que no esta habilitado en la pagina 
  function Editar(idPermiso) {
    window.location.href = "recursos-humanos-permiso-editar/" + idPermiso;
  }

  function Firmar(id) {
    // se cambia la ruta en index
    window.location.href = "recursos-humanos-permisos-firmar/" + id;
  }

  function DetallePermiso(idPermiso) {

    $('#Modal').modal('show');
    //$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-permisos.php?idPermiso=' + idPermiso);
    $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/permisos/modal-detalle.php?idPermiso=' + idPermiso);

  }

</script>
</head>

<body>
  <div class="LoaderPage"></div>

  <!---------- DIV - CONTENIDO ---------->
  <div id="content">
    <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
    <?php include_once "public/navbar/navbar-perfil.php"; ?>
    <!---------- CONTENIDO PAGINA WEB---------->
    <div class="contendAG">
      <div class="row">

        <div class="col-12 mb-3">
          <div class="cardAG">

            <div id="Permisos"></div>

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
</body>

</html>