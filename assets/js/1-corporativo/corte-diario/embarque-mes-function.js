function ListaEmbarques(IdReporte) {
  $('#DivEmbarques').load('../../app/vistas/personal-general/1-corporativo/corte-diario/lista-embarques-mes.php?IdReporte=' + IdReporte);  
  //$('#DivEmbarques').load('../../public/corte-diario/vistas/lista-embarques-mes.php?IdReporte=' + IdReporte);
  }
  function Mas(IdReporte) {
    $('#Modal').modal('show');
    $('#ModalEmbarques').load('../../app/vistas/personal-general/1-corporativo/corte-diario/modal-embarques-mes.php?IdReporte=' + IdReporte);
    //$('#ModalEmbarques').load('../../public/corte-diario/vistas/modal-embarques-mes.php?IdReporte=' + IdReporte);
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
    var url = '../../app/controlador/1-corporativo/controladorCorteDiario.php';
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
  
  function Editar(idReporte, id, idestacion) {
    $('#Modal').modal('show');
    $('#ModalEmbarques').load('../../app/vistas/personal-general/1-corporativo/corte-diario/modal-editar-embarques-mes.php?idReporte=' + idReporte + '&id=' + id + '&idestacion=' + idestacion);
    //$('#ModalEmbarques').load('../../public/corte-diario/vistas/modal-editar-embarques-mes.php?idReporte=' + idReporte + '&id=' + id + '&idestacion=' + idestacion);
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
    var url = '../../app/controlador/1-corporativo/controladorCorteDiario.php';
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
    $('#ModalEmbarques').load('../../app/vistas/personal-general/1-corporativo/corte-diario/modal-comentarios-embarques.php?idReporte=' + idReporte + '&id=' + id + '&idestacion=' + idestacion);
    //$('#ModalEmbarques').load('../../public/corte-diario/vistas/modal-comentarios-embarques.php?idReporte=' + idReporte + '&id=' + id + '&idestacion=' + idestacion);
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
        url: '../../app/controlador/1-corporativo/controladorCorteDiario.php',
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
            $('#ModalEmbarques').load('../../app/vistas/personal-general/1-corporativo/corte-diario/modal-comentarios-embarques.php?idReporte=' + idReporte + '&id=' + id + '&idestacion=' + idestacion);
            //$('#ModalEmbarques').load('../../public/corte-diario/vistas/modal-comentarios-embarques.php?idReporte=' + idReporte + '&id=' + id + '&idestacion=' + idestacion);
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
      url: '../../app/controlador/1-corporativo/controladorCorteDiario.php',
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