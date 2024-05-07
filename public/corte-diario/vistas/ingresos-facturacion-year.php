<?php
require 'app/vistas/contenido/header.php';
function IdReporte($Session_IDEstacion, $GET_year, $con)
{
  $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '" . $Session_IDEstacion . "' AND year = '" . $GET_year . "' ";
  $result_year = mysqli_query($con, $sql_year);
  while ($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)) {
    $idyear = $row_year['id'];
  }
  return $idyear;
}

$sqlE = "SELECT producto_tres FROM tb_estaciones WHERE id = '" . $Session_IDEstacion . "' ";
$resultE = mysqli_query($con, $sqlE);
$numeroE = mysqli_num_rows($resultE);
while ($row = mysqli_fetch_array($resultE, MYSQLI_ASSOC)) {
  $GDiesel = $row['producto_tres'];
}

$IdReporte = IdReporte($Session_IDEstacion, $GET_year, $con);

ValidaIF($IdReporte, 'G SUPER', 1, $con);
ValidaIF($IdReporte, 'G PREMIUM', 1, $con);

if ($GDiesel != "") {
  ValidaIF($IdReporte, 'G DIESEL', 1, $con);
}

ValidaIF($IdReporte, 'Aceites y Lubricantes', 1, $con);
if ($Session_IDEstacion == 2) {
  ValidaIF($IdReporte, 'Autolavado', 1, $con);
}
ValidaIF($IdReporte, 'Rentas', 1, $con);
ValidaIF($IdReporte, 'IEPS', 1, $con);

ValidaIF($IdReporte, 'Público en General', 2, $con);
ValidaIF($IdReporte, 'Clientes crédito', 2, $con);
ValidaIF($IdReporte, 'Monederos electronicos', 2, $con);
ValidaIF($IdReporte, 'Facturas aceites y lubricantes', 2, $con);
//ValidaIF($IdReporte,'Rentas',2,$con);
ValidaIF($IdReporte, 'Clientes débito', 2, $con);
ValidaIF($IdReporte, 'Ventas mostrador', 2, $con);
ValidaIF($IdReporte, 'TPV', 2, $con);
ValidaIF($IdReporte, 'Página WEB', 2, $con);
ValidaIF($IdReporte, 'Clientes débito', 2, $con);
//ValidaIF($idReporte,'Clientes anticipo',2,$con);


function ValidaIF($IdReporte, $detalle, $posicion, $con)
{

  $sql = "SELECT * FROM op_ingresos_facturacion_contabilidad WHERE id_year = '" . $IdReporte . "' AND detalle = '" . $detalle . "' AND posicion = '" . $posicion . "' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  if ($numero == 0) {

    $sql_insert = "INSERT INTO op_ingresos_facturacion_contabilidad  (
    id_year,
    detalle,
    posicion,
    enero,
    febrero,
    marzo,
    abril,
    mayo,
    junio,
    julio,
    agosto,
    septiembre,
    octubre,
    noviembre,
    diciembre
    )
    VALUES 
    (
    '" . $IdReporte . "',
    '" . $detalle . "',
    '" . $posicion . "',
    0,0,0,0,0,0,0,0,0,0,0,0  
    )";

    mysqli_query($con, $sql_insert);

  }
}
//---------------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------------

function IdReporteMes($IdYear, $GET_mes, $con)
{
  $idmes = 0;
  $sql_mes = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '" . $IdYear . "' AND mes = '" . $GET_mes . "' ";
  $result_mes = mysqli_query($con, $sql_mes);
  while ($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)) {
    $idmes = $row_mes['id'];
  }

  return $idmes;
}

