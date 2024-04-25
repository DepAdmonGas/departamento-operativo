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

$IdReporte = IdReporte($Session_IDEstacion, $GET_year, $GET_mes, $con);

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

      ListaEmbarques(<?= $IdReporte; ?>);

    });

    function Regresar() {
      window.history.back();
    }

    function ListaEmbarques(IdReporte) {
      $('#DivEmbarques').load('../../public/corte-diario/vistas/lista-embarques-mes.php?IdReporte=' + IdReporte);
    }

    function Mas(IdReporte) {
      $('#Modal').modal('show');
      $('#ModalEmbarques').load('../../public/corte-diario/vistas/modal-embarques-mes.php?IdReporte=' + IdReporte);
    }



    function Embarque(val) {

      var Embarque = $('#Embarque').val();

      if (Embarque == "Pemex") {
        document.getElementById("FacturasUP").style.display = "none";
        document.getElementById("ComprobantePagoUp").style.display = "none";
        document.getElementById("ComprobantePagoUp").style.display = "none";
        document.getElementById("NotaCreditoUp").style.display = "none";
        document.getElementById("ComplementoUp").style.display = "none";
        document.getElementById("DivMerma").style.display = "none";


      } else if (Embarque == "Delivery") {
        document.getElementById("FacturasUP").style.display = "none";
        document.getElementById("ComprobantePagoUp").style.display = "none";
        document.getElementById("ComprobantePagoUp").style.display = "none";
        document.getElementById("NotaCreditoUp").style.display = "none";
        document.getElementById("ComplementoUp").style.display = "none";
        document.getElementById("DivMerma").style.display = "block";


      } else if (Embarque == "Pick Up") {
        document.getElementById("FacturasUP").style.display = "block";
        document.getElementById("ComprobantePagoUp").style.display = "block";
        document.getElementById("ComprobantePagoUp").style.display = "block";
        document.getElementById("NotaCreditoUp").style.display = "block";
        document.getElementById("ComplementoUp").style.display = "block";
        document.getElementById("DivMerma").style.display = "block";

      } else {
        document.getElementById("FacturasUP").style.display = "none";
        document.getElementById("ComprobantePagoUp").style.display = "none";
        document.getElementById("ComprobantePagoUp").style.display = "none";
        document.getElementById("NotaCreditoUp").style.display = "none";
        document.getElementById("ComplementoUp").style.display = "none";
        document.getElementById("DivMerma").style.display = "none";
      }

    }



    function Guardar(IdReporte) {


      //----- PRIMERA SECCION FORMULARIO -----//
      var Fecha = $('#Fecha').val();
      var Embarque = $('#Embarque').val();
      var Producto = $('#Producto').val();
      var Documento = $('#Documento').val();
      var NoDocumento = $('#NoDocumento').val();
      var ImporteF = $('#ImporteF').val();
      var PrecioLitro = $('#PrecioLitro').val();
      var Tad = $('#Tad').val();

      //----- TERCERA SECCION FORMULARIO -----//
      var Chofer = $('#Chofer').val();
      var Unidad = $('#Unidad').val();


      //----- CUARTA SECCION FORMULARIO -----//
      var Merma = $('#Merma').val();
      var NombreTransporte = $('#NombreTransporte').val();


      var data = new FormData();
      var url = '../../app/controlador/controladorCorteDiario.php';
      //var url = '../../public/corte-diario/modelo/agregar-embarques-mes.php';

      Documento = document.getElementById("Documento");
      Documento_file = Documento.files[0];
      Documento_filePath = Documento.value;

      //----- FACTURAS XML Y PDF -----//
      PDF = document.getElementById("PDF");
      PDF_file = PDF.files[0];
      PDF_filePath = PDF.value;

      XML = document.getElementById("XML");
      XML_file = XML.files[0];
      XML_filePath = XML.value;


      //----- COMPROBANTE DE PAGO -----//
      CoPa = document.getElementById("CoPa");
      CoPa_file = CoPa.files[0];
      CoPa_filePath = CoPa.value;


      //----- NOTA DE CREDITO -----//
      NCPDF = document.getElementById("NCPDF");
      NCPDF_file = NCPDF.files[0];
      NCPDF_filePath = NCPDF.value;

      NCXML = document.getElementById("NCXML");
      NCXML_file = NCXML.files[0];
      NCXML_filePath = NCXML.value;


      //----- COMPLEMENTO XML Y PDF -----//
      ComPDF = document.getElementById("ComPDF");
      ComPDF_file = ComPDF.files[0];
      ComPDF_filePath = ComPDF.value;

      ComXML = document.getElementById("ComXML");
      ComXML_file = ComXML.files[0];
      ComXML_filePath = ComXML.value;


      if (Embarque != "") {
        $('#Embarque').css('border', '');
        if (Producto != "") {
          $('#Producto').css('border', '');
          if (Documento_filePath != "") {
            $('#Documento').css('border', '');

            data.append('IdReporte', IdReporte);

            //----- PRIMERA SECCION FORMULARIO -----//
            data.append('Fecha', Fecha);
            data.append('Embarque', Embarque);
            data.append('Producto', Producto);
            data.append('Documento_file', Documento_file);
            data.append('NoDocumento', NoDocumento);
            data.append('ImporteF', ImporteF);
            data.append('PrecioLitro', PrecioLitro);
            data.append('Tad', Tad);

            //----- SEGUNDA SECCION FORMULARIO -----//
            data.append('PDF_file', PDF_file);
            data.append('XML_file', XML_file);
            data.append('CoPa_file', CoPa_file);
            data.append('NCPDF_file', NCPDF_file);
            data.append('NCXML_file', NCXML_file);
            data.append('ComPDF_file', ComPDF_file);
            data.append('ComXML_file', ComXML_file);

            //----- TERCERA SECCION FORMULARIO -----//
            data.append('Chofer', Chofer);
            data.append('Unidad', Unidad);

            //----- CUARTA SECCION FORMULARIO -----//
            data.append('Merma', Merma);
            data.append('NombreTransporte', NombreTransporte);
            data.append('accion','agregar-embarque');


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
              $('#Modal').modal('hide');

              alertify.success('Embarque agreado exitosamente')
              ListaEmbarques(IdReporte);

            });

          } else {
            $('#Documento').css('border', '2px solid #A52525');
          }
        } else {
          $('#Producto').css('border', '2px solid #A52525');
        }
      } else {
        $('#Embarque').css('border', '2px solid #A52525');
      }

    }



    function Eliminar(IdReporte, id) {

      var parametros = {
        "idReporte": IdReporte,
        "id": id
      };

      $.ajax({
        data: parametros,
        url: '../../public/corte-diario/modelo/eliminar-embarque-mes.php',
        type: 'post',
        beforeSend: function () {
          $(".LoaderPage").show();
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {

            $(".LoaderPage").hide();

            ListaEmbarques(IdReporte);
            alertify.success('Embarque eliminado exitosamente.')

          } else {
            alertify.error('Error al eliminar')
            $(".LoaderPage").hide();

          }

        }
      });

    }

    function Editar(idReporte, id, idestacion) {
      $('#Modal').modal('show');
      $('#ModalEmbarques').load('../../public/corte-diario/vistas/modal-editar-embarques-mes.php?idReporte=' + idReporte + '&id=' + id + '&idestacion=' + idestacion);
    }

    function EditarE(IdReporte, id, idestacion) {

      //----- PRIMERA SECCION FORMULARIO -----//
      var Fecha = $('#Fecha').val();
      var Embarque = $('#Embarque').val();
      var Producto = $('#Producto').val();
      var Documento = $('#Documento').val();
      var NoDocumento = $('#NoDocumento').val();
      var ImporteF = $('#ImporteF').val();
      var PrecioLitro = $('#PrecioLitro').val();
      var Tad = $('#Tad').val();

      //----- TERCERA SECCION FORMULARIO -----//
      var Chofer = $('#Chofer').val();
      var Unidad = $('#Unidad').val();


      //----- CUARTA SECCION FORMULARIO -----//
      var Merma = $('#Merma').val();
      var NombreTransporte = $('#NombreTransporte').val();


      var data = new FormData();
      var url = '../../app/controlador/controladorCorteDiario.php';
      //var url = '../../public/corte-diario/modelo/editar-embarques-mes.php';

      Documento = document.getElementById("Documento");
      Documento_file = Documento.files[0];
      Documento_filePath = Documento.value;

      //----- FACTURAS XML Y PDF -----//
      PDF = document.getElementById("PDF");
      PDF_file = PDF.files[0];
      PDF_filePath = PDF.value;

      XML = document.getElementById("XML");
      XML_file = XML.files[0];
      XML_filePath = XML.value;


      //----- COMPROBANTE DE PAGO -----//
      CoPa = document.getElementById("CoPa");
      CoPa_file = CoPa.files[0];
      CoPa_filePath = CoPa.value;


      //----- NOTA DE CREDITO -----//
      NCPDF = document.getElementById("NCPDF");
      NCPDF_file = NCPDF.files[0];
      NCPDF_filePath = NCPDF.value;

      NCXML = document.getElementById("NCXML");
      NCXML_file = NCXML.files[0];
      NCXML_filePath = NCXML.value;


      //----- COMPLEMENTO XML Y PDF -----//
      ComPDF = document.getElementById("ComPDF");
      ComPDF_file = ComPDF.files[0];
      ComPDF_filePath = ComPDF.value;

      ComXML = document.getElementById("ComXML");
      ComXML_file = ComXML.files[0];
      ComXML_filePath = ComXML.value;


      data.append('id', id);

      //----- PRIMERA SECCION FORMULARIO -----//
      data.append('Fecha', Fecha);
      data.append('Embarque', Embarque);
      data.append('Producto', Producto);
      data.append('Documento_file', Documento_file);
      data.append('NoDocumento', NoDocumento);
      data.append('ImporteF', ImporteF);
      data.append('PrecioLitro', PrecioLitro);
      data.append('Tad', Tad);

      //----- SEGUNDA SECCION FORMULARIO -----//
      data.append('PDF_file', PDF_file);
      data.append('XML_file', XML_file);
      data.append('CoPa_file', CoPa_file);
      data.append('NCPDF_file', NCPDF_file);
      data.append('NCXML_file', NCXML_file);
      data.append('ComPDF_file', ComPDF_file);
      data.append('ComXML_file', ComXML_file);

      //----- TERCERA SECCION FORMULARIO -----//
      data.append('Chofer', Chofer);
      data.append('Unidad', Unidad);

      //----- CUARTA SECCION FORMULARIO -----//
      data.append('Merma', Merma);
      data.append('NombreTransporte', NombreTransporte);
      data.append('accion', 'actualiza-embarque');

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
        $('#Modal').modal('hide');
        ListaEmbarques(IdReporte);
        alertify.success('Registro editado exitosamente.')
      });

    }



    function ModalComentario(idReporte, id, idestacion) {
      $('#Modal').modal('show');
      $('#ModalEmbarques').load('../../public/corte-diario/vistas/modal-comentarios-embarques.php?idReporte=' + idReporte + '&id=' + id + '&idestacion=' + idestacion);
    }

    function GuardarComentario(idReporte, id, idestacion) {

      var Comentario = $('#Comentario').val();

      var parametros = {
        "id": id,
        "idEstacion": idestacion,
        "Comentario": Comentario,
        "accion": "agregar-comentario-embarques"
      };

      if (Comentario != "") {
        $('#Comentario').css('border', '');

        $.ajax({
          data: parametros,
          url: '../../app/controlador/controladorCorteDiario.php',
          //url:   '../../public/corte-diario/modelo/agregar-comentario-embarques.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {
            if (response == 1) {
              $('#Comentario').val('');
              ListaEmbarques(idReporte);
              $('#ModalEmbarques').load('../../public/corte-diario/vistas/modal-comentarios-embarques.php?idReporte=' + idReporte + '&id=' + id + '&idestacion=' + idestacion);
            } else {
              alertify.error('Error al agregar comentario');
            }

          }
        });

      } else {
        $('#Comentario').css('border', '2px solid #A52525');
      }
    }

    function Eliminar(idReporte, id, idestacion) {

      var parametros = {
        "idReporte": idReporte,
        "id": id,
        "accion" : "elimina-embarque"
      };

      $.ajax({
        data: parametros,
        url: '../../app/controlador/controladorCortediario.php',
        //url: '../../public/corte-diario/modelo/eliminar-embarque-mes.php',
        type: 'post',
        beforeSend: function () {
          $(".LoaderPage").show();
        },
        complete: function () {

        },
        success: function (response) {
          if (response == 1) {
            $(".LoaderPage").hide();

            ListaEmbarques(idReporte);
            alertify.success('Embarque eliminado exitosamente.')

          } else {
            alertify.error('Error al eliminar')
            $(".LoaderPage").hide();

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
      <div class="row">

        <div class="col-12 mb-3">
          <div class="cardAG">
            <div class="border-0 p-3">

              <div class="row">
                <div class="col-12">

                  <img class="float-start pointer" src="<?= RUTA_IMG_ICONOS; ?>regresar.png" onclick="Regresar()">

                  <div class="row">
                    <div class="col-11">
                      <h5> Embarques, <?= nombremes($GET_mes); ?> <?= $GET_year; ?></h5>
                    </div>

                    <div class="col-1">
                      <img class="float-end pointer" src="<?= RUTA_IMG_ICONOS; ?>agregar.png"
                        onclick="Mas(<?= $IdReporte; ?>)">
                    </div>

                  </div>

                </div>
              </div>

              <hr>


              <div id="DivEmbarques"></div>


            </div>
          </div>
        </div>

      </div>
    </div>

  </div>



  <div class="modal" id="Modal">
    <div class="modal-dialog">
      <div class="modal-content" style="margin-top: 83px;">

        <div id="ModalEmbarques"></div>

      </div>
    </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>

</html>