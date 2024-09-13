<?php
require ('../../../app/help.php');

$idReporte = $_GET['idReporte'];
$idEstacion = $_GET['idEstacion'];

$observaciones ='';

$sql_pedido = "SELECT * FROM op_pedido_pinturas_complementos WHERE id = '" . $idReporte . "' ";
$result_pedido = mysqli_query($con, $sql_pedido);
$numero_pedido = mysqli_num_rows($result_pedido);
while ($row_pedido = mysqli_fetch_array($result_pedido, MYSQLI_ASSOC)) {
  $estatus = $row_pedido['status'];
  $observaciones = $row_pedido['observaciones'];
}

if ($observaciones == ''):
  $observaciones = 'Sin observaciones';
endif;

$sql_productos = "SELECT * FROM tb_pinturas_lista ORDER BY producto ASC";
$result_productos = mysqli_query($con, $sql_productos);
$numero_productos = mysqli_num_rows($result_productos);


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
  <h5 class="modal-title">Detalle pedido pinturas</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
  <div class="table-responsive">
    <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
      <thead class="tables-bg">
        <tr>
          <th class="text-center align-middle">#</th>
          <th class=" text-center align-middle">Unidad</th>
          <th class=" text-center align-middle">Nombre producto</th>
          <th class="align-middle text-center">Piezas</th>
          <th class="align-middle text-center">¿Para que?</th>
        </tr>

      </thead>

      <tbody class="bg-light">
        <?php
        $sql_lista = "SELECT * FROM op_pedido_pinturas_detalle WHERE id_pedido = '" . $idReporte . "' ";
        $result_lista = mysqli_query($con, $sql_lista);
        $numero_lista = mysqli_num_rows($result_lista);
        $ToPiezas = 0;
        if ($numero_lista > 0) {
          $num = 1;
          while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
            $id = $row_lista['id'];

            $ToPiezas = $ToPiezas + $row_lista['piezas'];

            echo '<tr>';
            echo '<th class="align-middle text-center">' . $num . '</th>';
            echo '<td class="align-middle text-center">' . $row_lista['unidad'] . '</td>';
            echo '<td class="align-middle text-center">' . $row_lista['producto'] . '</td>';
            echo '<td class="align-middle text-center">' . $row_lista['piezas'] . '</td>';
            echo '<td class="align-middle text-center">' . $row_lista['detalle'] . '</td>';
            echo '</tr>';

            $num++;
          }
          echo '<tr>
                <th colspan="3" class="no-hover2 text-right">Total piezas:</th>
                <td colspan="2" class="no-hover2 text-start"><b>' . $ToPiezas . '</b></td>
              </tr>';

        } else {
          echo "<tr><td colspan='5' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <hr>
  <div class="text-secondary fw-bold ">OBSERVACIONES:</div><?=$observaciones?>
  <hr>

  <?php
  $sql_firma = "SELECT tipo_firma,firma,id_usuario,fecha FROM op_pedido_pinturas_complementos_firma WHERE id_pedido = ? ";
  $result_firma = $con->prepare($sql_firma);
  $result_firma->bind_param("i",$idReporte);
  $result_firma->execute();
  $result_firma->bind_result($tipo_firma,$firma,$usuario,$fecha);
  while($result_firma->fetch()):
    $firmas[] = array(
      'tipo_firma' => $tipo_firma,
      'firma' => $firma,
      'usuario' => $usuario,
      'fecha' => $fecha
  );
  endwhile;
  $result_firma->close();
?>
  <div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
      <div class="table-responsive">
        <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
            <?php
            $Detalle='';
            $firmamensaje ='';
            foreach ($firmas as $firma) :
              if ($firma['tipo_firma'] == "A"):
                $Detalle = '<th class="text-center no-hover2">
                              <img src="'.RUTA_IMG_Firma.'' . $firma['firma'] . '" width="70%">
                            </th>';
                $firmamensaje = '<tr> <th class="text-center no-hover2">' . Personal($firma['usuario'], $con) . '</th> </tr>';
              endif;
            endforeach;
            ?>
          <thead class="tables-bg">
            <tr>
              <th class="align-middle text-center"> NOMBRE Y FIRMA DEL ENCARGADO</th>
            </tr>
          </thead>
          <tbody class="bg-light">
            <tr>
              <?=$Detalle?>
            </tr>
            <?=$firmamensaje?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
      <div class="table-responsive">
        <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
            <?php
            $Detalle = '<td class="text-center no-hover2">Falta firma de visto bueno</td>';
            foreach ($firmas as $firma) :
              if ($tipo_firma == "B"):
                $explode = explode(' ', $fecha);
                $Detalle = '<td class="text-center no-hover2"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: ' . FormatoFecha($explode[0]) . ', ' . date("g:i a", strtotime($explode[1])) . '</b></small></td>
                <tr> <th class="text-center no-hover2">' . Personal($usuario, $con) . '</th> </tr>';
              endif;
            endforeach;
            ?>
          <thead class="tables-bg">
            <tr>
              <th class="align-middle text-center">NOMBRE Y FIRMA DE VOBO</th>
            </tr>
          </thead>
          <tbody class="bg-light">
            <tr>
              <?=$Detalle?>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>