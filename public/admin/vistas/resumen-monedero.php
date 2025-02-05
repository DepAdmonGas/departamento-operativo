<?php
require ('app/help.php');

if ($Session_IDUsuarioBD == "") {
  header("Location:" . PORTAL . "");
}

function IdReporte($Session_IDEstacion, $GET_year, $GET_mes, $con)
{
  $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '" . $Session_IDEstacion . "' AND year = '" . $GET_year . "' ";
  $result_year = mysqli_query($con, $sql_year);
  while ($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)) {
    $idyear = $row_year['id'];
  }

  $sql_mes = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '" . $idyear . "' AND mes = '" . $GET_mes . "' ";
  $result_mes = mysqli_query($con, $sql_mes);
  while ($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)) {
    $idmes = $row_mes['id'];
  }

  return $idmes;
}
$IdReporte = IdReporte($GET_idEstacion, $GET_year, $GET_mes, $con);


$sql_listaestacion = "SELECT id, nombre FROM tb_estaciones WHERE id = '" . $GET_idEstacion . "'";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
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
  <link rel="shortcut icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?= RUTA_CSS2 ?>alertify.css">
  <link rel="stylesheet" href="<?= RUTA_CSS2 ?>themes/default.rtl.css">
  <link href="<?= RUTA_CSS2; ?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?= RUTA_CSS2; ?>navbar-general.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script type="text/javascript">
    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      ListaMonedero(<?= $GET_idEstacion; ?>, <?= $GET_year; ?>, <?= $GET_mes; ?>);
    });

    function Regresar() {
      window.history.back();
    }

    function ListaMonedero(idEstacion, year, mes) {

      $('#Monedero').load('../../../../public/admin/vistas/lista-resumen-monedero.php?year=' + year + '&mes=' + mes + '&idEstacion=' + idEstacion);
    }

    function ListaModal(IdReporte, year, mes) {
      $('#Modal').modal('show');
      $('#ListaDocumento').load('../../../../public/admin/vistas/lista-monedero-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
    }

    function Nuevo(IdReporte, year, mes) {
      $('#ListaDocumento').load('../../../../public/admin/vistas/formulario-monedero-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
    }

    function Cancelar(IdReporte, year, mes) {
      $('#ListaDocumento').load('../../../../public/admin/vistas/lista-monedero-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
    }

    function Guardar(IdReporte, year, mes) {
      var Fecha = $('#Fecha').val();
      var Cilote = $('#Cilote').val();
      var Diferencia = $('#Diferencia').val();

      var data = new FormData();
      var url = '../../../../public/admin/modelo/agregar-documento-monedero.php';

      PDF = document.getElementById("PDF");
      PDF_file = PDF.files[0];
      PDF_filePath = PDF.value;

      XML = document.getElementById("XML");
      XML_file = XML.files[0];
      XML_filePath = XML.value;

      if (Fecha != "") {
        $('#Fecha').css('border', '');
        if (Cilote != "") {
          $('#Cilote').css('border', '');
          if (Diferencia != "") {
            $('#Diferencia').css('border', '');
          if (PDF_filePath != "") {
            $('#PDF').css('border', '');
            if (XML_filePath != "") {
              $('#XML').css('border', '');

              data.append('IdReporte', IdReporte);
              data.append('year', year);
              data.append('mes', mes);
              data.append('Fecha', Fecha);
              data.append('Cilote', Cilote);
              data.append('Diferencia', Diferencia);
              data.append('XML_file', XML_file);
              data.append('PDF_file', PDF_file);

              $(".LoaderPage").show();

              $.ajax({
                url: url,
                type: 'POST',
                contentType: false,
                data: data,
                processData: false,
                cache: false
              }).done(function (data) {

                $(".LoaderPage").hide();
                Cancelar(IdReporte, year, mes);
                alertify.success('Factura agregada exitosamente.');  

              });

            } else {
              $('#XML').css('border', '2px solid #A52525');
            }
          } else {
            $('#PDF').css('border', '2px solid #A52525');
          }
        } else {
          $('#Diferencia').css('border', '2px solid #A52525');
        }
        } else {
          $('#Cilote').css('border', '2px solid #A52525');
        }
      } else {
        $('#Fecha').css('border', '2px solid #A52525');
      }

    }

    function Eliminar(IdReporte, year, mes, id) {
      $('#Eliminar').tooltip('hide');

      var parametros = {
        "IdReporte": IdReporte,
        "id": id
      };

      $.ajax({
        data: parametros,
        url: '../../../../public/admin/modelo/eliminar-documento-monedero.php',
        type: 'post',
        beforeSend: function () {
          $(".LoaderPage").show();
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {

            $(".LoaderPage").hide();
            alertify.success('Registro eliminado exitosamente.');  
            Cancelar(IdReporte, year, mes);

          } else {
            alertify.error('Error al eliminar')
            $(".LoaderPage").hide();

          }

        }
      });

    }

    function Editar(IdReporte, year, mes, id) {
      $('#Editar').tooltip('hide')
      $('#ListaDocumento').load('../../../../public/admin/vistas/editar-monedero-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes + '&id=' + id);
    }

    function EditarInfo(IdReporte, year, mes, id) {

      var Fecha = $('#Fecha').val();
      var Cilote = $('#Cilote').val();
      var Diferencia = $('#Diferencia').val();



      PDF = document.getElementById("PDF");
      PDF_file = PDF.files[0];
      PDF_filePath = PDF.value;

      XML = document.getElementById("XML");
      XML_file = XML.files[0];
      XML_filePath = XML.value;

      EXCEL = document.getElementById("EXCEL");
      EXCEL_file = EXCEL.files[0];
      EXCEL_filePath = EXCEL.value;

      SoporteD = document.getElementById("SoporteD");
      SoporteD_file = SoporteD.files[0];
      SoporteD_filePath = SoporteD.value;
     
      if (Fecha != "") {
        $('#Fecha').css('border', '');
        if (Cilote != "") {
          $('#Cilote').css('border', '');
          if (Diferencia != "") {
            $('#Diferencia').css('border', '');

            var data = new FormData();
            var url = '../../../../public/admin/modelo/editar-documento-monedero.php';
            
      data.append('id', id);
      data.append('Fecha', Fecha);
      data.append('Cilote', Cilote);
      data.append('Diferencia', Diferencia);
      data.append('XML_file', XML_file);
      data.append('PDF_file', PDF_file);
      data.append('EXCEL_file', EXCEL_file);
      data.append('SoporteD_file', SoporteD_file);

      $(".LoaderPage").show();

      $.ajax({
        url: url,
        type: 'POST',
        contentType: false,
        data: data,
        processData: false,
        cache: false
      }).done(function (data) {

        $(".LoaderPage").hide();
        Cancelar(IdReporte, year, mes);
        alertify.success('Información editada exitosamente.');


      });

    } else {
          $('#Diferencia').css('border', '2px solid #A52525');
        }
        } else {
          $('#Cilote').css('border', '2px solid #A52525');
        }
      } else {
        $('#Fecha').css('border', '2px solid #A52525');
      }

    }

    function Edi(IdReporte, year, mes, id) {
      $('#DocEDI').tooltip('hide')
      $('#ListaDocumento').load('../../../../public/admin/vistas/editar-monedero-documento-edi.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes + '&id=' + id);
    }

    function GuardarC(IdReporte, year, mes, id) {

      var Complemento = $('#Complemento').val();
      PDF = document.getElementById("PDF");
      PDF_file = PDF.files[0];
      PDF_filePath = PDF.value;

      XML = document.getElementById("XML");
      XML_file = XML.files[0];
      XML_filePath = XML.value;


      if (Complemento != "") {
      $('#Complemento').css('border', '');

      if (PDF_filePath != "") {
      $('#PDF').css('border', '');

      if (XML_filePath != "") {
      $('#XML').css('border', '');

      var data = new FormData();
      var url = '../../../../public/admin/modelo/agregar-documento-monedero-edi.php';

      data.append('id', id);
      data.append('Complemento', Complemento);
      data.append('XML_file', XML_file);
      data.append('PDF_file', PDF_file);

      $(".LoaderPage").show();

      $.ajax({
        url: url,
        type: 'POST',
        contentType: false,
        data: data,
        processData: false,
        cache: false
      }).done(function (data) {

        $(".LoaderPage").hide();

        if(data == 1){
          Edi(IdReporte, year, mes, id)

          alertify.success('Complemento agregado exitosamente.');
          
        }else{
          alertify.error('Error al agregar el complemento.');

        }

      });

    } else {
        $('#XML').css('border', '2px solid #A52525');
      }

    } else {
        $('#PDF').css('border', '2px solid #A52525');
      }

    } else {
        $('#Complemento').css('border', '2px solid #A52525');
      }

    }

    function EliminarEdi(IdReporte, iddoc, id, year, mes) {



      var parametros = {
        "IdReporte": IdReporte,
        "iddoc": iddoc,
        "id": id
      };

      $.ajax({
        data: parametros,
        url: '../../../../public/admin/modelo/eliminar-documento-monedero-edi.php',
        type: 'post',
        beforeSend: function () {
          $(".LoaderPage").show();
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {

            $(".LoaderPage").hide();

            Edi(IdReporte, year, mes, iddoc)
            alertify.success('Complemento eliminado exitosamente.');

          } else {
            alertify.error('Error al eliminar')
            $(".LoaderPage").hide();

          }

        }
      });

    }

    function Resumen(idEstacion, year, mes) {
      window.location.href = "../../../resumen-periodo-monedero/" + idEstacion + "/" + year + "/" + mes;
    }


    function monederoKPI(idEstacion, year, mes) {
      window.location.href = "../../../resumen-monedero-evaluacion/" + year + "/" + mes + "/" + idEstacion;

    }

    function DescargarExcelMonedero(idEstacion, year, mes){
  window.location.href = "../../../resumen-monedero-excel/" + idEstacion + "/" + year + "/" + mes;  
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
                    class="fa-solid fa-chevron-left"></i>
                  Corte Diario, <?= $ClassHerramientasDptoOperativo->nombreMes($GET_mes) ?> <?= $GET_year ?></a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">Resumen Monedero (<?= $estacion?>), <?= nombremes($GET_mes); ?> <?= $GET_year; ?>
              </li>
            </ol>
          </div>
          <div class="row">
            <div class="col-xl-11 col-lg-11 col-md-12 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
              Resumen Monedero (<?= $estacion?>), <?= nombremes($GET_mes); ?> <?= $GET_year; ?>
              </h3>
            </div>
            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12">
              <div class="text-end">
                <div class="dropdown d-inline ms-2">
                  <button type="button" class="btn dropdown-toggle btn-primary" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-screwdriver-wrench"></i> </button>

                  <ul class="dropdown-menu">
                    <li onclick="ListaModal(<?= $IdReporte; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                      <a class="dropdown-item pointer"><i class="fa-solid fa-file-lines"></i> Facturas</a>
                    </li>

                    <li onclick="Resumen(<?= $GET_idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                      <a class="dropdown-item pointer"><i class="fa-solid fa-money-bill-trend-up"></i> Resumen por Periodo</a>
                    </li>

              
                    <li onclick="DescargarExcelMonedero(<?= $GET_idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                      <a class="dropdown-item pointer"><i class="fa-solid fa-file-excel"></i> Descargar Resumen <?= nombremes($GET_mes); ?> <?= $GET_year; ?></a>
                    </li>

                    <?php 
                    if ($session_nompuesto == "Dirección de operaciones") {
                      ?>
                      <li onclick="monederoKPI(<?= $GET_idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                        <a class="dropdown-item pointer"><i class="fa-solid  fa-chart-line"></i> Evaluacion Facturas de Monederos (KPI's)</a>
                      </li>
                      <?php
                    }
                    ?>
                  </ul>
                </div>

              </div>
            </div>
          </div>
          <hr>
        </div>

        <div class="col-12">
          <div id="Monedero"></div>
        </div>
      </div>
    </div>

  </div>



  <div class="modal" id="Modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Facturas</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
          <div id="ListaDocumento"></div>
      </div>
    </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>navbar-functions.js"></script>

  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>

</html>