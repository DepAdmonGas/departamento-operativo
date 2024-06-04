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
      "accion": "eliminar-permiso"
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
        <div class="col-12">
          <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
            <ol class="breadcrumb breadcrumb-caret">
              <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-house"></i>
                  Recursos Humanos</a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">Permisos</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-9">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Permisos</h3>
            </div>
            <div class="col-3">
              <button type="button" class="btn btn-labeled2 btn-primary float-end"
                onclick="Registro(<?= $Session_IDEstacion; ?>)">
                <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
            </div>
          </div>

          <hr>
        </div>
        <div class="col-12" id="Permisos"></div>
      </div>
    </div>

  </div>
  <!--Contenido Modal-->
  <div class="modal right fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
      <div class="modal-content" id="ContenidoModal"></div>
    </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>

</html>