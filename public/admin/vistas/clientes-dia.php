<?php
require ('app/help.php');


$sql_dia = "SELECT fecha FROM op_corte_dia WHERE id = '" . $GET_idReporte . "' ";
$result_dia = mysqli_query($con, $sql_dia);
while ($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)) {
  $dia = $row_dia['fecha'];
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>



  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      ListaConsumoPago(<?= $GET_idReporte; ?>);
      localStorage.clear();

    });

    function Regresar() {
      window.history.back();
    }

    function ListaConsumoPago(idReporte) {
      $('#ConsumosPagos').load('../../../../public/admin/vistas/lista-consumo-pagos.php?idReporte=' + idReporte);
    }

    function ClientesLista(year, mes, idDias) {
      window.location.href = "../../../clientes-lista/" + year + "/" + mes + "/" + idDias;
    }


    window.addEventListener('pageshow', function (event) {
  if (event.persisted) {
  // Si la página está en la caché del navegador, recargarla
  window.location.reload();
  }
  });

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
                    class="fa-solid fa-chevron-left"></i>
                  Corte Diario, <?= $ClassHerramientasDptoOperativo->nombreMes($GET_mes) ?> <?= $GET_year ?></a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">Clientes
                (<?= $ClassHerramientasDptoOperativo->FormatoFecha($dia) ?>)</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Clientes (<?= $ClassHerramientasDptoOperativo->FormatoFecha($dia); ?>)
              </h3>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
              <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="ClientesLista(<?= $GET_year; ?>,<?= $GET_mes; ?>,<?= $GET_idReporte; ?>)">
                <span class="btn-label2"><i class="fa-solid fa-users"></i></span>Lista de Clientes</button>
            </div>
          </div>
          <hr>
        </div>

        <div class="mb-2">
          <div id="ConsumosPagos"></div>
        </div>



      </div>
    </div>

  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>


</body>

</html>