
function ListaConsumoPago(idReporte) {
    $('#ConsumosPagos').load('../../../public/corte-diario/vistas/lista-consumo-pagos.php?idReporte=' + idReporte);
  }

  function ClientesLista(year, mes, idDias) {
    window.location.href = "../../../clientes-lista/" + year + "/" + mes + "/" + idDias;
  }

  function Agregar() {
    $('#Modal').modal('show');
  }

  function Guardar(idReporte) {

    var agregar = 0;
    var data = new FormData();
    data.append('accion', 'agregar-pagos-cliente');
    var url = '../../../app/controlador/1-corporativo/controladorCorteDiario.php';
    //var url = '../../../public/corte-diario/modelo/agregar-pagos.php';

    var Cliente = $('#Cliente').val();
    var Total = $('#Total').val();
    var Tipo = $('#Tipo').val();
    var FormaPago = $('#FormaPago').val();

    Comprobante = document.getElementById("Comprobante");
    Comprobante_file = Comprobante.files[0];
    Comprobante_filePath = Comprobante.value;

    if (Cliente != "") {
      $('#BorderCliente').css('border', '');
      if (Total != "") {
        $('#Total').css('border', '');
        if (Tipo != "") {
          $('#Tipo').css('border', '');

          if (Tipo == "Consumo") {
            AgregarConsumo(idReporte);
          } else if (Tipo == "Pago") {

            if (FormaPago != "") {
              $('#FormaPago').css('border', '');

              if (FormaPago == "Tarjeta") {

                if (Comprobante_filePath != "") {
                  $('#Comprobante').css('border', '');

                  data.append('idReporte', idReporte);
                  data.append('Cliente', Cliente);
                  data.append('Tipo', Tipo);
                  data.append('Total', Total);
                  data.append('FormaPago', FormaPago);
                  data.append('Comprobante_file', Comprobante_file);
                  agregar = 1;

                } else {
                  agregar = 0;
                  $('#Comprobante').css('border', '2px solid #A52525');
                }

              } else if (FormaPago == "Transferencia") {

                data.append('idReporte', idReporte);
                data.append('Cliente', Cliente);
                data.append('Tipo', Tipo);
                data.append('Total', Total);
                data.append('FormaPago', FormaPago);
                data.append('Comprobante_file', Comprobante_file);
                agregar = 1;



              } else {

                data.append('idReporte', idReporte);
                data.append('Cliente', Cliente);
                data.append('Tipo', Tipo);
                data.append('Total', Total);
                data.append('FormaPago', FormaPago);
                data.append('Comprobante_file', '');
                agregar = 1

              }


              if (agregar == 1) {

                $.ajax({
                  url: url,
                  type: 'POST',
                  contentType: false,
                  data: data,
                  processData: false,
                  cache: false
                }).done(function (data) {
                  if (data == 1) {

                    $('#Modal').modal('hide');

                    var $select = $('#Cliente').selectize();
                    var control = $select[0].selectize;
                    //control.reload();

                    $('#Total').val('');
                    $('#Tipo').val('');
                    $('#FormaPago').val('');
                    $('#Cliente').val('');

                    document.getElementById("DivFPago").style.display = "none";

                    ListaConsumoPago(idReporte);
                    alertify.success('Registro agregado exitosamente.')

                  } else {
                    alertify.error('Error al agregar')
                  }

                });

              }



            } else {
              $('#FormaPago').css('border', '2px solid #A52525');
            }

          }

        } else {
          $('#Tipo').css('border', '2px solid #A52525');
        }
      } else {
        $('#Total').css('border', '2px solid #A52525');
      }
    } else {
      $('#BorderCliente').css('border', '2px solid #A52525');
    }

  }

  function AgregarConsumo(idReporte) {

    var Cliente = $('#Cliente').val();
    var Total = $('#Total').val();
    var Tipo = $('#Tipo').val();

    var parametros = {
      "idReporte": idReporte,
      "Cliente": Cliente,
      "Total": Total,
      "Tipo": Tipo,
      "accion": "agregar-consumos-cliente"
    };

    $.ajax({
      data: parametros,
      url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
      //url:   '../../../public/corte-diario/modelo/agregar-consumos.php',
      type: 'post',
      beforeSend: function () {
      },
      complete: function () {

      },
      success: function (response) {
        if (response == 1) {
          $('#Modal').modal('hide');

          var $select = $('#Cliente').selectize();
          var control = $select[0].selectize;
          control.clear();

          $('#Total').val('');
          $('#Tipo').val('');
          $('#FormaPago').val('');

          document.getElementById("DivFPago").style.display = "none";


          ListaConsumoPago(idReporte);
          alertify.success('Registro agregado exitosamente.')

        } else {
          alertify.error('Error al agregar')
        }

      }
    });

  }
  //------------------------------------------------------------

  function Eliminar(idReporte, id) {

    var parametros = {
      "idReporte": idReporte,
      "id": id,
      "accion": "eliminar-consumo-pago"
    };

    $.ajax({
      data: parametros,
      url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
      //url:   '../../../public/corte-diario/modelo/eliminar-consumos-pagos.php',
      type: 'post',
      beforeSend: function () { },
      complete: function () { },
      success: function (response) {

        if (response == 1) {


          ListaConsumoPago(idReporte);
          alertify.success('Registro eliminado exitosamente.')

        } else {
          alertify.error('Error al eliminar')
        }

      }
    });

  }

  function VerTipoPago(val) {

    var ConsumoPago = val.value;

    if (ConsumoPago == "Pago" || ConsumoPago == "Transferencia") {
      document.getElementById("DivFPago").style.display = "block";
    } else {
      document.getElementById("DivFPago").style.display = "none";
    }

  }

  function ValPago(val) {

    var TipoPago = val.value;

    if (TipoPago == "Tarjeta" || TipoPago == "Transferencia") {
      document.getElementById("DivComprobante").style.display = "block";
    } else {
      document.getElementById("DivComprobante").style.display = "none";
    }

  }