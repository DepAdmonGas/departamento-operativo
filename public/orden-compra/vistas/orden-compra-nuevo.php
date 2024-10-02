<?php
require ('app/help.php');

if ($Session_IDUsuarioBD == "") {
  header("Location:" . PORTAL . "");
}

$sql = "SELECT * 
FROM op_orden_compra WHERE id = '" . $GET_idReporte . "' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
  $no_control = $row['no_control'];
  $porcentaje_total = $row['porcentaje_total'];
  $cargo = $row['cargo'];

  $explode = explode(" ", $row['fecha']);
  $Fecha = $explode[0];
  $estatus = $row['estatus'];
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
  <script type="text/javascript" src="<?php echo RUTA_JS ?>signature_pad.js"></script>

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      ContenidoEstaciones(<?= $GET_idReporte; ?>)
      ContenidoProveedor(<?= $GET_idReporte; ?>)
      ContenidoArticulos(<?= $GET_idReporte; ?>)
      ContenidoRefacturacion(<?= $GET_idReporte; ?>)

      if (<?= $estatus; ?> == 1) {
        Regresar()
      }


    });


    function Regresar() {
      window.history.back();
    }


    function ContenidoEstaciones(idReporte) {
      $('#ContenidoEstaciones').load('../../public/orden-compra/vistas/lista-estaciones.php?idReporte=' + idReporte + '&idStatus=' + 0);
    }

    function ContenidoProveedor(idReporte) {
      $('#ContenidoProveedor').load('../../public/orden-compra/vistas/lista-proveedor.php?idReporte=' + idReporte + '&idStatus=' + 0);
    }

    function ContenidoArticulos(idReporte) {
      $('#ContenidoArticulos').load('../../public/orden-compra/vistas/lista-producto.php?idReporte=' + idReporte + '&idStatus=' + 0);
    }

    function ContenidoRefacturacion(idReporte) {
      $('#ContenidoRefacturacion').load('../../public/orden-compra/vistas/lista-refacturacion.php?idReporte=' + idReporte + '&idStatus=' + 0);
    }

    //---------- MODAL AGREGAR PROVEEDOR ----------//
    function ModalProveedor(idReporte) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('../../public/orden-compra/vistas/modal-agregar-proveedor.php?idReporte=' + idReporte);
    }

    //---------- MODAL EDITAR PROVEEDOR ----------//
    function ModalEditarProveedor(idProveedor, idReporte) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('../../public/orden-compra/vistas/modal-editar-proveedor.php?idProveedor=' + idProveedor + '&idReporte=' + idReporte);
    }

    //---------- MODAL AGREGAR y EDITAR ESTACION ----------//
    function ModalEstacion(idReporte, idFuncion) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('../../public/orden-compra/vistas/modal-agregar-estacion.php?idReporte=' + idReporte + '&idFuncion=' + idFuncion);
    }

    //---------- MODAL AGREGAR PRODUCTO PROVEEDOR ----------//
    function Producto(idReporte) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('../../public/orden-compra/vistas/modal-agregar-articulo.php?idReporte=' + idReporte);
    }

    //---------- MODAL AGREGAR REFACTURACION ----------//
    function Refacturacion(idReporte) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('../../public/orden-compra/vistas/modal-agregar-refacturacion.php?idReporte=' + idReporte);
    }


    //---------- AGREGAR y EDITAR ESTACION (SERVER) ----------//
    function AgregarEstacion(idReporte, idFuncion) {
      var estacionName = $('#estacionName').val();

      if (estacionName != "") {
        $('#estacionName').css('border', '');

        var parametros = {
          "idReporte": idReporte,
          "idEstacion": estacionName,
          "idFuncion": idFuncion
        }


        $.ajax({
          data: parametros,
          url: '../../public/orden-compra/modelo/agregar-estacion-orden.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

            if (response == 1) {

              var comentario = "";
              var comentario2 = "";

              if (idFuncion == 0) {
                comentario = "agregada";
                comentario2 = "agregar";
              } else {
                comentario = "editada";
                comentario2 = "editar";
              }


              ContenidoEstaciones(idReporte)
              alertify.success('Estacion ' + comentario + ' exitosamente');
              $('#Modal').modal('hide');

            } else {
              alertify.error('Error al ' + comentario2);
            }

          }
        });

      } else {
        $('#estacionName').css('border', '2px solid #A52525');
      }

    }


    //---------- AGREGAR PROVEEDOR (SERVER) ----------//
    function AgregarProveedor(idReporte) {

      var RazonSocial = $('#RazonSocial').val();
      var Direccion = $('#Direccion').val();
      var Contacto = $('#Contacto').val();
      var Email = $('#Email').val();

      if (RazonSocial != "") {
        $('#RazonSocial').css('border', '');
        if (Direccion != "") {
          $('#Direccion').css('border', '');
          if (Contacto != "") {
            $('#Contacto').css('border', '');
            if (Email != "") {
              $('#Email').css('border', '');


              var parametros = {
                "idReporte": idReporte,
                "RazonSocial": RazonSocial,
                "Direccion": Direccion,
                "Contacto": Contacto,
                "Email": Email
              };

              $.ajax({
                data: parametros,
                url: '../../public/orden-compra/modelo/agregar-proveedor.php',
                type: 'post',
                beforeSend: function () {
                },
                complete: function () {

                },
                success: function (response) {

                  if (response == 1) {

                    //ContenidoProveedor(idReporte)
                    //ContenidoArticulos(idReporte)
                    //alertify.success('Proveedor agregado exitosamente')
                    $('#Modal').modal('hide');
                    window.location.reload();

                  } else {
                    alertify.error('Error al agregar');
                  }

                }
              });


            } else {
              $('#Email').css('border', '2px solid #A52525');
            }
          } else {
            $('#Contacto').css('border', '2px solid #A52525');
          }
        } else {
          $('#Direccion').css('border', '2px solid #A52525');
        }
      } else {
        $('#RazonSocial').css('border', '2px solid #A52525');
      }

    }

    //---------- EDITAR PROVEEDOR (SERVER) ----------//
    function EditarProveedor(idProveedor, idReporte) {

      var RazonSocial = $('#RazonSocial').val();
      var Direccion = $('#Direccion').val();
      var Contacto = $('#Contacto').val();
      var Email = $('#Email').val();

      if (RazonSocial != "") {
        $('#RazonSocial').css('border', '');
        if (Direccion != "") {
          $('#Direccion').css('border', '');
          if (Contacto != "") {
            $('#Contacto').css('border', '');
            if (Email != "") {
              $('#Email').css('border', '');

              var parametros = {
                "idProveedor": idProveedor,
                "RazonSocial": RazonSocial,
                "Direccion": Direccion,
                "Contacto": Contacto,
                "Email": Email
              };

              $.ajax({
                data: parametros,
                url: '../../public/orden-compra/modelo/editar-proveedor.php',
                type: 'post',
                beforeSend: function () {
                },
                complete: function () {

                },
                success: function (response) {

                  if (response == 1) {
                    ContenidoProveedor(idReporte)
                    ContenidoArticulos(idReporte)
                    alertify.success('Proveedor editado exitosamente')

                    $('#Modal').modal('hide');

                  } else {
                    alertify.error('Error al agregar');
                  }

                }
              });



            } else {
              $('#Email').css('border', '2px solid #A52525');
            }
          } else {
            $('#Contacto').css('border', '2px solid #A52525');
          }
        } else {
          $('#Direccion').css('border', '2px solid #A52525');
        }
      } else {
        $('#RazonSocial').css('border', '2px solid #A52525');
      }

    }

    //---------- ELIMINAR PROVEEDOR (SERVER) ----------//
    function EliminarProveedor(id, idReporte) {
      alertify.confirm('',
        function () {

          var parametros = {
            "idReporte": idReporte,
            "id": id
          };

          $.ajax({
            data: parametros,
            url: '../../public/orden-compra/modelo/eliminar-proveedor.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {


                //ContenidoProveedor(idReporte)
                //ContenidoArticulos(idReporte)
                //alertify.success('Proveedor eliminado exitosamente')

                $('#Modal').modal('hide');
                window.location.reload();

              } else {
                alertify.error('Error al eliminar');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar el proveedor?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();
    }



    //---------- EDITAR SEL PROVEEDOR (SERVER) ----------//  
    function SelProveedor(idReporte, idProveedor, categoria, valor) {


      if (categoria == 1) {

        if (document.getElementById('Proveedor' + idProveedor).checked) {
          valor = 1;
        } else {
          valor = 0;
        }

      } else {
        valor = valor;
      }

      var parametros = {
        "idReporte": idReporte,
        "idProveedor": idProveedor,
        "valor": valor
      };


      $.ajax({
        data: parametros,
        url: '../../public/orden-compra/modelo/seleccionar-estacion-orden.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            alertify.success('Proveedor seleccionado exitosamente');
            ContenidoRefacturacion(<?= $GET_idReporte; ?>)


          } else {
            alertify.error('Error al seleccionar el proveedor');

          }

        }
      });


    }


    //---------- AGREGAR PRODUCTO PROVEEDOR (SERVER) ----------//  
    function AgregarArticulo(idReporte) {

      var Proveedor = $('#Proveedor').val();
      var Concepto = $('#Concepto').val();
      var Unidades = $('#Unidades').val();
      var EstatusR = $('#EstatusR').val();
      var PrecioUnitario = $('#PrecioUnitario').val();

      if (Proveedor != "") {
        $('#Proveedor').css('border', '');

        if (Concepto != "") {
          $('#Concepto').css('border', '');

          if (Unidades != "") {
            $('#Unidades').css('border', '');

            if (EstatusR != "") {
              $('#EstatusR').css('border', '');

              if (PrecioUnitario != "") {
                $('#PrecioUnitario').css('border', '');

                alertify.confirm('',
                  function () {

                    var parametros = {
                      "idReporte": idReporte,
                      "Proveedor": Proveedor,
                      "Concepto": Concepto,
                      "Unidades": Unidades,
                      "EstatusR": EstatusR,
                      "PrecioUnitario": PrecioUnitario
                    };

                    $.ajax({
                      data: parametros,
                      url: '../../public/orden-compra/modelo/agregar-articulo.php',
                      type: 'post',
                      beforeSend: function () {
                      },
                      complete: function () {

                      },
                      success: function (response) {

                        if (response == 1) {

                          ContenidoArticulos(idReporte);
                          $('#Modal').modal('hide');

                        } else {
                          alertify.error('Error al agregar');
                        }

                      }
                    });

                  },
                  function () {

                  }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea agregar el articulo a la lista?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

              } else {
                $('#PrecioUnitario').css('border', '2px solid #A52525');
              }
            } else {
              $('#EstatusR').css('border', '2px solid #A52525');
            }
          } else {
            $('#Unidades').css('border', '2px solid #A52525');
          }
        } else {
          $('#Concepto').css('border', '2px solid #A52525');
        }
      } else {
        $('#Proveedor').css('border', '2px solid #A52525');
      }

    }


    //---------- ELIMINAR PRODUCTO PROVEEDOR (SERVER) ----------//  

    function Eliminar(id, idReporte) {

      alertify.confirm('',
        function () {

          var parametros = {
            "idReporte": idReporte,
            "id": id
          };

          $.ajax({
            data: parametros,
            url: '../../public/orden-compra/modelo/eliminar-articulo.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {

                ContenidoArticulos(idReporte);
                $('#Modal').modal('hide');

              } else {
                alertify.error('Error al eliminar');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar el articulo de la lista?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

    }

    //---------- AGREGAR REFACTURACION (SERVER) ----------//   
    function AgregarRefacturacion(idReporte) {

      var Estacion = $('#Estacion').val();
      var Descripcion = $('#Descripcion').val();
      var Cantidad = $('#Cantidad').val();
      var Importe = $('#Importe').val();
      var Porcentaje = $('#Porcentaje').val();
      var CantidadES = $('#CantidadES').val();
      var CantidadAl = $('#CantidadAl').val();

      if (Estacion != "") {
        $('#Estacion').css('border', '');

        if (Descripcion != "") {
          $('#Descripcion').css('border', '');

          if (Cantidad != "") {
            $('#Cantidad').css('border', '');

            if (Importe != "") {
              $('#Importe').css('border', '');

              alertify.confirm('',
                function () {

                  var parametros = {
                    "idReporte": idReporte,
                    "Estacion": Estacion,
                    "Descripcion": Descripcion,
                    "Cantidad": Cantidad,
                    "Importe": Importe,
                    "Porcentaje": Porcentaje,
                    "CantidadES": CantidadES,
                    "CantidadAl": CantidadAl
                  };

                  $.ajax({
                    data: parametros,
                    url: '../../public/orden-compra/modelo/agregar-refacturacion.php',
                    type: 'post',
                    beforeSend: function () {
                    },
                    complete: function () {

                    },
                    success: function (response) {

                      if (response == 1) {

                        ContenidoRefacturacion(idReporte);
                        $('#Modal').modal('hide');

                      } else {
                        alertify.error('Error al agregar');
                      }

                    }
                  });

                },
                function () {

                }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea agregar el articulo a la lista?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();



            } else {
              $('#Importe').css('border', '2px solid #A52525');
            }

          } else {
            $('#Cantidad').css('border', '2px solid #A52525');
          }

        } else {
          $('#Descripcion').css('border', '2px solid #A52525');
        }

      } else {
        $('#Estacion').css('border', '2px solid #A52525');
      }

    }


    //---------- ELIMINAR REFACTURACION (SERVER) ----------//   
    function EliminarRefacturacion(id, idReporte) {

      alertify.confirm('',
        function () {

          var parametros = {
            "idReporte": idReporte,
            "id": id
          };

          $.ajax({
            data: parametros,
            url: '../../public/orden-compra/modelo/eliminar-refacturacion.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {

                ContenidoRefacturacion(idReporte);
                $('#Modal').modal('hide');

              } else {
                alertify.error('Error al eliminar');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la refacturación?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();


    }


    //---------- FINALIZAR REPORTE (SERVER) ----------// 
    function Finalizar(idReporte, tipoFirma) {

      var ctx = document.getElementById("canvas");
      var image = ctx.toDataURL();
      document.getElementById('base64').value = image;
      var base64 = $('#base64').val();
      var canvas = $('#canvas').val();

      var data = new FormData();
      var url = '../../public/orden-compra/modelo/finalizar-orden-compra.php';

      data.append('idReporte', idReporte);
      data.append('tipoFirma', tipoFirma);
      data.append('base64', base64);

      alertify.confirm('',
        function () {

          $(".LoaderPage").show();

          $.ajax({
            url: url,
            type: 'POST',
            contentType: false,
            data: data,
            processData: false,
            cache: false
          }).done(function (data) {

            if (data == 1) {
              Regresar();
            } else {
              $(".LoaderPage").hide();
              alertify.error('Error al finalizar');
            }

          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea finalizar la orden de compra?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();


    }


    //---------- EDITAR FORMATO (SERVER) ----------// 
    function editarOC(e, id, num) {

      var valor = e.value;

      var parametros = {
        "valor": valor,
        "id": id,
        "num": num
      };


      $.ajax({
        data: parametros,
        url: '../../public/orden-compra/modelo/editar-formato-orden-compra.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {

            if (num == 1) {
              alertify.success('Cargo actualizado exitosamente')

            } else if (num == 2) {
              alertify.success('Fecha actualizada exitosamente')

            } else if (num == 3) {
              alertify.success('Porcentaje de refacturación actualizado exitosamente')

            }

          } else {
            alertify.error('Error al editar')

          }

        }
      });

    }


    function costosProveedor(idProveedor, num) {


      if (num == 1) {
        var valor = $('#descuento' + idProveedor).val();
        var mensaje = "Descuento actualizado exitosamente";

      } else if (num == 2) {
        var valor = $('#envio' + idProveedor).val();
        var mensaje = "Envio actualizado exitosamente";

      }

      var parametros = {
        "idProveedor": idProveedor,
        "valor": valor,
        "num": num
      };


      $.ajax({
        data: parametros,
        url: '../../public/orden-compra/modelo/agregar-compra-descuento.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            ContenidoArticulos(<?= $GET_idReporte; ?>)
            alertify.success(mensaje)

          } else {
            alertify.error('Error al agregar');
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
    <div class="contendAG container">
      <div class="row">
        <div class="col-12 mb-3">
          <div class="cardAG">
            <div class="border-0 p-3">
              <div class="row">
                <div class="col-12">
                  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
                    <ol class="breadcrumb breadcrumb-caret">
                      <li class="breadcrumb-item"><a onclick="history.back()"
                          class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i>
                          Orden de Compra</a></li>
                      <li aria-current="page" class="breadcrumb-item active">FORMULARIO ORDEN DE COMPRA</li>
                    </ol>
                  </div>

                  <div class="row">
                    <div class="col-12">
                      <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Formulario
                        Orden de Compra</h3>
                    </div>
                  </div>

                  <hr>
                </div>

                <div class="col-12 mb-2">
                  <h6>INFORMACIÓN GENERAL</h6>
                </div>


                <div class="table-responsive">
     <table class="table table-sm table-bordered" style="font-size: .9em;">
    <tr>
      <td colspan="3" class="align-middle">Dep. Almacén</td>

      <td rowspan="3" class="text-center align-middle"><h5>ORDEN DE COMPRA</h5></td>
      <td class="align-middle">Cargo:</td>
      <td class="p-0"><input type="text" class="form-control rounded-0 border-0" value="<?=$cargo;?>" id="cargo" onchange="editarOC(this,<?=$GET_idReporte?>,1)"></td>
    </tr>
    <tr>
      <td colspan="3" class="align-middle">Ref. Operativa</td>
      <td class="align-middle">Fecha:</td>
      <td class="p-0"><input type="date" class="form-control rounded-0 border-0" value="<?=$Fecha;?>" id="fecha" onchange="editarOC(this,<?=$GET_idReporte?>,2)"> </td>
    </tr>
    <tr>
      <td class="align-middle"><b>Refacturación</b></td>
      <td class="p-0"><input type="number" class="form-control rounded-0 border-0" value="<?=$porcentaje_total;?>" id="porcentajeT" onchange="editarOC(this,<?=$GET_idReporte?>,3)"></td>
      <td class="align-middle text-center"><b>%</b></td>

      <td class="align-middle">No. De control:</td>
      <td class="align-middle"><b>00<?=$no_control?></b></td>
    </tr>     
   </table>
  </div>



                <!---------- TABLA ORDEN DE COMPRA Y AGREGAR ESTACION ---------->
                <div class="col-12">
                  <div id="ContenidoEstaciones"></div>
                </div>

                <!---------- TABLA AGREGAR PROVEEDOR ---------->
                <div class="col-12 mb-3">
                  <div class="row">
                    <div class="col-12">
                      <hr>
                      <button type="button" class="btn btn-labeled2 btn-primary float-end"
                        onclick="ModalProveedor(<?= $GET_idReporte; ?>)">
                        <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar proveedor</button>
                    </div>
                  </div>
                  <div id="ContenidoProveedor"></div>
                </div>

                <?php
                $sql_proveedor = "SELECT * FROM op_orden_compra_proveedor WHERE id_ordencompra = '" . $GET_idReporte . "' ";
                $result_proveedor = mysqli_query($con, $sql_proveedor);
                $numero_proveedor = mysqli_num_rows($result_proveedor);

                if ($numero_proveedor > 2) {
                  $ocultarM = "";
                } else {
                  $ocultarM = "d-none";
                }

                ?>
                <div class="col-12 mb-3 <?= $ocultarM ?>">

                  <div class="row">
                    <div class="col-12">
                      <hr>
                      <button type="button" class="btn btn-labeled2 btn-primary float-end"
                        onclick="Producto(<?= $GET_idReporte; ?>)">
                        <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar articulo</button>
                    </div>
                  </div>
                </div>

                <div class="col-12 mb-3 <?= $ocultarM ?>">
                  <div id="ContenidoArticulos"></div>
                </div>

                <div class="col-12 mb-3 <?= $ocultarM ?>">
                  <div class="row">
                    <div class="col-12">
                      <hr>
                      <button type="button" class="btn btn-labeled2 btn-primary float-end"
                        onclick="Refacturacion(<?= $GET_idReporte; ?>)">
                        <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar refacturación</button>
                    </div>
                  </div>
                </div>

                <div class="col-12 mb-3 <?= $ocultarM ?>">
                  <div id="ContenidoRefacturacion"></div>
                </div>


                <div class="col-12 <?= $ocultarM ?>">
                  <?php if ($session_nompuesto == "Dirección de operaciones") { ?>
                    <hr>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                      <div class="table-responsive">
                        <table class="custom-table" style="font-size: .8em;" width="100%">
                          <thead class="tables-bg">
                            <tr>
                              <th class="text-center align-middle">Firma ELABORÓ</th>
                            </tr>
                          </thead>
                          <tbody class="bg-light">
                            <tr>
                              <td class="no-hover p-0">
                                <div id="signature-pad" class="signature-pad border-0" style="cursor:crosshair">
                                  <div class="signature-pad--body">
                                    <canvas style="width: 100%; height: 200px;" id="canvas"></canvas>
                                    <input type="hidden" name="base64" value="" id="base64">
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <th colspan="6" class="bg-danger text-white p-2" onclick="resizeCanvas()"><i
                                  class="fa-solid fa-arrow-rotate-left"></i> Limpiar firma</th>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                    </div>
                  <?php } ?>

                </div>

                <?php if ($session_nompuesto == "Dirección de operaciones") { ?>
                  <hr class="<?= $ocultarM ?>">
                  <div class="text-end <?= $ocultarM ?>">
                    <button type="button" class="btn btn-labeled2 btn-success float-end"
                      onclick="Finalizar(<?= $GET_idReporte; ?>,'A')">
                      <span class="btn-label2"><i class="fa fa-check"></i></span>Finalizar</button>
                  </div>
                <?php } ?>



              </div>

            </div>
          </div>
        </div>

      </div>
    </div>

  </div>


  <div class="modal" id="Modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div id="ContenidoModal"></div>
      </div>
    </div>
  </div>

  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalFinalizado">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">

          <h5 class="text-info">El token fue validado correctamente.</h5>
          <div class="text-secondary">La Orden de Compra fue firmada y finalizada.</div>


          <div class="text-end">
            <button type="button" class="btn btn-primary" onclick="Regresar()">Aceptar</button>
          </div>

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