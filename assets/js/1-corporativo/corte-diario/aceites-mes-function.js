
function ReporteAceites(year, mes) {
    $('#DivReporteAceites').html('<div class="text-center mt-5 pt-5"><img class="mt-5 pt-5" width="50px" src="../../imgs/iconos/load-img.gif"></div>');
    $('#DivReporteAceites').load('../../app/vistas/personal-general/1-corporativo/corte-diario/aceites/reporte-aceites-mes.php?year=' + year + '&mes=' + mes);
    //$('#DivReporteAceites').load('../../public/corte-diario/vistas/reporte-aceites-mes.php?year=' + year + '&mes=' + mes);
  }

  function InventarioInicial(idaceite) {

    var bodega = $("#bodega-" + idaceite).val();
    var exibidor = $("#exibidor-" + idaceite).val();

    total = parseInt(bodega) + parseInt(exibidor);


    $("#inventarioi-" + idaceite).text(number_format(total, 2));

  }

  function number_format(amount, decimals) {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0)
      return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
      regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
      amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
  }

  function InventarioFinal(idaceite) {

    var inventarioi = $("#inventarioi-" + idaceite).text();
    var pedido = 0;
    var ventas = $("#ventas-" + idaceite).text();

    if ($("#pedido-" + idaceite).val() == "") {
      pedido = 0;
    } else {
      pedido = $("#pedido-" + idaceite).val();
    }

    total = parseInt(inventarioi) + parseInt(pedido) - parseInt(ventas);
    $("#inventariof-" + idaceite).text(number_format(total, 2));

  }

  function factotal(idaceite) {

    var mostrador = $("#mostrador-" + idaceite).val();
    var facturado = $("#facturado-" + idaceite).val();

    total = parseInt(mostrador) + parseInt(facturado);


    $("#factotal-" + idaceite).text(number_format(total, 2));
  }

  function diffactura(idaceite) {

    var factotal = $("#factotal-" + idaceite).text();
    var ventas = $("#ventas-" + idaceite).val();

    total = parseInt(factotal) - parseInt(ventas);


    $("#diffactura-" + idaceite).text(number_format(total, 2));
  }

  function ModalDiferencia(idaceite, year, mes) {

    $('#ModalPrincipal').modal('show');
    $('#DivModal').load('../../app/vistas/personal-general/1-corporativo/corte-diario/aceites/modal-pago-aceite.php?idaceite=' + idaceite + '&year=' + year + '&mes=' + mes);
    //$('#DivModal').load('../../public/corte-diario/vistas/modal-pago-aceite.php?idaceite=' + idaceite + '&year=' + year + '&mes=' + mes);
  }

  function PagarDiferencia(idaceite, year, mes,idEstacion) {

    var Documento = $('#Documento').val();
    var Comentario = $('#Comentario').val();

    var data = new FormData();
    var url =  '../../app/controlador/1-corporativo/controladorCorteDiario.php';
    //var url = '../../public/corte-diario/modelo/agregar-pago-diferencia.php';

    Documento = document.getElementById("Documento");
    Documento_file = Documento.files[0];
    Documento_filePath = Documento.value;
    var ext = Documento_filePath.split('.').reverse()[0]


    if (Documento_filePath != "") {
      $('#Documento').css('border', '');
      if (ext == "pdf") {
        $('#Documento').css('border', '');
        data.append('accion','agregar-pago-diferencia');
        data.append('idaceite', idaceite);
        data.append('year', year);
        data.append('mes', mes);
        data.append('Documento_file', Documento_file);
        data.append('Comentario', Comentario);
        data.append('idEstacion',idEstacion);

        $.ajax({
          url: url,
          type: 'POST',
          contentType: false,
          data: data,
          processData: false,
          cache: false
        }).done(function (data) {
          console.log(data);
          ReporteAceites(year, mes);
          $('#ModalPrincipal').modal('hide');
        });

      } else {
        $('#Documento').css('border', '2px solid #A52525');
      }
    } else {
      $('#Documento').css('border', '2px solid #A52525');
    }

  }

  function ModalDetalle(idaceite) {
    $('#ModalPrincipal').modal('show');
    $('#DivModal').load('../../app/vistas/personal-general/1-corporativo/corte-diario/aceites/modal-detalle-pago-aceite.php?idaceite=' + idaceite);
    //$('#DivModal').load('../../public/corte-diario/vistas/modal-detalle-pago-aceite.php?idaceite=' + idaceite);
  }

  function GuardarFinalizar(IdReporte, idEstacion, nombreEstacion) {

    var parametros = {
      "IdReporte": IdReporte,
      "idEstacion": idEstacion,
      "nombreEstacion": nombreEstacion,
      "accion": "finalizar-aceites"
    };

    $.ajax({
      data: parametros,
      url: '../../app/controlador/1-corporativo/controladorCorteDiario.php',
      //url:   '../../public/corte-diario/modelo/finalizar-aceites.php',
      type: 'post',
      beforeSend: function () {
        $(".LoaderPage").show();
      },
      complete: function () {

      },
      success: function (response) {

        $(".LoaderPage").hide();
        $('#ModalPrincipal').modal('show');
        $('#DivModal').load('../../app/vistas/personal-general/1-corporativo/corte-diario/aceites/modal-info-diferencias.php');
        //$('#DivModal').load('../../public/corte-diario/vistas/modal-info-diferencias.php');


      }
    });
  }

  function Finalizar() {
    location.reload();
  }

  //----------------------------------------------------------------------

  function ListaModal(IdReporte, year, mes) {
    $('#Modal').modal('show');
    $('#ListaDocumento').load('../../app/vistas/personal-general/1-corporativo/corte-diario/aceites/lista-aceites-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
    //$('#ListaDocumento').load('../../public/corte-diario/vistas/lista-aceites-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
  }

  function Nuevo(IdReporte, year, mes) {
    $('#ListaDocumento').load('../../app/vistas/personal-general/1-corporativo/corte-diario/aceites/formulario-aceites-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
    //$('#ListaDocumento').load('../../public/corte-diario/vistas/formulario-aceites-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
  }

  function Cancelar(IdReporte, year, mes) {
    $('#ListaDocumento').load('../../app/vistas/personal-general/1-corporativo/corte-diario/aceites/lista-aceites-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
    //$('#ListaDocumento').load('../../public/corte-diario/vistas/lista-aceites-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
  }

  function Guardar(IdReporte, year, mes) {

    var data = new FormData();
    var url = '../../app/controlador/1-corporativo/controladorCorteDiario.php';
    //var url = '../../public/corte-diario/modelo/agregar-documento-aceite.php';

    Ficha = document.getElementById("Ficha");
    Ficha_file = Ficha.files[0];
    Ficha_filePath = Ficha.value;

    Imagen = document.getElementById("Imagen");
    Imagen_file = Imagen.files[0];
    Imagen_filePath = Imagen.value;

    Factura = document.getElementById("Factura");
    Factura_file = Factura.files[0];
    Factura_filePath = Factura.value;

    data.append('idReporte', IdReporte);
    data.append('year', year);
    data.append('mes', mes);
    data.append('Ficha_file', Ficha_file);
    data.append('Imagen_file', Imagen_file);
    data.append('Factura_file', Factura_file);
    data.append('accion', 'agregar-documento-aceite');

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

    });


  }

  function Eliminar(IdReporte, year, mes, id) {

    var parametros = {
      "IdReporte": IdReporte,
      "id": id,
      "accion": "eliminar-documento-aceite"
    };

    $.ajax({
      data: parametros,
      url: '../../app/controlador/1-corporativo/controladorCorteDiario.php',
      //url:   '../../public/corte-diario/modelo/eliminar-documento-aceite.php',
      type: 'post',
      beforeSend: function () {
        $(".LoaderPage").show();
      },
      complete: function () {

      },
      success: function (response) {
        if (response == 1) {

          $(".LoaderPage").hide();
          alertify.success('Registro eliminado exitosamente.')
          Cancelar(IdReporte, year, mes);

        } else {
          alertify.error('Error al eliminar')
          $(".LoaderPage").hide();

        }

      }
    });

  }

  function Editar(IdReporte, year, mes, id) {
    $('#ListaDocumento').load('../../app/vistas/personal-general/1-corporativo/corte-diario/aceites/editar-aceite-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes + '&id=' + id);
    //$('#ListaDocumento').load('../../public/corte-diario/vistas/editar-aceite-documento.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes + '&id=' + id);
  }

  function EditarInfo(IdReporte, year, mes, id) {

    var data = new FormData();
    var url = '../../app/controlador/1-corporativo/controladorCorteDiario.php';
    //var url = '../../public/corte-diario/modelo/editar-documento-aceite.php';

    Ficha = document.getElementById("Ficha");
    Ficha_file = Ficha.files[0];
    Ficha_filePath = Ficha.value;

    Imagen = document.getElementById("Imagen");
    Imagen_file = Imagen.files[0];
    Imagen_filePath = Imagen.value;

    Factura = document.getElementById("Factura");
    Factura_file = Factura.files[0];
    Factura_filePath = Factura.value;

    data.append('id', id);
    data.append('year', year);
    data.append('mes', mes);
    data.append('Ficha_file', Ficha_file);
    data.append('Imagen_file', Imagen_file);
    data.append('Factura_file', Factura_file);
    data.append('accion', 'editar-documento-aceite');

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

    });


  }


  function DocumentacionAceites(IdReporte, year, mes) {
    $('#Modal').modal('show');
    $('#ListaDocumento').load('../../app/vistas/personal-general/1-corporativo/corte-diario/aceites/lista-aceites-facturas.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
    //$('#ListaDocumento').load('../../public/admin/vistas/lista-aceites-facturas.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
  }

  function GuardarFactura(IdReporte, year, mes) {

    var fechaAceite = $('#fechaAceite').val();
    var conceptoAceite = $('#conceptoAceite').val();
    var facturaAceite = $('#facturaAceite').val();

    var data = new FormData();
    var url = '../../app/controlador/1-corporativo/controladorCorteDiario.php';
    //var url = '../../public/admin/modelo/agregar-factura-archivo-aceite.php';

    Factura = document.getElementById("facturaAceite");
    Factura_file = Factura.files[0];
    Factura_filePath = Factura.value;


    if (fechaAceite != "") {
      $('#fechaAceite').css('border', '');

      if (conceptoAceite != "") {
        $('#conceptoAceite').css('border', '');

        if (facturaAceite != "") {
          $('#facturaAceite').css('border', '');

          data.append('IdReporte', IdReporte);
          data.append('year', year);
          data.append('mes', mes);
          data.append('fechaAceite', fechaAceite);
          data.append('conceptoAceite', conceptoAceite);
          data.append('Factura_file', Factura_file);
          data.append('accion', 'agregar-factura-archivo-aceite');

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
            $('#ListaDocumento').load('../../app/vistas/personal-general/1-corporativo/corte-diario/aceites/lista-aceites-facturas.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
            //$('#ListaDocumento').load('../../public/admin/vistas/lista-aceites-facturas.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
            alertify.success('Archivo agregado exitosamente')

          });


        } else {
          $('#facturaAceite').css('border', '2px solid #A52525');
        }

      } else {
        $('#conceptoAceite').css('border', '2px solid #A52525');
      }

    } else {
      $('#fechaAceite').css('border', '2px solid #A52525');
    }

  }

  function EliminarFacturaAceite(IdReporte, year, mes, id) {


    var parametros = {
      "IdReporte": IdReporte,
      "id": id,
      "accion": "eliminar-factura-archivo-aceite"
    };


    alertify.confirm('',
      function () {

        $.ajax({
          data: parametros,
          url: '../../app/controlador/1-corporativo/controladorCorteDiario.php',
          //url:   '../../public/admin/modelo/eliminar-factura-archivo-aceite.php',
          type: 'post',
          beforeSend: function () {
            $(".LoaderPage").show();
          },
          complete: function () {

          },
          success: function (response) {
            if (response == 1) {

              $(".LoaderPage").hide();
              $('#ListaDocumento').load('../../app/vistas/personal-general/1-corporativo/corte-diario/aceites/lista-aceites-facturas.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
              //$('#ListaDocumento').load('../../public/admin/vistas/lista-aceites-facturas.php?IdReporte=' + IdReporte + '&year=' + year + '&mes=' + mes);
              alertify.success('Archivo agregado exitosamente');

            } else {
              alertify.error('Error al eliminar')
              $(".LoaderPage").hide();
            }
          }
        });
      },
      function () {
      }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar el registro seleccionado?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();
  }