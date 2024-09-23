<?php
require ('../../../app/help.php');

$idProveedor = $_GET['idProveedor'];

$sql_lista = "SELECT * FROM op_almacen_proveedores WHERE id = '" . $idProveedor . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {

  $folio = $row_lista['folio'];
  $fecha = FormatoFecha($row_lista['fecha']);
  $razon_social = $row_lista['razon_social'];
  $actividad_economica = $row_lista['actividad_economica'];
  $email = $row_lista['email'];
  $rfc = $row_lista['rfc'];
  $ciudad = $row_lista['ciudad'];

  $telefono_1 = $row_lista['telefono_1'];
  $telefono_2 = $row_lista['telefono_2'];
  $direccion = $row_lista['direccion'];
  $beneficiario = $row_lista['beneficiario'];
  $banco = $row_lista['banco'];

  $metodo_pago = $row_lista['metodo_pago'];
  $cfdi = $row_lista['cfdi'];
  $moneda = $row_lista['moneda'];
  $forma_pago = $row_lista['forma_pago'];
  $descripcion = $row_lista['descripcion'];

}

?>


<div class="modal-header">
  <h5 class="modal-title">Detalle del Proveedor</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">
  <div class="col-12 mb-2">
    <span class="badge bg-primary" style="font-size:0.9em">Información General:</span>
  </div>

  <div class="row">

    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">

      <div class="text-secondary fw-bold">FOLIO:</div>
      00<?= $folio; ?>

    </div>

    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">

      <div class="text-secondary fw-bold">FECHA:</div>
      <?= $fecha; ?>

    </div>

    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">

      <div class="text-secondary fw-bold">RAZÓN SOCIAL:</div>
      <?= $razon_social; ?>

    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
      <div class="text-secondary fw-bold">E-MAIL:</div>
      <?= $email; ?>
    </div>

    <div class="col-12 mb-2">

      <div class="text-secondary fw-bold">ACTIVIDAD ECONOMICA:</div>
      <?= $actividad_economica; ?>

    </div>
    <hr>
    <div class="col-12 mb-2">

      <div class="text-secondary fw-bold">RAZÓN SOCIAL:</div>
      <?= $rfc; ?>

    </div>

    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">

      <div class="text-secondary fw-bold">CIUDAD:</div>
      <?= $ciudad; ?>

    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-2">

      <div class="text-secondary fw-bold">TELEFONO 1:</div>
      <?= $telefono_1; ?>

    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-2">

      <div class="text-secondary fw-bold">TELEFONO 2:</div>
      <?= $telefono_2; ?>

    </div>

    <div class="col-12 mb-2">

      <div class="text-secondary fw-bold">NOMBRE DEL BENEFICIARIO:</div>
      <?= $beneficiario; ?>

    </div>

    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">

      <div class="text-secondary fw-bold">BANCO:</div>
      <?= $banco; ?>

    </div>

    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">

      <div class="text-secondary fw-bold">MÉTODO DE PAGO:</div>
      <?= $metodo_pago; ?>

    </div>

    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">

      <div class="text-secondary fw-bold">USO DEL CDFI:</div>
      <?= $cfdi; ?>

    </div>

    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">

      <div class="text-secondary fw-bold">MONEDA:</div>
      <?= $moneda; ?>

    </div>

    <div class="col-12 mb-2">

      <div class="text-secondary fw-bold">FORMA DE PAGO:</div>
      <?= $forma_pago; ?>

    </div>

    <div class="col-12 mt-3 mb-2">
      <span class="badge bg-primary" style="font-size:0.9em">PRODUCTOS O SERVICIOS OFRECIDOS:</span>
    </div>

    <div class="col-12 mb-2">

      <div class="text-secondary fw-bold">DESCRIPCIÓN:</div>
      <?= $descripcion; ?>
    </div>
  </div>

  <div class="table-responsive">
    <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
      <thead class="tables-bg">

        <th class="text-center align-middle">#</th>
        <th class="text-center align-middle">Documento</th>
        <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>

      </thead>
      <tbody class="bg-light">
        <?php
        $sql_detalle = "SELECT nombre, archivo FROM op_almacen_proveedores_documentos WHERE id_proveedor = " . $idProveedor . " ";
        $result_detalle = mysqli_query($con, $sql_detalle);
        $numero_detalle = mysqli_num_rows($result_detalle);
        if ($numero_detalle > 0) {
          $count = 1;
          while ($row_detalle = mysqli_fetch_array($result_detalle, MYSQLI_ASSOC)) {
            $nombre = $row_detalle['nombre'];
            $archivo = $row_detalle['archivo'];
            echo '<tr>';
            echo '<th class="align-middle text-center">' . $count . '</th>';
            echo '<td class="align-middle text-center">' . $nombre . '</td>';
            echo '<td class="align-middle text-center"> <a href="' . RUTA_ARCHIVOS . '/proveedores/' . $archivo . '" download><img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png" "></a></td>';
            echo '</tr>';
            $count++;
          }
        } else {
          echo "<tr><th colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>



</div>
</div>


</div>