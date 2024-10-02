<?php
require ('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '" . $idEstacion . "'";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
  $estacion = ' (' . $row_listaestacion['nombre'] . ')';
}

if ($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"):
  $estacion = '';
endif;

$sql_lista = "SELECT * FROM op_solicitud_aditivo WHERE id_estacion = '" . $idEstacion . "' ORDER BY orden_compra DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function ToComentarios($IdReporte, $con)
{
  $sql_lista = "SELECT id FROM op_solicitud_aditivo_comentario WHERE id_reporte = '" . $IdReporte . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  return $numero_lista = mysqli_num_rows($result_lista);
}

function Pago($id, $con)
{
  $sql_lista = "SELECT id FROM op_solicitud_aditivo_documento WHERE id_reporte = '" . $id . "' AND nombre = 'PAGO' ";
  $result_lista = mysqli_query($con, $sql_lista);
  return $numero_lista = mysqli_num_rows($result_lista);
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
<script type="text/javascript">
  $(document).ready(function ($) {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
    <ol class="breadcrumb breadcrumb-caret">
      <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
            class="fa-solid fa-house"></i> Comercializadora</a></li>
      <li aria-current="page" class="breadcrumb-item active text-uppercase"> Pedido de Aditivo<?= $estacion ?></li>
    </ol>
  </div>

  <div class="row">
    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
      <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Pedido de
        Aditivo<?= $estacion ?></h3>
    </div>
    <?php if ($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"): ?>
      <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
        <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Modal()">
          <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
      </div>
    <?php endif; ?>

  </div>

  <hr>
</div>


<div class="table-responsive">
  <table id="tabla_aditivo_<?=$idEstacion?>" class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="tables-bg">
      <tr>
        <th class="text-center align-middle">No. Orden</th>
        <th class="text-center align-middle">Fecha</th>
        <th class="text-center align-middle">Solicitado por</th>
        <th class="text-center align-middle">Para</th>
        <th class="text-center align-middle">Fecha entrega</th>
        <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>icon-comentario-tb.png"></th>
        <?php if ($session_nompuesto != "Encargado" && $session_nompuesto != "Asistente Administrativo"): ?>
          <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>icon-firmar-w.png"></th>
        <?php endif; ?>
        <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>

      </tr>
    </thead>
    <tbody class="bg-white">
      <?php
      $Y = date("Y");
      $M = date("m");

      if ($numero_lista > 0):
        $num = 1;
        $trColor = "";
        while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)):
          $id = $row_lista['id'];
          $ordencompra = $row_lista['orden_compra'];

          if ($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"):

            $Detalle = '<a class="dropdown-item" onclick="ModalDetalle(' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
            $Pago = '<a class="dropdown-item grayscale"><i class="fa-solid fa-dollar-sign"></i>Pago</a>';
            $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
            $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
            $Eliminar = '<a class="dropdown-item grayscale" ><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
            switch ($row_lista['status']) :
              case 0:
                $trColor = "background-color: #fcfcda";
                $Editar = '<a class="dropdown-item" onclick="Editar(' . $id . ')"><i class="fa-solid fa-pencil"></i> Editar</a>';
                $Eliminar = '<a class="dropdown-item" onclick="Eliminar(' . $idEstacion . ',' . $id . ')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
                break;
              case 1:
                $trColor = "background-color: #b0f2c2";
                $PDF = '<a class="dropdown-item" onclick="DescargarPDF(' . $id . ')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
                break;
            endswitch;
            $ToComentarios = ToComentarios($id, $con);
            $Nuevo = '';
            if ($ToComentarios > 0) :
              $Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">' . $ToComentarios . ' </span></span></div>';
              //$Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$ToComentarios.' </span></span></div>';
            endif;
          else:

            $pago = Pago($id, $con);

            $fechaMas = date("Y-m-d", strtotime($row_lista['fecha'] . "+ 15 days"));

            $fecha_actual = strtotime($fecha_del_dia);
            $fecha_entrada = strtotime($fechaMas);
            $PDF = '<a class="dropdown-item pointer" onclick="DescargarPDF(' . $id . ')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
            $Pago = '<a class="dropdown-item pointer" onclick="Pago(' . $idEstacion . ',' . $id . ')"><i class="fa-solid fa-money-bill"></i> Pago</a>';
            $Firmar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'icon-firmar.png" onclick="Firmar(' . $id . ')" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';           
            $Detalle = '<a class="dropdown-item" onclick="ModalDetalle(' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
            $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
            $Eliminar = '<a class="dropdown-item grayscale" ><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
            if($fecha_actual >= $fecha_entrada && $row_lista['status'] == 1):
              $trColor = "background-color: #cfe2ff";
            else:
              
              $trColor = "background-color: #b0f2c2";
                switch ($row_lista['status']):
                  case 0:
                    $trColor = "background-color: #fcfcda";
                    $Detalle = '<a class="dropdown-item grayscale"><i class="fa-regular fa-eye"></i> Detalle</a>';
                    $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
                    $Pago = '<a class="dropdown-item grayscale"><i class="fa-solid fa-money-bill"></i> Pago</a>';
                    $Firmar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'icon-firmar.png"" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';
                    break;
                endswitch;
            endif;
          endif;
          $ToComentarios = ToComentarios($id, $con);
          $Nuevo = '';
          if ($ToComentarios > 0):
            $Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">' . $ToComentarios . ' </span></span></div>';
            //$Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>' . $ToComentarios . '</small></span></div>';
          endif;


          echo '<tr style="' . $trColor . '">';
          echo '<th class="align-middle text-center">' . $ordencompra . '</th>';
          echo '<td class="align-middle text-center">' . FormatoFecha($row_lista['fecha']) . '</td>';
          echo '<td class="align-middle text-center">' . Personal($row_lista['id_personal'], $con) . '</td>';
          echo '<td class="align-middle text-center">' . $row_lista['para'] . '</td>';
          echo '<td class="align-middle text-center">' . FormatoFecha($row_lista['fecha_entrega']) . '</td>';
          echo '<td class="align-middle text-center position-relative" onclick="ModalComentario(' . $idEstacion . ',' . $id . ')">' . $Nuevo . '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'icon-comentario-tb.png" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
          //echo '<td class="align-middle text-center">' . $Nuevo . '<img class="pointer" width="20" src="' . RUTA_IMG_ICONOS . 'icon-comentario-tb.png" onclick="ModalComentario(' . $idEstacion . ',' . $id . ')" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
          if ($session_nompuesto != "Encargado" && $session_nompuesto != "Asistente Administrativo") :
            echo '<td class="align-middle text-center">' . $Firmar . '</td>';
          endif;
          echo '<td class="align-middle text-center">
                  <div class="dropdown">
                    <a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                      ' . $Detalle . '
                      ' . $PDF . '
                      ' . $Pago . '
                      ' . $Editar . '
                      ' . $Eliminar . '
                    </div>
                  </div>
                  </td>';
          echo '</tr>';

          $num++;
        endwhile;
      endif;
      ?>
    </tbody>
  </table>
</div>