UpdateIngresoFacturacion($IdReporte, 1, $con);
UpdateIngresoFacturacion($IdReporte, 2, $con);
UpdateIngresoFacturacion($IdReporte, 3, $con);
UpdateIngresoFacturacion($IdReporte, 4, $con);
UpdateIngresoFacturacion($IdReporte, 5, $con);
UpdateIngresoFacturacion($IdReporte, 6, $con);
UpdateIngresoFacturacion($IdReporte, 7, $con);
UpdateIngresoFacturacion($IdReporte, 8, $con);
UpdateIngresoFacturacion($IdReporte, 9, $con);
UpdateIngresoFacturacion($IdReporte, 10, $con);
UpdateIngresoFacturacion($IdReporte, 11, $con);
UpdateIngresoFacturacion($IdReporte, 12, $con);

function UpdateIngresoFacturacion($IdReporte, $mes, $con)
{

  $IdReporteMes = IdReporteMes($IdReporte, $mes, $con);

  $sql = "SELECT descripcion, total FROM op_control_volumetrico_prefijos WHERE id_mes = '" . $IdReporteMes . "' ";
  $result = mysqli_query($con, $sql);
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

    $descripcion = $row['descripcion'];
    $total = $row['total'];


    if ($descripcion == "PUBLICO EN GENERAL") {
      $descripcion = "Público en General";
    } else if ($descripcion == "CLIENTES DE CREDITO" || $descripcion == "Facturas de Crédito") {
      $descripcion = "Clientes crédito";
    } else if ($descripcion == "MONEDEROS") {
      $descripcion = "Monederos electronicos";
    } else if ($descripcion == "FACTURA DE ACEITES") {
      $descripcion = "Facturas aceites y lubricantes";
    } else if ($descripcion == "RENTAS") {
      $descripcion = "Rentas";
    } else if ($descripcion == "CLIENTES DE DEBITO") {
      $descripcion = "Clientes débito";
    } else if ($descripcion == "VENTA MOSTRADOR") {
      $descripcion = "Ventas mostrador";
    } else if ($descripcion == "TPV") {
      $descripcion = "TPV";
    } else if ($descripcion == "WEB") {
      $descripcion = "Página WEB";
    } else if ($descripcion == "CLIENTES ANTICIPO") {
      $descripcion = "Clientes anticipo";
    }

    $Mes = strtolower(nombremes($mes));

    $sql_edit3 = "UPDATE op_ingresos_facturacion_contabilidad SET 
    $Mes = '" . $total . "'
    WHERE id_year ='" . $IdReporte . "' AND detalle = '" . $descripcion . "' ";

    if (mysqli_query($con, $sql_edit3)) {
    }

  }

}

//-------------------------------------------------------------------------------------------------
UpdateProductoIF($IdReporte, 1, $con);
UpdateProductoIF($IdReporte, 2, $con);
UpdateProductoIF($IdReporte, 3, $con);
UpdateProductoIF($IdReporte, 4, $con);
UpdateProductoIF($IdReporte, 5, $con);
UpdateProductoIF($IdReporte, 6, $con);
UpdateProductoIF($IdReporte, 7, $con);
UpdateProductoIF($IdReporte, 8, $con);
UpdateProductoIF($IdReporte, 9, $con);
UpdateProductoIF($IdReporte, 10, $con);
UpdateProductoIF($IdReporte, 11, $con);
UpdateProductoIF($IdReporte, 12, $con);

function totalaceites($IdReporte, $noaceite, $con)
{
  $cantidad = 0;
  $sql_listaaceite = "SELECT * FROM op_corte_dia WHERE id_mes = '" . $IdReporte . "' ";
  $result_listaaceite = mysqli_query($con, $sql_listaaceite);
  while ($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)) {
    $id = $row_listaaceite['id'];
    $sql_listatotal = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '" . $id . "' AND id_aceite = '" . $noaceite . "' LIMIT 1 ";
    $result_listatotal = mysqli_query($con, $sql_listatotal);
    while ($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)) {
      $cantidad = $cantidad + $row_listatotal['cantidad'];
    }
  }

  return $cantidad;

}

