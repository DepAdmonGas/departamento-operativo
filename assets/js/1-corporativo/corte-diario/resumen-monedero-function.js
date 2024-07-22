function ListaMonedero(year, mes) {
  $('#Monedero').load('../../app/vistas/personal-general/1-corporativo/corte-diario/monedero/lista-resumen-monedero.php?year=' + year + '&mes=' + mes);
    //$('#Monedero').load('../../public/corte-diario/vistas/lista-resumen-monedero.php?year=' + year + '&mes=' + mes);
  }

  function ListaModal(IdReporte) {
    $('#Modal').modal('show');
    $('#ListaDocumento').load('../../app/vistas/personal-general/1-corporativo/corte-diario/monedero/lista-monedero-documento.php?IdReporte=' + IdReporte);
    //$('#ListaDocumento').load('../../public/corte-diario/vistas/lista-monedero-documento.php?IdReporte=' + IdReporte);
  }

  function Editar(IdReporte, id) {
    $('#ListaDocumento').load('../../app/vistas/personal-general/1-corporativo/corte-diario/monedero/editar-monedero-documento.php?IdReporte=' + IdReporte + '&id=' + id);
    //$('#ListaDocumento').load('../../public/corte-diario/vistas/editar-monedero-documento.php?IdReporte=' + IdReporte + '&id=' + id);
  }

  function Cancelar(IdReporte) {
    $('#ListaDocumento').load('../../app/vistas/personal-general/1-corporativo/corte-diario/monedero/lista-monedero-documento.php?IdReporte=' + IdReporte);
    //$('#ListaDocumento').load('../../public/corte-diario/vistas/lista-monedero-documento.php?IdReporte=' + IdReporte);
  }

  function EditarInfo(IdReporte, id) {

    var Fecha = $('#Fecha').val();
    var Cilote = $('#Cilote').val();
    var Diferencia = $('#Diferencia').val();

    var data = new FormData();
    var url = '../../app/controlador/1-corporativo/controladorCorteDiario.php/';
    //var url = '../../public/corte-diario/modelo/editar-documento-monedero.php';

    PDF = document.getElementById("PDF");
    PDF_file = PDF.files[0];
    PDF_filePath = PDF.value;

    XML = document.getElementById("XML");
    XML_file = XML.files[0];
    XML_filePath = XML.value;

    EXCEL = document.getElementById("EXCEL");
    EXCEL_file = EXCEL.files[0];
    EXCEL_filePath = EXCEL.value;


    data.append('id', id);
    data.append('Fecha', Fecha);
    data.append('Cilote', Cilote);
    data.append('Diferencia', Diferencia);
    data.append('XML_file', XML_file);
    data.append('PDF_file', PDF_file);
    data.append('EXCEL_file', EXCEL_file);
    data.append('accion', 'editar-documento-monedero');

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
      Cancelar(IdReporte);

    });

  }

  function Edi(IdReporte, id) {
    $('#ListaDocumento').load('../../app/vistas/personal-general/1-corporativo/corte-diario/monedero/editar-monedero-documento-edi.php?IdReporte=' + IdReporte + '&id=' + id);
    //$('#ListaDocumento').load('../../public/corte-diario/vistas/editar-monedero-documento-edi.php?IdReporte=' + IdReporte + '&id=' + id);
  }

  function GuardarC(IdReporte, id) {

    var Complemento = $('#Complemento').val();

    if (Complemento != "") {
    $('#Complemento').css('border', '');

    var data = new FormData();
    data.append("accion", "guardar-documento-edi");
    var url = '../../app/controlador/1-corporativo/controladorCorteDiario.php';
    //var url = '../../public/corte-diario/modelo/agregar-documento-monedero-edi.php';

    PDF = document.getElementById("PDF");
    PDF_file = PDF.files[0];
    PDF_filePath = PDF.value;

    XML = document.getElementById("XML");
    XML_file = XML.files[0];
    XML_filePath = XML.value;

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
      Edi(IdReporte, id);
    });

  } else {
    $('#Complemento').css('border', '2px solid #A52525');
  }

  }

  function EliminarEdi(IdReporte, iddoc, id) {

    var parametros = {
      "id": id,
      "accion":"eliminar-documento-monedero-edi"
    };

    $.ajax({
      data: parametros,
      url: '../../app/controlador/1-corporativo/controladorCorteDiario.php',
      //url: '../../public/corte-diario/modelo/eliminar-documento-monedero-edi.php',
      type: 'post',
      beforeSend: function () {
        $(".LoaderPage").show();
      },
      complete: function () {

      },
      success: function (response) {

        if (response == 1) {

          $(".LoaderPage").hide();

          Edi(IdReporte, iddoc);

        } else {
          alertify.error('Error al eliminar')
          $(".LoaderPage").hide();

        }

      }
    });

  }