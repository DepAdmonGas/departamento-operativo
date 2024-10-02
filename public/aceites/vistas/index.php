<?php
require ('app/help.php');

if ($Session_IDUsuarioBD == "") {
  header("Location:" . PORTAL . "");
}

?>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?= RUTA_CSS2 ?>alertify.css">
  <link rel="stylesheet" href="<?= RUTA_CSS2 ?>themes/default.rtl.css">
  <link href="<?= RUTA_CSS2; ?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?= RUTA_CSS2; ?>navbar-general.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">


  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      ListaAceites();
    });

    function Regresar() {
      window.history.back();
    }

    function ListaAceites() {
      $('#DivAceites').load('../public/aceites/vistas/lista-aceites.php');
    }

    function EditNoAceite(val, idAceite) {

      var noaceite = val.value;

      var parametros = {
        "type": "noaceite",
        "idAceite": idAceite,
        "noaceite": noaceite
      };

      $.ajax({
        data: parametros,
        url: '../public/aceites/modelo/editar-aceite.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 0) {
            ListaAceites();
          } else {
          }

        }
      });

    }

    function EditConcepto(val, idAceite) {

      var concepto = val.value;

      var parametros = {
        "type": "concepto",
        "idAceite": idAceite,
        "concepto": concepto
      };

      $.ajax({
        data: parametros,
        url: '../public/aceites/modelo/editar-aceite.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 0) {
            ListaAceites();
          } else {
          }

        }
      });

    }

    function EditPrecio(val, idAceite) {

      var precio = val.value;

      var parametros = {
        "type": "precio",
        "idAceite": idAceite,
        "precio": precio
      };

      $.ajax({
        data: parametros,
        url: '../public/aceites/modelo/editar-aceite.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 0) {
            ListaAceites();
          } else {
          }

        }
      });

    }

    function NewAceite() {

$.ajax({
  url: '../public/aceites/modelo/nuevo-aceite.php',
  type: 'post',
  beforeSend: function () {
    // Puedes añadir algún indicador de carga aquí
  },
  complete: function () {
    ListaAceites();
    // Desplazarse al final de la página
    document.getElementById('finalDePagina').scrollIntoView({ behavior: 'smooth' });
  },
  success: function (response) {

  alertify.success('Fila agregada al final de la tabla.');

  }
});

}

    function Scroll(response) {
      $('html, body').animate({
        scrollTop: $("#noAceite-" + response).offset().top
      }, 0);
    }

    function EditPiezas(val, idAceite) {
      var piezas = val.value;

      var parametros = {
        "type": "piezas",
        "idAceite": idAceite,
        "piezas": piezas
      };

      $.ajax({
        data: parametros,
        url: '../public/aceites/modelo/editar-aceite.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 0) {
            ListaAceites();
          } else {

          }

        }
      });
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
      <div class="col-12">
        <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
          <ol class="breadcrumb breadcrumb-caret">
            <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                  class="fa-solid fa-chevron-left"></i>
                Regresar</a></li>
            <li aria-current="page" class="breadcrumb-item active text-uppercase">
              Lista de Aceites
            </li>
          </ol>
        </div>
        <div class="row">
          <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
            <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
              Lista de Aceites
            </h3>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-2">
            <button type="button" class="btn btn-labeled2 btn-primary float-end ms-2"
              onclick="NewAceite()">
              <span class="btn-label2"><i class="fa-solid fa-plus"></i></span>Agregar</button>
          </div>

        </div>
        <hr>
      </div>
      <div class="col-12">
      <div id="DivAceites"></div>
      </div>
    </div>

    <div id="finalDePagina"></div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>

</html>