function UpdateProductoIF($IdReporte, $mes, $con)
{

  $IdReporteMes = IdReporteMes($IdReporte, $mes, $con);
  $Mes = strtolower(nombremes($mes));

  $sql_lista = "SELECT * FROM op_control_volumetrico_resumen WHERE id_mes = '" . $IdReporteMes . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
    $id = $row_lista['id'];
    $producto = $row_lista['producto'];
    $dato10 = $row_lista['dato10'];

    $sql_edit1 = "UPDATE op_ingresos_facturacion_contabilidad SET 
    $Mes = '" . $dato10 . "'
    WHERE id_year ='" . $IdReporte . "' AND detalle = '" . $producto . "' ";

    if (mysqli_query($con, $sql_edit1)) {
    }

  }
  $TotAceites = 0;
  $Grantotal = 0;
  $sql_listaaceites = "SELECT * FROM op_aceites_lubricantes_reporte WHERE id_mes = '" . $IdReporteMes . "' ";
  $result_listaaceites = mysqli_query($con, $sql_listaaceites);
  while ($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)) {
    $noaceite = $row_listaaceites['id_aceite'];
    $preciou = $row_listaaceites['precio'];
    $totalaceites = totalaceites($IdReporteMes, $noaceite, $con);

    $Total = $preciou * $totalaceites;
    $TotAceites = $TotAceites + $totalaceites;
    $Grantotal = $Grantotal + $Total;
  }

  $sql_edit2 = "UPDATE op_ingresos_facturacion_contabilidad SET 
    $Mes = '" . $Grantotal . "'
    WHERE id_year ='" . $IdReporte . "' AND detalle = 'Aceites y Lubricantes' ";

  if (mysqli_query($con, $sql_edit2)) {
  }

}


