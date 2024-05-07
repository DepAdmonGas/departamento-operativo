function Ticketcard(idReporte, empresa) {
    var parametros = {
      "idReporte": idReporte,
      "empresa": empresa
    };

    $.ajax({
      data: parametros,
      url:'../../../app/vistas/personal-general/1-corporativo/corte-diario/lista-cierre-lote.php',
      //url: '../../../public/corte-diario/vistas/lista-cierre-lote.php',
      type: 'get',
      beforeSend: function () {
      },
      complete: function () {

      },
      success: function (response) {

        $('#DivTicketcard').html(response);

      }
    });

  }

  function Amex(idReporte, empresa) {

    var parametros = {
      "idReporte": idReporte,
      "empresa": empresa
    };

    $.ajax({
      data: parametros,
      url:'../../../app/vistas/personal-general/1-corporativo/corte-diario/lista-cierre-lote.php',
      //url: '../../../public/corte-diario/vistas/lista-cierre-lote.php',
      type: 'get',
      beforeSend: function () {
      },
      complete: function () {

      },
      success: function (response) {

        $('#DivAmex').html(response);

      }
    });


  }

  function G500Fleet(idReporte, empresa) {

    var parametros = {
      "idReporte": idReporte,
      "empresa": empresa
    };

    $.ajax({
      data: parametros,
      url:'../../../app/vistas/personal-general/1-corporativo/corte-diario/lista-cierre-lote.php',
      //url: '../../../public/corte-diario/vistas/lista-cierre-lote.php',
      type: 'get',
      beforeSend: function () {
      },
      complete: function () {

      },
      success: function (response) {

        $('#DivG500Fleet').html(response);

      }
    });

  }

  function BANCOMER(idReporte, empresa) {


    var parametros = {
      "idReporte": idReporte,
      "empresa": empresa
    };

    $.ajax({
      data: parametros,
      url:'../../../app/vistas/personal-general/1-corporativo/corte-diario/lista-cierre-lote.php',
      //url: '../../../public/corte-diario/vistas/lista-cierre-lote.php',
      type: 'get',
      beforeSend: function () {
      },
      complete: function () {

      },
      success: function (response) {

        $('#DivBANCOMER').html(response);

      }
    });

  }

  function Efecticard(idReporte, empresa) {

    var parametros = {
      "idReporte": idReporte,
      "empresa": empresa
    };

    $.ajax({
      data: parametros,
      url:'../../../app/vistas/personal-general/1-corporativo/corte-diario/lista-cierre-lote.php',
      //url: '../../../public/corte-diario/vistas/lista-cierre-lote.php',
      type: 'get',
      beforeSend: function () {
      },
      complete: function () {

      },
      success: function (response) {

        $('#DivEfecticard').html(response);

      }
    });
  }

  function Sodexo(idReporte, empresa) {


    var parametros = {
      "idReporte": idReporte,
      "empresa": empresa
    };

    $.ajax({
      data: parametros,
      url:'../../../app/vistas/personal-general/1-corporativo/corte-diario/lista-cierre-lote.php',
      //url: '../../../public/corte-diario/vistas/lista-cierre-lote.php',
      type: 'get',
      beforeSend: function () {
      },
      complete: function () {

      },
      success: function (response) {

        $('#DivSodexo').html(response);

      }
    });
  }

  function Inburgas(idReporte, empresa) {


    var parametros = {
      "idReporte": idReporte,
      "empresa": empresa
    };

    $.ajax({
      data: parametros,
      url:'../../../app/vistas/personal-general/1-corporativo/corte-diario/lista-cierre-lote.php',
      //url: '../../../public/corte-diario/vistas/lista-cierre-lote.php',
      type: 'get',
      beforeSend: function () {
      },
      complete: function () {

      },
      success: function (response) {

        $('#DivInburgas').html(response);

      }
    });

  }

  function Ultragas(idReporte, empresa) {


    var parametros = {
      "idReporte": idReporte,
      "empresa": empresa
    };

    $.ajax({
      data: parametros,
      url:'../../../app/vistas/personal-general/1-corporativo/corte-diario/lista-cierre-lote.php',
      //url: '../../../public/corte-diario/vistas/lista-cierre-lote.php',
      type: 'get',
      beforeSend: function () {
      },
      complete: function () {

      },
      success: function (response) {

        $('#DivUltragas').html(response);

      }
    });

  }

  function Energex(idReporte, empresa) {


    var parametros = {
      "idReporte": idReporte,
      "empresa": empresa
    };

    $.ajax({
      data: parametros,
      url:'../../../app/vistas/personal-general/1-corporativo/corte-diario/lista-cierre-lote.php',
      //url: '../../../public/corte-diario/vistas/lista-cierre-lote.php',
      type: 'get',
      beforeSend: function () {
      },
      complete: function () {

      },
      success: function (response) {

        $('#DivEnergex').html(response);

      }
    });

  }

  function Inbursa(idReporte, empresa) {


    var parametros = {
      "idReporte": idReporte,
      "empresa": empresa
    };

    $.ajax({
      data: parametros,
      url:'../../../app/vistas/personal-general/1-corporativo/corte-diario/lista-cierre-lote.php',
      //url: '../../../public/corte-diario/vistas/lista-cierre-lote.php',
      type: 'get',
      beforeSend: function () {
      },
      complete: function () {

      },
      success: function (response) {

        $('#DivINBURSA').html(response);

      }
    });

  }

  /------------------------------------------------------------------------------------/

  function AgregarCierre(idReporte, empresa) {

    var parametros = {
      "idReporte": idReporte,
      "empresa": empresa,
      "accion": "nuevo-cierre-lote"
    };

    $.ajax({
      data: parametros,
      url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
      //url:   '../../../public/corte-diario/modelo/nuevo-cierre-lote.php',
      type: 'post',
      beforeSend: function () { },
      complete: function () { },
      success: function (response) {
        switch (response) {
          case "TICKETCARD":
            Ticketcard(idReporte, empresa);
            break;
          case "AMERICAN EXPRESS":
            Amex(idReporte, empresa);
            break;
          case "G500 FLETT":
            G500Fleet(idReporte, empresa);
            break;
          case "BBVA BANCOMER SA":
            BANCOMER(idReporte, empresa);
            break;
          case "EFECTICARD":
            Efecticard(idReporte, empresa);
            break;
          case "SODEXO":
            Sodexo(idReporte, empresa);
            break;
          case "INBURGAS":
            Inburgas(idReporte, empresa);
            break;
          case "ULTRAGAS":
            Ultragas(idReporte, empresa);
            break;
          case "ENERGEX":
            Energex(idReporte, empresa);
            break;
          case "INBURSA":
            Inbursa(idReporte, empresa);
            break;
        }
      }
    });

  }

  function EditNoCierre(val, idReporte, idCierre, empresa) {
    var nocierre = val.value;

    var parametros = {
      "type": "nocierre",
      "idCierre": idCierre,
      "nocierre": nocierre,
      "accion": "editar-cierre-lote"
    };

    $.ajax({
      data: parametros,
      url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
      //url:   '../../../public/corte-diario/modelo/editar-cierre-lote.php',
      type: 'post',
      beforeSend: function () { },
      complete: function () { },
      success: function (response) {
        if (!response) {
          switch (response) {
            case "TICKETCARD":
              Ticketcard(idReporte, empresa);
              break;
            case "AMERICAN EXPRESS":
              Amex(idReporte, empresa);
              break;
            case "G500 FLETT":
              G500Fleet(idReporte, empresa);
              break;
            case "BBVA BANCOMER SA":
              BANCOMER(idReporte, empresa);
              break;
            case "EFECTICARD":
              Efecticard(idReporte, empresa);
              break;
            case "SODEXO":
              Sodexo(idReporte, empresa);
              break;
            case "INBURGAS":
              Inburgas(idReporte, empresa);
              break;
            case "ULTRAGAS":
              Ultragas(idReporte, empresa);
              break;
            case "ENERGEX":
              Energex(idReporte, empresa);
              break;
            case "INBURSA":
              Inbursa(idReporte, empresa);
              break;
          }
        }
      }
    });

  }
  function EditImporte(val, idReporte, idCierre, empresa) {
    var importe = val.value;

    var parametros = {
      "type": "importe",
      "idCierre": idCierre,
      "importe": importe,
      "idReporte": idReporte,
      "empresa": empresa,
      "accion": "editar-cierre-lote"
    };

    $.ajax({
      data: parametros,
      url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
      //url:   '../../../public/corte-diario/modelo/editar-cierre-lote.php',
      type: 'post',
      beforeSend: function () { },
      complete: function () { },
      success: function (response) {
        if (!response) {
          switch (response) {
            case "TICKETCARD":
              Ticketcard(idReporte, empresa);
              break;
            case "AMERICAN EXPRESS":
              Amex(idReporte, empresa);
              break;
            case "G500 FLETT":
              G500Fleet(idReporte, empresa);
              break;
            case "BBVA BANCOMER SA":
              BANCOMER(idReporte, empresa);
              break;
            case "EFECTICARD":
              Efecticard(idReporte, empresa);
              break;
            case "SODEXO":
              Sodexo(idReporte, empresa);
              break;
            case "INBURGAS":
              Inburgas(idReporte, empresa);
              break;
            case "ULTRAGAS":
              Ultragas(idReporte, empresa);
              break;
            case "ENERGEX":
              Energex(idReporte, empresa);
              break;
            case "INBURSA":
              Inbursa(idReporte, empresa);
              break;
          }
        } else {
          TotalCierre(idReporte, empresa);
        }
      }
    });

  }
  function EditNoTicket(val, idReporte, idCierre, empresa) {
    var noticket = val.value;

    var parametros = {
      "type": "noticket",
      "idCierre": idCierre,
      "noticket": noticket,
      "accion": "editar-cierre-lote"
    };

    $.ajax({
      data: parametros,
      url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
      //url:   '../../../public/corte-diario/modelo/editar-cierre-lote.php',
      type: 'post',
      beforeSend: function () { },
      complete: function () { },
      success: function (response) {
        if (!response) {
          switch (response) {
            case "TICKETCARD":
              Ticketcard(idReporte, empresa);
              break;
            case "AMERICAN EXPRESS":
              Amex(idReporte, empresa);
              break;
            case "G500 FLETT":
              G500Fleet(idReporte, empresa);
              break;
            case "BBVA BANCOMER SA":
              BANCOMER(idReporte, empresa);
              break;
            case "EFECTICARD":
              Efecticard(idReporte, empresa);
              break;
            case "SODEXO":
              Sodexo(idReporte, empresa);
              break;
            case "INBURGAS":
              Inburgas(idReporte, empresa);
              break;
            case "ULTRAGAS":
              Ultragas(idReporte, empresa);
              break;
            case "ENERGEX":
              Energex(idReporte, empresa);
              break;
            case "INBURSA":
              Inbursa(idReporte, empresa);
              break;
          }
        } else {
          TotalCierre(idReporte, empresa);
        }

      }
    });

  }

  function Pendiente(idReporte, idCierre, empresa, status) {
    let desc;
    if (status == 0) {
      desc = "Activo";
    } else {
      desc = "Pendiente";
    }
    alertify.confirm('',
      function () {

        var parametros = {
          "estado": status,
          "idCierre": idCierre,
          "accion": "editar-pendiente-cierre-lote"
        };

        $.ajax({
          data: parametros,
          url: '../../../app/controlador/1-corporativo/controladorCorteDiario.php',
          //url:   '../../../public/corte-diario/modelo/editar-pendiente-cierre-lote.php',
          type: 'post',
          beforeSend: function () { },
          complete: function () { },
          success: function (response) {
            if (response) {
              switch (empresa) {
                case "TICKETCARD":
                  Ticketcard(idReporte, empresa);
                  break;
                case "AMERICAN EXPRESS":
                  Amex(idReporte, empresa);
                  break;
                case "G500 FLETT":
                  G500Fleet(idReporte, empresa);
                  break;
                case "BBVA BANCOMER SA":
                  BANCOMER(idReporte, empresa);
                  break;
                case "EFECTICARD":
                  Efecticard(idReporte, empresa);
                  break;
                case "SODEXO":
                  Sodexo(idReporte, empresa);
                  break;
                case "INBURGAS":
                  Inburgas(idReporte, empresa);
                  break;
                case "ULTRAGAS":
                  Ultragas(idReporte, empresa);
                  break;
                case "ENERGEX":
                  Energex(idReporte, empresa);
                  break;
                case "INBURSA":
                  Inbursa(idReporte, empresa);
                  break;
              }
            }
          }
        });

      },
      function () {
      }).setHeader('' + desc).set({ transition: 'zoom', message: '¿Desea poner el estado ' + desc + ' del cierre de lote seleccionado?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();


  }