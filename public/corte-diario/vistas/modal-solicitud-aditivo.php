<?php
require ('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_solicitud_aditivo WHERE id = '" . $idReporte . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $ordencompra = $row_lista['orden_compra'];
  $para = $row_lista['para'];
  $fecha = $row_lista['fecha'];
  $idpersonal = $row_lista['id_personal'];
  $fechaentrega = $row_lista['fecha_entrega'];
  $comentarios = $row_lista['comentarios'];
  $idestacion = $row_lista['id_estacion'];

}

function Personal($idusuario, $con)
{
  $sql = "SELECT nombre FROM tb_usuarios WHERE id = '" . $idusuario . "' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $nombre = $row['nombre'];
  }
  return $nombre;
}
?>
<div class="modal-header">
  <h5 class="modal-title">Solicitud de aditivo</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
  <div class="row">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1 mt-1">
      <span class="badge rounded-pill tables-bg float-start" style="font-size:14px">Fecha:
        <?= FormatoFecha($fecha); ?></span>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1 mt-1">
      <span class="badge rounded-pill tables-bg float-end" style="font-size:14px">No. Orden de Compra:
        <?= $ordencompra; ?></span>
    </div>

  </div>
  <div class="row">
    <div class="col-12 p-3">
      <div class="text-secondary fw-bold">PARA:</div>
      <?= $para ?>
    </div>
    <div class="col-12">
      <div class="text-secondary fw-bold">COMENTARIOS O INSTRUCCIONES ESPECIALES:</div>
      <textarea class="form-control rounded-0 p-1" rows="2" id="comentarios" style="font-size: 1em;"
        oninput="EditarSolicitud(this,<?= $idReporte; ?>,2)"><?= $comentarios; ?></textarea>
    </div>
  </div>
  <br>
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-1 mt-1">
  <div class="table-responsive">
    <table class="custom-table " style="font-size: .8em;" width="100%">
      <thead class="tables-bg">
        <tr>
          <th class="text-center align-middle tableStyle font-weight-bold">FECHA DE ENTREGA REQUERIDA</th>
          <th class="text-center align-middle tableStyle font-weight-bold">SOLICITADO POR</th>
        </tr>
      </thead>
      <tbody class="bg-light">
        <tr>
          <td class="p-0 text-center align-middle no-hover">
            <input type="date" class="form-control border-0 rounded-0 p-1" style="font-size: 1.1em;" id="FechaEntrega"
              oninput="EditarSolicitud(this,<?= $idReporte; ?>,4)" value="<?= $fechaentrega; ?>">
          </td>
          <td class="text-center align-middle no-hover">
            <b><?= Personal($idpersonal, $con) ?></b>
          </td>

        </tr>
      </tbody>
    </table>
  </div>
  </div>
  <br>
  <div class="row">
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
      <div class="text-secondary fw-bold">CANTIDAD:</div>
      <input type="number" class="form-control rounded-0" id="Cantidad" style="font-size: .8em;">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
    
    <div class="text-secondary fw-bold">PRODUCTO:</div>  
    <div class="input-group">
        <select id="Aditivo" class="form-select rounded-0" aria-describedby="button-addon2"
          style="font-size: .8em; width: auto;">
          <option></option>
          <option>GASOLINA</option>
          <option>DIESEL</option>
        </select>
      </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-4">
      <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="AgregarAditivo(<?= $idReporte ?>)">
        <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar
      </button>
    </div>
  </div>


  <br>
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
  <div class="table-responsive">
    <table class="custom-table " style="font-size: .8em;" width="100%">
      <thead class="tables-bg">
        <tr>
          <th class="text-center align-middle tableStyle font-weight-bold">CANTIDAD DE TAMBORES</th>
          <th class="text-center align-middle tableStyle font-weight-bold">NOMBRE DEL PRODUCTO</th>
          <th class="text-center align-middle tableStyle font-weight-bold">NOMBRE DEL ADITIVO</th>
          <th class="text-center align-middle tableStyle font-weight-bold">KILOGRAMOS POR TAMBOR</th>
          <th class="text-center align-middle tableStyle font-weight-bold">TOTAL KILOS</th>
          <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
        </tr>
      </thead>
      <tbody class="bg-light">
        <?php
        $sql_aditivo = "SELECT * FROM op_solicitud_aditivo_tambo WHERE id_reporte = '" . $idReporte . "' ";
        $result_aditivo = mysqli_query($con, $sql_aditivo);
        $numero_aditivo = mysqli_num_rows($result_aditivo);
        if ($numero_aditivo > 0) {
          while ($row_aditivo = mysqli_fetch_array($result_aditivo, MYSQLI_ASSOC)) {
            $id = $row_aditivo['id'];

            $totalkilogramos = $row_aditivo['cantidad'] * $row_aditivo['kilogramo'];

            echo '<tr>
                    <th class="text-center align-middle no-hover">' . $row_aditivo['cantidad'] . '</th>
                    <td class="text-center align-middle no-hover">' . $row_aditivo['producto'] . '</td>
                    <td class="text-center align-middle no-hover">' . $row_aditivo['aditivo'] . '</td>
                    <td class="text-center align-middle no-hover">' . $row_aditivo['kilogramo'] . '</td>
                    <td class="text-center align-middle no-hover" id="TK' . $id . '">' . $totalkilogramos . '</td>
                    <td class="align-middle text-center no-hover" width="20"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="EliminarTambo(' . $idReporte . ',' . $id . ')"></td>
                  </tr>';


          }
        } else {
          echo "<tr><th colspan='7' class='text-center text-secondary no-hover'><small>No se encontró información para mostrar </small></th></tr>";
        }

        ?>
      </tbody>
    </table>
  </div>
  </div>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-danger float-end m-2"
    onclick="Eliminar(<?= $idestacion ?>,<?= $idReporte ?>)">
    <span class="btn-label2"><i class="fa fa-x"></i></span>Cancelar</button>
  <button type="button" class="btn btn-labeled2 btn-success float-end m-2" onclick="Finalizar(<?= $idReporte ?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Finalizar</button>
</div>