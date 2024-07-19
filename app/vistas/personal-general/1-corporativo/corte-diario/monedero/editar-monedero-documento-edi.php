<?php
require ('../../../../../help.php');

$IdReporte = $_GET['IdReporte'];
$id = $_GET['id'];

$sql_lista = "SELECT * FROM op_monedero_documento WHERE id = '" . $id . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $fecha = $row_lista['fecha'];
  $monedero = $row_lista['monedero'];
  $diferencia = $row_lista['diferencia'];
}

$sql_lista1 = "SELECT * FROM op_monedero_edi WHERE id_documento = '" . $id . "' ORDER BY id desc";
$result_lista1 = mysqli_query($con, $sql_lista1);
$numero_lista1 = mysqli_num_rows($result_lista1);
?>


<div class="modal-header">
<h5 class="modal-title">Facturas</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="text-start"><b><?= $monedero; ?></b> (Documentos EDI)</div>

<div class="mb-2 text-secondary">Complemento</div>
<select class="form-select" id="Complemento">
  <option></option>
  <option>Complemento 1</option>
  <option>Complemento 2</option>
</select>

<div class="mb-1 mt-2 text-secondary">Agregar PDF</div>
<input type="file" id="PDF" class="form-control">

<div class="mb-1 mt-2 text-secondary">Agregar XML</div>
<input type="file" id="XML" class="form-control">

<hr>

<div class="table-responsive">
<table class="custom-table" style="font-size: 14px;" width="100%">

<thead class="tables-bg">
  <th class="align-middle text-center">No.</th>
    <th class="align-middle text-center">Complemento</th>
    <th class="align-middle text-center" width="24"><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>
    <th class="align-middle text-center" width="24"><img src="<?= RUTA_IMG_ICONOS; ?>xml.png"></th>

    <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
  </thead>

  <tbody class="bg-light">
    <?php
    if ($numero_lista1 > 0) {
    $num = 1;

      while ($row_lista1 = mysqli_fetch_array($result_lista1, MYSQLI_ASSOC)) {
        if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Dirección de operaciones servicio social") {
          $eliminar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="EliminarEdi(' . $IdReporte . ',' . $id . ',' . $row_lista1['id'] . ')">';
        } else {
          $eliminar = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" >';
        }
        if($row_lista1['pdf'] != ""){
          $pdf = '<a href="../../archivosr/'.$row_lista1['pdf'].'" download><img src="'.RUTA_IMG_ICONOS.'pdf.png"></a>';
        }else{
          $pdf =  '<img src="'.RUTA_IMG_ICONOS.'eliminar.png"></a>';
        }
        if($row_lista1['xml'] != ""){
          $xml =  '<a href="../../archivos/'.$row_lista1['xml'].'" download><img src="'.RUTA_IMG_ICONOS.'xml.png"></a>';
        }
        else{
          $xml = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png"></a>';
        }
        echo '<tr>';
        echo '<th class="align-middle text-center">'.$num.'</th>';
        echo '<td class="align-middle text-center">' . $row_lista1['complemento'] . '</td>';
        echo '<td>'.$pdf.'</td>';
        echo '<td>'.$xml.'</td>';
        
        echo '<td width="20">' . $eliminar . '</td>';
        echo '</tr>';
        $num++;
      }
    } else {
      echo "<tr><th colspan='7' class='text-center text-secondary fw-normal no-hover2'><small>No se encontró información para mostrar </small></th></tr>";
    }
    ?>
  </tbody>
</table>
</div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-danger float-end m-2" onclick="Cancelar(<?= $IdReporte; ?>)">
          <span class="btn-label2"><i class="fa fa-x"></i></span>Cancelar</button>
        <button type="button" class="btn btn-labeled2 btn-success float-end m-2" onclick="GuardarC(<?= $IdReporte; ?>,<?= $id; ?>)">
          <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>

</div>