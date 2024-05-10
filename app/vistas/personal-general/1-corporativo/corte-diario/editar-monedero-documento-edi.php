@ -1,86 +0,0 @@
<?php
require ('../../../../help.php');

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

<div class="text-center"><b><?= $monedero; ?></b> (Documentos EDI)</div>

<div class="mb-2 text-secondary">Complemento</div>
<select class="form-control" id="Complemento">
  <option></option>
  <option>Complemento 1</option>
  <option>Complemento 2</option>
</select>

<div class="mb-2 text-secondary">Agregar PDF</div>
<input type="file" id="PDF">
<div class="mb-2 text-secondary">Agregar XML</div>
<input type="file" id="XML">


<div class="text-right mt-3">
  <button type="button" class="btn btn-danger" onclick="Cancelar(<?= $IdReporte; ?>)">Cancelar</button>
  <button type="button" class="btn btn-primary" onclick="GuardarC(<?= $IdReporte; ?>,<?= $id; ?>)">Guardar</button>
</div>

<hr>

<table class="table table-sm table-bordered pb-0 mb-0 mt-2 font-weight-light">
  <thead>
    <th class="align-middle text-center">Complemento</th>
    <th class="align-middle text-center" width="24"><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>
    <th class="align-middle text-center" width="24"><img src="<?= RUTA_IMG_ICONOS; ?>xml.png"></th>

    <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
  </thead>
  <tbody>
    <?php
    if ($numero_lista1 > 0) {
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
        echo '<td class="align-middle text-center">' . $row_lista1['complemento'] . '</td>';
        echo '<td>'.$pdf.'</td>';
        echo '<td>'.$xml.'</td>';
        
        echo '<td width="20">' . $eliminar . '</td>';
        echo '</tr>';

      }
    } else {
      echo "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
    }
    ?>
  </tbody>
</table>