?>
  <script type="text/javascript">
    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      IngresosFacturacion(<?= $IdReporte; ?>);
    });
    function IngresosFacturacion(idReporte) {
      $('#DivContenido').load('../public/corte-diario/vistas/concentrado-ingresos-facturacion.php?idReporte=' + idReporte);
    }
    function EditIF(idReporte, id, mes, posicion) {

      var valor = $('#D' + posicion + mes + id).val();

      var D1 = 0;
      var D2 = 0;
      var D3 = 0;
      var D4 = 0;
      var D5 = 0;
      var D6 = 0;
      var D7 = 0;
      var D8 = 0;
      var D9 = 0;
      var D10 = 0;
      var D11 = 0;
      var D12 = 0;

      var parametros = {
        "id": id,
        "mes": mes,
        "valor": valor,
        "accion" : "editar-ingreso-facturacion"
      };

      $.ajax({
        data: parametros,
        url: '../app/controlador/1-corporativo/controladorIngresos.php',
        //url: '../public/corte-diario/modelo/editar-ingreso-facturacion.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {
        },
        success: function (response) {
          if (response == 1) {
            if (posicion == 1) {
              D1 = $('#D11' + id).val();
              D2 = $('#D12' + id).val();
              D3 = $('#D13' + id).val();
              D4 = $('#D14' + id).val();
              D5 = $('#D15' + id).val();
              D6 = $('#D16' + id).val();
              D7 = $('#D17' + id).val();
              D8 = $('#D18' + id).val();
              D9 = $('#D19' + id).val();
              D10 = $('#D110' + id).val();
              D11 = $('#D111' + id).val();
              D12 = $('#D112' + id).val();

              if (D1 == "") { D1 = 0; } else { D1 = D1; }
              if (D2 == "") { D2 = 0; } else { D2 = D2; }
              if (D3 == "") { D3 = 0; } else { D3 = D3; }
              if (D4 == "") { D4 = 0; } else { D4 = D4; }
              if (D5 == "") { D5 = 0; } else { D5 = D5; }
              if (D6 == "") { D6 = 0; } else { D6 = D6; }
              if (D7 == "") { D7 = 0; } else { D7 = D7; }
              if (D8 == "") { D8 = 0; } else { D8 = D8; }
              if (D9 == "") { D9 = 0; } else { D9 = D9; }
              if (D10 == "") { D10 = 0; } else { D10 = D10; }
              if (D11 == "") { D11 = 0; } else { D11 = D11; }
              if (D12 == "") { D12 = 0; } else { D12 = D12; }

              Total = parseInt(D1) + parseInt(D2) + parseInt(D3) + parseInt(D4) + parseInt(D5) + parseInt(D6) + parseInt(D7) + parseInt(D8) + parseInt(D9) + parseInt(D10) + parseInt(D11) + parseInt(D12);

              $('#TE1' + id).text('$ ' + number_format(Total, 2, '.', ''));

              Totales(idReporte, id, mes, posicion);

            } else if (posicion == 2) {

              D1 = $('#D21' + id).val();
              D2 = $('#D22' + id).val();
              D3 = $('#D23' + id).val();
              D4 = $('#D24' + id).val();
              D5 = $('#D25' + id).val();
              D6 = $('#D26' + id).val();
              D7 = $('#D27' + id).val();
              D8 = $('#D28' + id).val();
              D9 = $('#D29' + id).val();
              D10 = $('#D210' + id).val();
              D11 = $('#D211' + id).val();
              D12 = $('#D212' + id).val();

              if (D1 == "") { D1 = 0; } else { D1 = D1; }
              if (D2 == "") { D2 = 0; } else { D2 = D2; }
              if (D3 == "") { D3 = 0; } else { D3 = D3; }
              if (D4 == "") { D4 = 0; } else { D4 = D4; }
              if (D5 == "") { D5 = 0; } else { D5 = D5; }
              if (D6 == "") { D6 = 0; } else { D6 = D6; }
              if (D7 == "") { D7 = 0; } else { D7 = D7; }
              if (D8 == "") { D8 = 0; } else { D8 = D8; }
              if (D9 == "") { D9 = 0; } else { D9 = D9; }
              if (D10 == "") { D10 = 0; } else { D10 = D10; }
              if (D11 == "") { D11 = 0; } else { D11 = D11; }
              if (D12 == "") { D12 = 0; } else { D12 = D12; }


              Total2 = parseInt(D1) + parseInt(D2) + parseInt(D3) + parseInt(D4) + parseInt(D5) + parseInt(D6) + parseInt(D7) + parseInt(D8) + parseInt(D9) + parseInt(D10) + parseInt(D11) + parseInt(D12);

              $('#TE2' + id).text('$ ' + number_format(Total2, 2, '.', ''));

              Totales(idReporte, id, mes, posicion);

            }



          } else {
            alertify.error('Error al agregar')
          }

        }
      });

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

    function Totales(idReporte, id, mes, posicion) {

      var parametros = {
        "idReporte": idReporte,
        "id": id,
        "mes": mes,
        "posicion": posicion
      };

      $.ajax({
        data: parametros,
        url: '../public/corte-diario/vistas/total-ingreso-facturacion.php',
        type: 'GET',
        dataType: 'json',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          $('#T11').text(response.TCE1);
          $('#T12').text(response.TCF1);
          $('#T13').text(response.TCM1);
          $('#T14').text(response.TCA1);
          $('#T15').text(response.TCMY1);
          $('#T16').text(response.TCJN1);
          $('#T17').text(response.TCJL1);
          $('#T18').text(response.TCAS1);
          $('#T19').text(response.TCS1);
          $('#T110').text(response.TCO1);
          $('#T111').text(response.TCN1);
          $('#T112').text(response.TCD1);
          $('#TF1').text(response.TCTEJ1);

          $('#T21').text(response.TCE2);
          $('#T22').text(response.TCF2);
          $('#T23').text(response.TCM2);
          $('#T24').text(response.TCA2);
          $('#T25').text(response.TCMY2);
          $('#T26').text(response.TCJN2);
          $('#T27').text(response.TCJL2);
          $('#T28').text(response.TCAS2);
          $('#T29').text(response.TCS2);
          $('#T210').text(response.TCO2);
          $('#T211').text(response.TCN2);
          $('#T212').text(response.TCD2);
          $('#TF2').text(response.TCTEJ2);


          $('#TD1').text(response.TD1);
          $('#TD2').text(response.TD2);
          $('#TD3').text(response.TD3);
          $('#TD4').text(response.TD4);
          $('#TD5').text(response.TD5);
          $('#TD6').text(response.TD6);
          $('#TD7').text(response.TD7);
          $('#TD8').text(response.TD8);
          $('#TD9').text(response.TD9);
          $('#TD10').text(response.TD10);
          $('#TD11').text(response.TD11);
          $('#TD12').text(response.TD12);
          $('#TDTE').text(response.TDTE);


        }
      });

    }

    function Entregables(IdReporte) {

      $('#Modal').modal('show');
      $('#DivContenidoModal').load('../public/corte-diario/vistas/modal-ingresos-facturacion-entregables.php?idReporte=' + IdReporte);

    }

    function GuardarArchivo(idReporte) {

      var data = new FormData();
      var url= '../app/controlador/1-corporativo/controladorIngresos.php';
      //var url = '../public/corte-diario/modelo/agregar-ingreso-facturacion-archivo.php';

      Archivo = document.getElementById("Archivo");
      Archivo_file = Archivo.files[0];
      Archivo_filePath = Archivo.value;

      if (Archivo_filePath != "") {
        $('#Archivo').css('border', '');

        data.append('idReporte', idReporte);
        data.append('Archivo_file', Archivo_file);
        data.append('accion','agregar-ingreso-facturacion-archivo');
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
            $(".LoaderPage").hide();
            alertify.success('Archivo guardado exitosamente.');
            $('#DivContenidoModal').load('../public/corte-diario/vistas/modal-ingresos-facturacion-entregables.php?idReporte=' + idReporte);

          } else {
            $(".LoaderPage").hide();
            alertify.error('Error al guardar el archivo.');
          }

        });

      } else {
        $('#Archivo').css('border', '2px solid #A52525');
      }
    }

    function EliminarDoc(id, idReporte) {

      var parametros = {
        "id": id,
        "accion" : "eliminar-ingreso-facturacion-archivo"
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: '../app/controlador/1-corporativo/controladorIngresos.php',
            //url: '../public/corte-diario/modelo/eliminar-ingresos-facturacion-entregables.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {
              console.log(response)
              if (response == 1) {
                alertify.success('Archivo eliminado exitosamente.');
                $('#DivContenidoModal').load('../public/corte-diario/vistas/modal-ingresos-facturacion-entregables.php?idReporte=' + idReporte);
              } else {
                alertify.error('Error al eliminar el archivo.');
              }
            }
          });
        },
        function () {
        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();
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
                <div class="col-11">
                  <img class="float-start pointer" src="<?= RUTA_IMG_ICONOS; ?>regresar.png" onclick="history.back()">
                  <div class="row">
                    <div class="col-12">
                      <h5>Ingresos VS Facturación <?= $GET_year; ?></h5>
                    </div>
                  </div>
                </div>
                <div class="col-1">
                  <img class="float-end pointer" src="<?= RUTA_IMG_ICONOS; ?>control-despacho.png" width="24px"
                    class="ml-2" onclick="Entregables(<?= $IdReporte; ?>)">
                </div>
              </div>
              <hr>
              <div id="DivContenido"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal" id="Modal">
    <div class="modal-dialog">
      <div class="modal-content" style="margin-top: 83px;">
        <div id="DivContenidoModal"></div>
      </div>
    </div>
  </div>
  
</body>

</html>