<?php
require 'app/vistas/contenido/header.php';
$ventas = $corteDiarioGeneral->getEstado($GET_idReporte);
?>
  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");

      VentasOtros(<?= $GET_idReporte; ?>, <?= $Session_IDEstacion; ?>);

      ProsegurAgregar(<?= $GET_idReporte; ?>);
      TarjetasBancariasAgregar(<?= $GET_idReporte; ?>, <?= $Session_IDEstacion; ?>);
      ClientesControlgasAgregar(<?= $GET_idReporte; ?>);
      PagoClientesAgregar(<?= $GET_idReporte; ?>);

      Total1234(<?= $GET_idReporte; ?>);
      DiferenciaTotal(<?= $GET_idReporte; ?>);
      DifPagoCliente(<?= $GET_idReporte; ?>);

      Aceites(<?= $GET_year; ?>, <?= $GET_mes; ?>, <?= $GET_idReporte; ?>, <?= $Session_IDEstacion; ?>);
      ListaDocumentos(<?= $GET_idReporte; ?>)

    });

    function Regresar() {
      window.history.back();
    }

    function Ventas(idReporte) {
      $('#DivConecntradoVentas').html('<div class="text-center"><img width="30px" src="../../../imgs/iconos/load-img.gif"></div>');

      $('#DivConecntradoVentas').load('../../../public/corte-diario/vistas/concentrado-ventas.php?idReporte=' + idReporte);
    }

    function VentasOtros(idReporte, idEstacion) {


      var parametros = {
        "idReporte": idReporte,
        "sessionIdEstacion": idEstacion,
        "accion": "nuevo-concentrado-ventas-otros"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/nuevo-concentrado-ventas-otros.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {
          Ventas(idReporte);
        },
        success: function (response) {
        }
      });

    }

    /*---------------------------------------------------------------------------*/

    function ProsegurAgregar(idReporte) {
      var parametros = {
        "idReporte": idReporte,
        "accion": "nuevo-registro-prosegur"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/nuevo-registro-prosegur.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {
          Prosegur(idReporte);
        },
        success: function (response) {

        }
      });
    }

    function Prosegur(idReporte) {
      $('#DivProsegur').html('<div class="text-center"><img width="30px" src="../../../imgs/iconos/load-img.gif"></div>');
      $('#DivProsegur').load('../../../public/corte-diario/vistas/prosegur.php?idReporte=' + idReporte);
    }


    function EditPRecibo(e, idReporte, idProsegur) {


      e.value = e.value.toUpperCase();
      var recibo = e.value;

      var parametros = {
        "type": "recibo",
        "idProsegur": idProsegur,
        "recibo": recibo,
        "accion": "editar-prosegur"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/editar-prosegur.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 0) {
            Prosegur(idReporte);
          } else {
          }

        }
      });


    }

    function EditPImporte(val, idReporte, idProsegur) {


      var importe = val.value;

      var parametros = {
        "type": "importe",
        "idProsegur": idProsegur,
        "importe": importe,
        "accion": "editar-prosegur"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/editar-prosegur.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 0) {
            Prosegur(idReporte);
          } else {
            ProsegurTotal(idReporte);
            Total1234(idReporte);
          }

        }
      });


    }

    /*------------------------------------------------------------------------*/

    function TarjetasBancariasAgregar(idReporte, idEstacion) {
      var parametros = {
        "idReporte": idReporte,
        "sessionEstacion": idEstacion,
        "accion": "registro-tarjetas-bancarias"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/nuevo-registro-tarjetas-bancarias.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {
          TarjetasBancarias(idReporte);
        },
        success: function (response) {
        }
      });
    }

    function TarjetasBancarias(idReporte) {
      $('#DivTarjetasBancarias').html('<div class="text-center"><img width="30px" src="../../../imgs/iconos/load-img.gif"></div>');
      $('#DivTarjetasBancarias').load('../../../public/corte-diario/vistas/tarjetas-bancarias.php?idReporte=' + idReporte);
    }

    function EditTBaucher(val, idReporte, idTarjeta) {


      VentasOtros(<?= $GET_idReporte; ?>, <?= $Session_IDEstacion; ?>);

      ProsegurAgregar(<?= $GET_idReporte; ?>);
      TarjetasBancariasAgregar(<?= $GET_idReporte; ?>, <?= $Session_IDEstacion; ?>);
      ClientesControlgasAgregar(<?= $GET_idReporte; ?>);
      PagoClientesAgregar(<?= $GET_idReporte; ?>);

      Total1234(<?= $GET_idReporte; ?>);
      DiferenciaTotal(<?= $GET_idReporte; ?>);
      DifPagoCliente(<?= $GET_idReporte; ?>);

      Aceites(<?= $GET_year; ?>, <?= $GET_mes; ?>, <?= $GET_idReporte; ?>, <?= $Session_IDEstacion; ?>);
      ListaDocumentos(<?= $GET_idReporte; ?>);
    };
    function Ventas(idReporte) {
      $('#DivConecntradoVentas').html('<div class="text-center"><img width="30px" src="../../../imgs/iconos/load-img.gif"></div>');

      $('#DivConecntradoVentas').load('../../../public/corte-diario/vistas/concentrado-ventas.php?idReporte=' + idReporte);
    }
    function VentasOtros(idReporte, idEstacion) {


      var parametros = {
        "idReporte": idReporte,
        "sessionIdEstacion": idEstacion,
        "accion": "nuevo-concentrado-ventas-otros"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/nuevo-concentrado-ventas-otros.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {
          Ventas(idReporte);
        },
        success: function (response) {
        }
      });

    }

    /*---------------------------------------------------------------------------*/

    function ProsegurAgregar(idReporte) {
      var parametros = {
        "idReporte": idReporte,
        "accion": "nuevo-registro-prosegur"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/nuevo-registro-prosegur.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {
          Prosegur(idReporte);
        },
        success: function (response) {

        }
      });
    }

    function Prosegur(idReporte) {
      $('#DivProsegur').html('<div class="text-center"><img width="30px" src="../../../imgs/iconos/load-img.gif"></div>');
      $('#DivProsegur').load('../../../public/corte-diario/vistas/prosegur.php?idReporte=' + idReporte);
    }


    function EditPRecibo(e, idReporte, idProsegur) {


      e.value = e.value.toUpperCase();
      var recibo = e.value;

      var parametros = {
        "type": "recibo",
        "idProsegur": idProsegur,
        "recibo": recibo,
        "accion": "editar-prosegur"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/editar-prosegur.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 0) {
            Prosegur(idReporte);
          } else {
          }

        }
      });


    }

    function EditPImporte(val, idReporte, idProsegur) {


      var importe = val.value;

      var parametros = {
        "type": "importe",
        "idProsegur": idProsegur,
        "importe": importe,
        "accion": "editar-prosegur"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/editar-prosegur.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 0) {
            Prosegur(idReporte);
          } else {
            ProsegurTotal(idReporte);
            Total1234(idReporte);
          }

        }
      });


    }

    /*------------------------------------------------------------------------*/

    function TarjetasBancariasAgregar(idReporte, idEstacion) {
      var parametros = {
        "idReporte": idReporte,
        "sessionEstacion": idEstacion,
        "accion": "registro-tarjetas-bancarias"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/nuevo-registro-tarjetas-bancarias.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {
          TarjetasBancarias(idReporte);
        },
        success: function (response) {
        }
      });
    }

    function TarjetasBancarias(idReporte) {
      $('#DivTarjetasBancarias').html('<div class="text-center"><img width="30px" src="../../../imgs/iconos/load-img.gif"></div>');
      $('#DivTarjetasBancarias').load('../../../public/corte-diario/vistas/tarjetas-bancarias.php?idReporte=' + idReporte);
    }

    function EditTBaucher(val, idReporte, idTarjeta) {

      var baucher = val.value;

      var parametros = {
        "idTarjeta": idTarjeta,
        "baucher": baucher,
        "accion": "editar-tarjetas-CB"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/editar-tarjetas-c-b.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () { },
        success: function (response) {
          if (response == 0) {
            TarjetasBancarias(idReporte);
          } else {
            TarjetasTotal(idReporte);
            Total1234(idReporte);
          }
        }
      });

    }

    function formatAsMoney(n) {
      n = (Number(n).toFixed(2) + '').split('.');
      return n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '.' + (n[1] || '00');
    }

    //-------------------------------------------------------------------------

    function ClientesControlgasAgregar(idReporte) {
      var parametros = {
        "idReporte": idReporte,
        "accion": "nuevo-registro-controlgas"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/nuevo-registro-controlgas.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {
          ClientesControlgas(idReporte)
        },
        success: function (response) {
        }
      });
    }

    function ClientesControlgas(idReporte) {
      $('#DivControlgas').html('<div class="text-center"><img width="30px" src="../../../imgs/iconos/load-img.gif"></div>');
      $('#DivControlgas').load('../../../public/corte-diario/vistas/clientes-controlgas.php?idReporte=' + idReporte);
    }

    function EditCGPago(val, idReporte, idControl) {
      var pago = val.value;

      var parametros = {
        "type": "pago",
        "idControl": idControl,
        "pago": pago,
        "accion": "editar-controlgas"

      }

      function formatAsMoney(n) {
        n = (Number(n).toFixed(2) + '').split('.');
        return n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '.' + (n[1] || '00');
      }

      //-------------------------------------------------------------------------

      function ClientesControlgasAgregar(idReporte) {
        var parametros = {
          "idReporte": idReporte,
          "accion": "nuevo-registro-controlgas"

        };

        $.ajax({
          data: parametros,
          url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',

          //url:   '../../../public/corte-diario/modelo/nuevo-registro-controlgas.php',

          type: 'post',
          beforeSend: function () {
          },
          complete: function () {


          },
          success: function (response) {

            if (response == 0) {
              ClientesControlgas(idReporte);
            } else {
              ControlGTotal(idReporte);
              DifPagoCliente(idReporte);
            }

          }
        });
      }

      function EditCGConsumo(val, idReporte, idControl) {
        var consumo = val.value;

        var parametros = {
          "type": "consumo",
          "idControl": idControl,
          "consumo": consumo,
          "accion": "editar-controlgas"
        }
        $.ajax({
          data: parametros,
          url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
          //url:   '../../../public/corte-diario/modelo/editar-controlgas.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

            if (response == 0) {
              ClientesControlgas(idReporte);
            } else {
              ControlGTotal(idReporte);
              Total1234(idReporte);

            }

          }
        });
      }

      function ClientesControlgas(idReporte) {
        $('#DivControlgas').html('<div class="text-center"><img width="30px" src="../../../imgs/iconos/load-img.gif"></div>');
        $('#DivControlgas').load('../../../public/corte-diario/vistas/clientes-controlgas.php?idReporte=' + idReporte);
      }

      function EditCGPago(val, idReporte, idControl) {
        var pago = val.value;

        var parametros = {
          "type": "pago",
          "idControl": idControl,
          "pago": pago,
          "accion": "editar-controlgas"
        };

        $.ajax({
          data: parametros,
          url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
          //url:   '../../../public/corte-diario/modelo/editar-controlgas.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

            if (response == 0) {
              ClientesControlgas(idReporte);
            } else {
              ControlGTotal(idReporte);

              Total1234(idReporte);

            }

          }
        });
      }
      DifPagoCliente(idReporte);
    }
    function EditCGConsumo(val, idReporte, idControl) {
      var consumo = val.value;

      var parametros = {
        "type": "consumo",
        "idControl": idControl,
        "consumo": consumo,
        "accion": "editar-controlgas"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/editar-controlgas.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 0) {
            ClientesControlgas(idReporte);
          } else {
            ControlGTotal(idReporte);
            Total1234(idReporte);

          }

        }
      });
    }


    //------------------------------------------------------------------------

    function PagoClientesAgregar(idReporte) {
      var parametros = {
        "idReporte": idReporte,
        "accion": "nuevo-registro-pago-clientes"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/nuevo-registro-pagoclientes.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {
          PagoCliente(idReporte)
        },
        success: function (response) {

        }
      });
    }
    function PagoCliente(idReporte) {
      $('#DivPagoClientes').html('<div class="text-center"><img width="30px" src="../../../imgs/iconos/load-img.gif"></div>');
      $('#DivPagoClientes').load('../../../public/corte-diario/vistas/pago-clientes.php?idReporte=' + idReporte);
    }


    function EditPCimporte(val, idReporte, idPagoCliente) {
      var importe = val.value;

      var parametros = {
        "type": "importe",
        "idPagoCliente": idPagoCliente,
        "importe": importe,
        "accion": "editar-pago-clientes"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/editar-pagoclientes.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 0) {
            PagoCliente(idReporte);
          } else {
            PagoCTotal(idReporte);
            DifPagoCliente(idReporte);
          }

        }
      });
    }

    function EditPCnota(e, idReporte, idPagoCliente) {

      e.value = e.value.toUpperCase();
      var nota = e.value;

      var parametros = {
        "type": "nota",
        "idPagoCliente": idPagoCliente,
        "nota": nota,
        "accion": "editar-pago-clientes"
      };

      $.ajax({
        data: parametros,
        //url:   '../../../public/corte-diario/modelo/editar-pagoclientes.php',
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 0) {
            PagoCliente(idReporte);
          } else {
            PagoCTotal(idReporte);
          }

        }
      });
    }

    //----------------------------------------------------------------------------
    function NewVentas(idReporte) {

      var parametros = {
        "accion": "nuevo-registro-venta",
        "idReporte": idReporte
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:'../../../public/corte-diario/modelo/nuevo-registro-ventas.php',
        type: 'POST',
        beforeSend: function () {
        },
        complete: function () {
          Ventas(idReporte);
        },
        success: function (response) {
        }
      });
    }
    //------------------------------------------------------
    function EditProducto(val, idReporte, idVentas) {

      var producto = val.value;

      if (producto != "") {

        var parametros = {
          "type": "producto",
          "idVentas": idVentas,
          "producto": producto,
          "accion": "editar-ventas"
        };

        $.ajax({
          data: parametros,
          url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
          //url:   '../../../public/corte-diario/modelo/editar-ventas.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {
          },
          success: function (response) {
            if (!response) {
              Ventas(idReporte);
            } else {
              VentasSubTotales(idReporte);
              VentasTotales(idReporte);
            }

          }
        });

      } else {
        $("#producto-" + idVentas).css({ 'border': '2px solid #CF2500' });
      }

    }

    function EditLitros(val, idReporte, idVentas) {

      var litros = val.value;

      var parametros = {
        "type": "litros",
        "idVentas": idVentas,
        "litros": litros,
        "accion": "editar-ventas"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/editar-ventas.php',
        type: 'POST',
        beforeSend: function () {
        },
        complete: function () {
        },
        success: function (response) {
          if (!response) {
            Ventas(idReporte);
          } else {
            ValTotalLitros(idVentas);
            VentasSubTotales(idReporte);
            VentasTotales(idReporte);
            DiferenciaTotal(idReporte);
          }

        }
      });

    }


    function EditJarras(val, idReporte, idVentas) {

      var jarras = val.value;

      var parametros = {
        "type": "jarras",
        "idVentas": idVentas,
        "jarras": jarras,
        "accion": "editar-ventas"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/editar-ventas.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 0) {
            Ventas(idReporte);
          } else {
            ValTotalLitros(idVentas);
            VentasSubTotales(idReporte);
            VentasTotales(idReporte);
            DiferenciaTotal(idReporte);

          }

        }
      });

    }

    function EditPrecioLitro(val, idReporte, idVentas) {

      var preciolitro = val.value;

      var parametros = {
        "type": "preciolitro",
        "idVentas": idVentas,
        "preciolitro": preciolitro,
        "accion": "editar-ventas"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/editar-ventas.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 0) {
            Ventas(idReporte);
          } else {
            ValTotalLitros(idVentas);
            VentasSubTotales(idReporte);
            VentasTotales(idReporte);
            DiferenciaTotal(idReporte);

          }

        }
      });

    }

    function ValTotalLitros(idVentas) {

      var litros = $("#litros-" + idVentas).val();
      var jarras = $("#jarras-" + idVentas).val();
      var preciolitro = $("#preciolitro-" + idVentas).val();
      var totalLitros = 0;
      var importetotal = 0;

      if (jarras == "") {

        totalLitros = litros - 0;

      } else {
        totalLitros = litros - jarras;
      }

      if (preciolitro == "") {
        importetotal = totalLitros * 0;
      } else {
        importetotal = totalLitros * preciolitro;
      }


      function EditPCimporte(val, idReporte, idPagoCliente) {
        var importe = val.value;

        var parametros = {
          "type": "importe",
          "idPagoCliente": idPagoCliente,
          "importe": importe,
          "accion": "editar-pago-clientes"
        };

        $.ajax({
          data: parametros,
          url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
          //url:   '../../../public/corte-diario/modelo/editar-pagoclientes.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

            if (response == 0) {
              PagoCliente(idReporte);
            } else {
              PagoCTotal(idReporte);
              DifPagoCliente(idReporte);
            }

          }
        });
      }

      function EditPCnota(e, idReporte, idPagoCliente) {

        e.value = e.value.toUpperCase();
        var nota = e.value;

        var parametros = {
          "type": "nota",
          "idPagoCliente": idPagoCliente,
          "nota": nota,
          "accion": "editar-pago-clientes"
        };

        $.ajax({
          data: parametros,
          //url:   '../../../public/corte-diario/modelo/editar-pagoclientes.php',
          url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

            if (response == 0) {
              PagoCliente(idReporte);
            } else {
              PagoCTotal(idReporte);
            }

          }
        });
      }

      //----------------------------------------------------------------------------
      function NewVentas(idReporte) {

        var parametros = {
          "accion": "nuevo-registro-venta",
          "idReporte": idReporte
        };

        $.ajax({
          data: parametros,
          url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
          //url:'../../../public/corte-diario/modelo/nuevo-registro-ventas.php',
          type: 'POST',
          beforeSend: function () {
          },
          complete: function () {
            Ventas(idReporte);
          },
          success: function (response) {
          }
        });
      }
      //------------------------------------------------------
      function EditProducto(val, idReporte, idVentas) {

        var producto = val.value;

        if (producto != "") {

          var parametros = {
            "type": "producto",
            "idVentas": idVentas,
            "producto": producto,
            "accion": "editar-ventas"
          };

          $.ajax({
            data: parametros,
            url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
            //url:   '../../../public/corte-diario/modelo/editar-ventas.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {
            },
            success: function (response) {
              if (!response) {
                Ventas(idReporte);
              } else {
                VentasSubTotales(idReporte);
                VentasTotales(idReporte);
              }

            }
          });

        } else {
          $("#producto-" + idVentas).css({ 'border': '2px solid #CF2500' });
        }

      }

      function EditLitros(val, idReporte, idVentas) {

        var litros = val.value;

        var parametros = {
          "type": "litros",
          "idVentas": idVentas,
          "litros": litros,
          "accion": "editar-ventas"
        };

        $.ajax({
          data: parametros,
          url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
          //url:   '../../../public/corte-diario/modelo/editar-ventas.php',
          type: 'POST',
          beforeSend: function () {
          },
          complete: function () {
          },
          success: function (response) {
            if (!response) {
              Ventas(idReporte);
            } else {
              ValTotalLitros(idVentas);
              VentasSubTotales(idReporte);
              VentasTotales(idReporte);
              DiferenciaTotal(idReporte);
            }

          }
        });

      }


      function EditJarras(val, idReporte, idVentas) {

        var jarras = val.value;

        var parametros = {
          "type": "jarras",
          "idVentas": idVentas,
          "jarras": jarras,
          "accion": "editar-ventas"
        };

        $.ajax({
          data: parametros,
          url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
          //url:   '../../../public/corte-diario/modelo/editar-ventas.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

            if (response == 0) {
              Ventas(idReporte);
            } else {
              ValTotalLitros(idVentas);
              VentasSubTotales(idReporte);
              VentasTotales(idReporte);
              DiferenciaTotal(idReporte);

            }

          }
        });

      }

      function EditPrecioLitro(val, idReporte, idVentas) {

        var preciolitro = val.value;

        var parametros = {
          "type": "preciolitro",
          "idVentas": idVentas,
          "preciolitro": preciolitro,
          "accion": "editar-ventas"
        };

        $.ajax({
          data: parametros,
          url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
          //url:   '../../../public/corte-diario/modelo/editar-ventas.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

            if (response == 0) {
              Ventas(idReporte);
            } else {
              ValTotalLitros(idVentas);
              VentasSubTotales(idReporte);
              VentasTotales(idReporte);
              DiferenciaTotal(idReporte);

            }

          }
        });

      }

      function ValTotalLitros(idVentas) {

        var litros = $("#litros-" + idVentas).val();
        var jarras = $("#jarras-" + idVentas).val();
        var preciolitro = $("#preciolitro-" + idVentas).val();
        var totalLitros = 0;
        var importetotal = 0;

        if (jarras == "") {

          totalLitros = litros - 0;

        } else {
          totalLitros = litros - jarras;
        }

        if (preciolitro == "") {
          importetotal = totalLitros * 0;
        } else {
          importetotal = totalLitros * preciolitro;
        }



        $("#totallitros-" + idVentas).text(number_format(totalLitros, 2));
        $("#importetotal-" + idVentas).text(number_format(importetotal, 2));


        $("#totallitros-" + idVentas).text(number_format(totalLitros, 2));
        $("#importetotal-" + idVentas).text(number_format(importetotal, 2));

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

      function EditPrecioOtros(val, idReporte, idOtros) {

        var otros = val.value;

        var parametros = {
          "type": "otros",
          "idOtros": idOtros,
          "otros": otros,
          "accion": "editar-ventas"
        };

        $.ajax({
          data: parametros,
          url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
          //url:   '../../../public/corte-diario/modelo/editar-ventas.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {
          },
          success: function (response) {
            console.log(response);
            if (response == 0) {
              Ventas(idReporte);
            } else {
              VentasTotales(idReporte);
              DiferenciaTotal(idReporte);
            }

          }
        });

      }

      function EditObservaciones(val, idReporte) {

        var observaciones = val.value;

        var parametros = {
          "observaciones": observaciones,
          "idReporte": idReporte,
          "accion": "editar-observaciones"
        };

        $.ajax({
          data: parametros,
          //url:   '../../../public/corte-diario/modelo/editar-observaciones.php',
          url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

          }
        });

      }

      function Total1234(idReporte) {

        $('#Total1234').load('../../../public/corte-diario/vistas/totales-1234.php?idReporte=' + idReporte);
      }

      function DiferenciaTotal(idReporte) {

        $('#DiferenciaTotal').load('../../../public/corte-diario/vistas/diferencia-total.php?idReporte=' + idReporte);
      }

      function DifPagoCliente(idReporte) {

        $('#DifPagoCliente').load('../../../public/corte-diario/vistas/diferencia-pagocliente-total.php?idReporte=' + idReporte);
      }

      //------------------------------------------------------------------------

      function Aceites(year, mes, idReporte, idEstacion) {

        var parametros = {
          "year": year,
          "mes": mes,
          "idReporte": idReporte,
          "sessionIdEstacion": idEstacion,
          "accion": "nuevo-registro-aceites"
        };

        $.ajax({
          data: parametros,
          url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
          //url: '../../../public/corte-diario/modelo/nuevo-registro-aceites.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {
            AceitesLubricantes(idReporte);
          },
          success: function (response) {
          }
        });

      }

      function AceitesLubricantes(idReporte) {
        $('#DivAceitesLubricantes').html('<div class="text-center"><img width="30px" src="../../../imgs/iconos/load-img.gif"></div>');
        $('#DivAceitesLubricantes').load('../../../public/corte-diario/vistas/venta-aceites-lubricantes.php?idReporte=' + idReporte);
      }

      function EditALCantidad(val, idReporte, idAceite) {

        var cantidad = val.value;

        var parametros = {
          "type": "cantidad",
          "idAceite": idAceite,
          "cantidad": cantidad,
          "accion": "editar-aceites-lubricantes"
        };

        $.ajax({
          data: parametros,
          url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
          //url:   '../../../public/corte-diario/modelo/editar-aceites-lubricantes.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {
            if (response == 0) {
              AceitesLubricantes(idReporte);
            } else {
              ValAceitesLubricantes(idAceite);
              AceitesLTotal(idReporte);
              ActualizarVentasAL(idReporte);
              VentasTotales(idReporte);
            }

          }
        });

      }

      function EditALPrecio(val, idReporte, idAceite) {

        var precio = val.value;

        var parametros = {
          "type": "precio",
          "idAceite": idAceite,
          "precio": precio,
          "accion": "editar-aceites-lubricantes"
        };

        $.ajax({
          data: parametros,
          url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
          //url:   '../../../public/corte-diario/modelo/editar-aceites-lubricantes.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

            if (response == 0) {
              AceitesLubricantes(idReporte);
            } else {
              ValAceitesLubricantes(idAceite);
              AceitesLTotal(idReporte);
              ActualizarVentasAL(idReporte);
              VentasTotales(idReporte);
            }

          }
        });

      }

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

    function EditPrecioOtros(val, idReporte, idOtros) {

      var otros = val.value;

      var parametros = {
        "type": "otros",
        "idOtros": idOtros,
        "otros": otros,
        "accion": "editar-ventas"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/editar-ventas.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {
        },
        success: function (response) {
          console.log(response);
          if (response == 0) {
            Ventas(idReporte);
          } else {
            VentasTotales(idReporte);
            DiferenciaTotal(idReporte);
          }

        }
      });

    }

    function EditObservaciones(val, idReporte) {

      var observaciones = val.value;

      var parametros = {
        "observaciones": observaciones,
        "idReporte": idReporte,
        "accion": "editar-observaciones"
      };

      $.ajax({
        data: parametros,
        //url:   '../../../public/corte-diario/modelo/editar-observaciones.php',
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

        }
      });

    }

    function Total1234(idReporte) {

      $('#Total1234').load('../../../public/corte-diario/vistas/totales-1234.php?idReporte=' + idReporte);
    }

    function DiferenciaTotal(idReporte) {

      $('#DiferenciaTotal').load('../../../public/corte-diario/vistas/diferencia-total.php?idReporte=' + idReporte);
    }

    function DifPagoCliente(idReporte) {

      $('#DifPagoCliente').load('../../../public/corte-diario/vistas/diferencia-pagocliente-total.php?idReporte=' + idReporte);
    }

    //------------------------------------------------------------------------

    function Aceites(year, mes, idReporte, idEstacion) {

      var parametros = {
        "year": year,
        "mes": mes,
        "idReporte": idReporte,
        "sessionIdEstacion": idEstacion,
        "accion": "nuevo-registro-aceites"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url: '../../../public/corte-diario/modelo/nuevo-registro-aceites.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {
          AceitesLubricantes(idReporte);
        },
        success: function (response) {
        }
      });

    }

    function AceitesLubricantes(idReporte) {
      $('#DivAceitesLubricantes').html('<div class="text-center"><img width="30px" src="../../../imgs/iconos/load-img.gif"></div>');
      $('#DivAceitesLubricantes').load('../../../public/corte-diario/vistas/venta-aceites-lubricantes.php?idReporte=' + idReporte);
    }

    function EditALCantidad(val, idReporte, idAceite) {

      var cantidad = val.value;

      var parametros = {
        "type": "cantidad",
        "idAceite": idAceite,
        "cantidad": cantidad,
        "accion": "editar-aceites-lubricantes"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/editar-aceites-lubricantes.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {
          if (response == 0) {
            AceitesLubricantes(idReporte);
          } else {
            ValAceitesLubricantes(idAceite);
            AceitesLTotal(idReporte);
            ActualizarVentasAL(idReporte);
            VentasTotales(idReporte);
          }

        }
      });

    }

    function EditALPrecio(val, idReporte, idAceite) {

      var precio = val.value;

      var parametros = {
        "type": "precio",
        "idAceite": idAceite,
        "precio": precio,
        "accion": "editar-aceites-lubricantes"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/editar-aceites-lubricantes.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 0) {
            AceitesLubricantes(idReporte);
          } else {
            ValAceitesLubricantes(idAceite);
            AceitesLTotal(idReporte);
            ActualizarVentasAL(idReporte);
            VentasTotales(idReporte);
          }

        }
      });

    }

    function ValAceitesLubricantes(idAceite) {

      var cantidad = $("#cantidadAL-" + idAceite).val();
      var precio = $("#precioAL-" + idAceite).val();
      //var precio = $("#precioAL-" + idAceite).text();

      if (cantidad == "") {
        valcantidad = 0;
      } else {
        valcantidad = cantidad;
      }

      if (precio == "") {
        valprecio = 0;
      } else {
        valprecio = precio;
      }

      totalimporte = (parseInt(valcantidad) * parseInt(valprecio));
      $("#importeAL-" + idAceite).text(formatAsMoney(totalimporte));

    }

    function ActualizarVentasAL(idReporte) {

      var parametros = {
        "type": "piezas",
        "idReporte": idReporte,
        "accion": "editar-ventas"
      };

      $.ajax({
        data: parametros,
        url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../../public/corte-diario/modelo/editar-ventas.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {
          console.log(response);
          if (response == 0) {
            AceitesLubricantes(idReporte);
          } else {
            Ventas(idReporte);
          }

        }
      });

    }

    function PDF(idReporte) {
      window.location = "../../../public/corte-diario/vistas/pdf-corte-ventas.php?idReporte=" + idReporte;
    }

    function FirmarCorte(idReporte, sessionIdUsuario, sessionNomEstacion) {

      let signatureBlank = signaturePad.isEmpty();

      if ($('#terminosid').prop('checked')) {
        $('.form-check').css('color', '')
        if (!signatureBlank) {

          var ctx = document.getElementById("canvas");
          var image = ctx.toDataURL();
          document.getElementById('base64').value = image;
          var base64 = $('#base64').val();


          var parametros = {
            "base64": base64,
            "idReporte": idReporte,
            "sessionUsuario": sessionIdUsuario,
            "nombreEstacion": sessionNomEstacion,
            "accion": "firma-corte"
          };

          $.ajax({
            data: parametros,
            url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
            //url:   '../../../public/corte-diario/modelo/agregar-firma.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {
              console.log(response);

              if (response == 1) {
                location.reload();
              } else {
                alertify.error('Error al firmar el corte')
              }

            }
          });


        } else {
          $('#canvas').css('border', '2px solid #A52525');
          baseImage = "";
        }
      } else {
        $('.form-check').css('color', ' red')
      }

    }

    function ListaDocumentos(idReporte) {
      $('#Documentos').load('../../../public/corte-diario/vistas/lista-documentos.php?idReporte=' + idReporte);
    }

    function NewDocumento(idReporte) {
      $('#ModalPrincipal').modal('show');
    }

    function GuardarDocumento(idReporte) {
      var NombreDocumento = $('#NombreDocumento').val();
      var Documento = $('#Documento').val();

      var data = new FormData();
      var url = '../../../app/controlador/1-corporativo/controladorCorteDiario.php';
      //var url = '../../../public/corte-diario/modelo/agregar-documento.php';

      Documento = document.getElementById("Documento");
      Documento_file = Documento.files[0];
      Documento_filePath = Documento.value;

      if (NombreDocumento != "") {
        $('#NombreDocumento').css('border', '');
        if (Documento_filePath != "") {
          $('#Documento').css('border', '');

          data.append('idReporte', idReporte);
          data.append('NombreDocumento', NombreDocumento);
          data.append('Documento_file', Documento_file);
          data.append('accion', 'agregar-documento');

          $.ajax({
            url: url,
            type: 'POST',
            contentType: false,
            data: data,
            processData: false,
            cache: false
          }).done(function (data) {
            $('#NombreDocumento').val('');
            $('#Documento').val('');
            ListaDocumentos(idReporte);
            $('#ModalPrincipal').modal('hide');
            alertify.success('Documento agregado exitosamente.')

          });

        } else {
          $('#Documento').css('border', '2px solid #A52525');
        }
      } else {
        $('#NombreDocumento').css('border', '2px solid #A52525');
      }
    }

    function EliminarDoc(id, idReporte) {

      var parametros = {
        "id": id,
        "accion": "eliminar-documento-corte"
      };


      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {
                ListaDocumentos(idReporte);
                alertify.success('Documento eliminado exitosamente.')

              } else {
                alertify.error('Error al eliminar el documento del corte')
              }

            }
          });

        },
        function () {
        }).setHeader('Eliminar documento').set({ transition: 'zoom', message: '¿Desea eliminar el documento seleccionado?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

    }
  </script>
<body>
  <div class="LoaderPage"></div>
  <?php
  $estado = "";
  if ($ventas == 1):
    $estado = "disabled";
  endif;
  ?>
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
                  <img class="float-start pointer" src="<?= RUTA_IMG_ICONOS; ?>regresar.png" onclick="history.back()">
                  <div class="row">
                    <div class="col-11">
                      <h5><?= FormatoFecha($dia); ?></h5>
                    </div>
                    <div class="col-1">
                      <img class="float-end pointer" src="<?= RUTA_IMG_ICONOS; ?>pdf.png"
                        onclick="PDF(<?= $GET_idReporte; ?>)">
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <!---------- TABLA - CONCENTRADO DE VENTAS ---------->
                <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-3">
                  <div class="border mb-3">
                    <div class="bg-light p-2 text-center">
                      <strong>CONCENTRADO DE VENTAS</strong>
                      <?php if ($ventas == 0) { ?>
                        <div class="float-end pointer"><img src="<?= RUTA_IMG_ICONOS; ?>agregar.png"
                            onclick="NewVentas(<?= $GET_idReporte; ?>)"></div>
                      <?php } ?>
                    </div>
                    <div class="p-2">
                      <div id="DivConecntradoVentas"></div>
                    </div>
                  </div>
                  <div class="border mb-3">
                    <div class="bg-light p-2 text-center">
                      <strong>RELACION DE VENTA DE ACEITES Y LUBRICANTES</strong>
                    </div>
                    <div class="p-2">
                      <div id="DivAceitesLubricantes"></div>
                    </div>
                  </div>
                  <div class="border">
                    <div class="p-2">
                      <div class="text-end pointer p-1">
                        <img class="pointer" src="<?= RUTA_IMG_ICONOS; ?>agregar.png"
                          onclick="NewDocumento(<?= $GET_idReporte; ?>)">
                      </div>
                      <hr>
                      <div id="Documentos"></div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-2">
                  <div class="border">
                    <div class="bg-light p-2 text-center">
                      <strong>PROSEGUR</strong>
                    </div>
                    <div class="p-2">
                      <div id="DivProsegur"></div>
                    </div>
                  </div>
                  <div class="border mt-3">
                    <div class="bg-light p-2 text-center">
                      <strong>MONEDEROS Y BANCOS</strong>
                    </div>

                    <div class="p-2">
                      <div id="DivTarjetasBancarias"></div>
                    </div>
                  </div>
                  <hr>
                  <div class="border mt-3">
                    <div class="bg-light p-2 text-center">
                      <strong>CLIENTES (ATIO)</strong>
                    </div>
                    <div class="p-2">
                      <div id="DivControlgas"></div>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered pb-0 mb-0 mt-2">
                      <tr>
                        <td>C TOTAL (1+2+3)</td>
                        <td class="bg-light align-middle text-end pointer" id="Total1234"></td>
                      </tr>
                    </table>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered pb-0 mb-0 mt-2">
                      <tr>
                        <td><strong>DIFERENCIA (B-C)</strong></td>
                        <td class="bg-light align-middle text-end pointer" id="DiferenciaTotal"></td>
                      </tr>
                    </table>
                  </div>
                  <div class="border mt-3">
                    <div class="bg-light p-2 text-center">
                      <strong>PAGO DE CLIENTES</strong>
                    </div>
                    <div class="p-2">
                      <div id="DivPagoClientes"></div>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered pb-0 mb-0 mt-2">
                      <tr>
                        <td>DIF PAGO DE CLIENTES</td>
                        <td class="bg-light align-middle text-end pointer" id="DifPagoCliente"></td>
                        <td>(4-5)</td>
                      </tr>
                    </table>
                  </div>
                  <hr>
                  <div class="border mt-3">
                    <div class="bg-light p-2 text-center">
                      <strong>OBSERVACIONES</strong>
                    </div>
                    <div class="p-2">
                      <?php
                      $observaciones = $corteDiarioGeneral->getObsevaciones($GET_idReporte);
                      ?>
                      <textarea class="form-control" onkeyup="EditObservaciones(this,<?= $GET_idReporte; ?>)"
                        <?= $estado; ?>><?= $observaciones; ?></textarea>
                    </div>
                  </div>
                  <?php if ($ventas == 0) { ?>
                    <hr>
                    <div class="border mt-3">
                      <div class="p-3">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="terminosid">
                          <label class="form-check-label" for="terminosid">
                            <small>Acepto los resultados del corte del día <?= FormatoFecha($dia); ?></small>
                          </label>
                        </div>
                        <hr>
                        <div id="signature-pad" class="signature-pad mt-2">
                          <div class="signature-pad--body">
                            <canvas style="width: 100%; height: 200px; border: 1px black solid; " id="canvas"></canvas>
                          </div>
                        </div>
                        <input type="hidden" name="base64" value="" id="base64">
                        <hr>
                        <div class="text-end pointer">
                          <button class="btn btn-success mt-2"
                            onclick="FirmarCorte(<?= $GET_idReporte; ?>,<?= $Session_IDUsuarioBD; ?>,'<?= $session_nomestacion; ?>')">Guardar
                            y Finalizar</button>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
              <?php if ($ventas == 1) { ?>
                <div class="border">
                  <div class="p-3">
                    <?php
                    $Elaboro = $corteDiarioGeneral->validaFirma($GET_idReporte, 'Elaboró');
                    $Superviso = $corteDiarioGeneral->validaFirma($GET_idReporte, 'Superviso');
                    $VoBo = $corteDiarioGeneral->validaFirma($GET_idReporte, 'VoBo');
                    ?>
                    <div class="row">
                      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                        <div class="border ">
                          <div class="p-3">
                            <div class="text-center font-weight-bold">ELABORÓ</div>
                            <hr>
                            <?php
                            if ($Elaboro > 0) {
                              $RElaboro = $corteDiarioGeneral->firma($GET_idReporte, 'Elaboró', RUTA_IMG_Firma, );
                              echo $RElaboro;
                            } else {
                              echo '<div class=" col-12 text-center mb-3">';
                              echo '<div class="p-2"><small>No se encontró firma del corte diario</small></div>';
                              echo '<div class="text-center mt-1 border-top "></div>';
                              echo '</div>';
                            }
                            ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                        <div class="border ">
                          <div class="p-3">
                            <?php
                            if ($Superviso > 0) {
                              echo '<div class="text-center font-weight-bold">SUPERVISO</div>';
                              echo '<hr>';
                              $RSuperviso = $corteDiarioGeneral->firma($GET_idReporte, 'Superviso', RUTA_IMG_Firma);
                              echo $RSuperviso;
                            } else {
                              echo '<div class="text-center font-weight-bold">SUPERVISO</div>';
                              echo '<hr>';
                              echo '<div class="text-center mt-1">';
                              echo '<div class="p-2"><small>No se encontró firma del corte supervisor</small></div>';
                              echo '<div class="text-center mt-1 border-top pt-2"></div>';
                              echo '</div>';
                            }
                            ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                        <div class="border ">
                          <div class="p-3">
                            <?php
                            if ($VoBo > 0) {
                              echo '<div class="text-center font-weight-bold">VO.BO.</div>';
                              echo '<hr>';
                              $RVoBo = $corteDiarioGeneral->firma($GET_idReporte, 'VoBo', RUTA_IMG_Firma);
                              echo $RVoBo;
                            } else {
                              echo '<div class="text-center font-weight-bold">VO.BO.</div>';
                              echo '<hr>';
                              echo '<div class="text-center mt-1">';
                              echo '<div class="p-2"><small>No se encontró firma del VOBO</small></div>';
                              echo '<div class="text-center mt-1 border-top pt-2"></div>';
                              echo '</div>';
                            }
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade bd-example-modal-lg" id="ModalPrincipal" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content border-0 rounded-0">
        <div class="modal-header">
          <h5 class="modal-title">Agegar Documento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <small>* Documento</small>
          <select class="form-select mb-1" id="NombreDocumento">
            <option value="">Selecciona</option>
            <option value="Ficha prosegur">Ficha prosegur</option>
            <option value="Ficha 1 prosegur">Ficha 1 prosegur</option>
            <option value="Ficha 2 prosegur">Ficha 2 prosegur</option>
            <option value="Ficha 3 prosegur">Ficha 3 prosegur</option>
            <option value="Ficha banco">Ficha banco</option>
            <option value="Corte cierre de efectivale">Corte cierre de efectivale</option>
            <option value="Cierres de lote">Cierres de lote</option>
            <option value="Corte">Corte</option>
            <option value="Documento/archivo adicional">Documento/archivo adicional</option>
          </select>
          <div class="mt-2 mb-1"><small>* Selecciona el documento</small></div>
          <input class="form-control" type="file" id="Documento">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="GuardarDocumento(<?= $GET_idReporte; ?>)">Guardar
            documento</button>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    var wrapper = document.getElementById("signature-pad");
    var canvas = wrapper.querySelector("canvas");
    var signaturePad = new SignaturePad(canvas, {
      backgroundColor: 'rgb(255, 255, 255)'
    });
    function resizeCanvas() {
      var ratio = Math.max(window.devicePixelRatio || 1, 1);
      canvas.width = canvas.offsetWidth * ratio;
      canvas.height = canvas.offsetHeight * ratio;
      canvas.getContext("2d").scale(ratio, ratio);
      signaturePad.clear();
    }
    window.onresize = resizeCanvas;
    resizeCanvas();
  </script>
  <!---------- FUNCIONES - NAVBAR ---------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>
</body>

</html>