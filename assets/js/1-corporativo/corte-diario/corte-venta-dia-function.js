function Ventas(idReporte) {
  $('#DivConecntradoVentas').html('<div class="text-center"><img width="30px" src="../../../imgs/iconos/load-img.gif"></div>');
  $('#DivConecntradoVentas').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/ventas/concentrado-ventas.php?idReporte=' + idReporte);
  //$('#DivConecntradoVentas').load('../../../public/corte-diario/vistas/concentrado-ventas.php?idReporte=' + idReporte);
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
  $('#DivProsegur').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/ventas/prosegur.php?idReporte=' + idReporte);
  //$('#DivProsegur').load('../../../public/corte-diario/vistas/prosegur.php?idReporte=' + idReporte);
}

/*---------------------------------------------------------------------------*/


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
  $('#DivTarjetasBancarias').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/ventas/tarjetas-bancarias.php?idReporte=' + idReporte);
  //$('#DivTarjetasBancarias').load('../../../public/corte-diario/vistas/tarjetas-bancarias.php?idReporte=' + idReporte);
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
  $('#DivControlgas').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/ventas/clientes-controlgas.php?idReporte=' + idReporte);
  //$('#DivControlgas').load('../../../public/corte-diario/vistas/clientes-controlgas.php?idReporte=' + idReporte);
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
  $('#DivPagoClientes').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/ventas/pago-clientes.php?idReporte=' + idReporte);
  //$('#DivPagoClientes').load('../../../public/corte-diario/vistas/pago-clientes.php?idReporte=' + idReporte);
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
//-----------------------------------------------------


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
  $('#Total1234').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/ventas/totales-1234.php?idReporte=' + idReporte);
  //$('#Total1234').load('../../../public/corte-diario/vistas/totales-1234.php?idReporte=' + idReporte);
}

function DiferenciaTotal(idReporte) {
  $('#DiferenciaTotal').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/ventas/diferencia-total.php?idReporte=' + idReporte);
  //$('#DiferenciaTotal').load('../../../public/corte-diario/vistas/diferencia-total.php?idReporte=' + idReporte);
}

function DifPagoCliente(idReporte) {
  $('#DifPagoCliente').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/ventas/diferencia-pagocliente-total.php?idReporte=' + idReporte);
  //$('#DifPagoCliente').load('../../../public/corte-diario/vistas/diferencia-pagocliente-total.php?idReporte=' + idReporte);
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
  $('#DivAceitesLubricantes').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/ventas/venta-aceites-lubricantes.php?idReporte=' + idReporte);
  //$('#DivAceitesLubricantes').load('../../../public/corte-diario/vistas/venta-aceites-lubricantes.php?idReporte=' + idReporte);
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
  window.location = "../../../app/vistas/personal-general/1-corporativo/corte-diario/ventas/pdf-corte-ventas.php?idReporte=" + idReporte;
  //window.location = "../../../public/corte-diario/vistas/pdf-corte-ventas.php?idReporte=" + idReporte;
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
      baseImage = "";
      alertify.error('Falta firma');
      // funcion que se encarga de llevarte a la firma en caso de no tenerla
      window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
    }
  } else {
    alertify.error('Debes aceptar los resultados del corte diario');
    window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
  }

}

function ListaDocumentos(idReporte) {
  $('#Documentos').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/ventas/lista-documentos.php?idReporte=' + idReporte);
  //$('#Documentos').load('../../../public/corte-diario/vistas/lista-documentos.php?idReporte=' + idReporte);
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