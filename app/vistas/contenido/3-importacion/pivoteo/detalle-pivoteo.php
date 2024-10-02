<?php
require ('../../../../help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_pivoteo WHERE id = '" . $idReporte . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
$idestacion = $row_lista['id_estacion'];
$nocontrol = $row_lista['nocontrol'];
$fecha = $row_lista['fecha'];
$sucursal = $row_lista['sucursal'];
$causa = $row_lista['causa'];
$estatus = $row_lista['estatus'];
}

if($causa == ""){
$causa2 = "Sin información";
}else{
$causa2 = $causa;
}

?>
<div class="modal-header">
<h5 class="modal-title">Detalle pivoteo</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="table-responsive">
<table class="custom-table" style="font-size: 12.5px;" width="100%">

<tbody class="bg-light">
<tr>
<td class="align-middle no-hover2"><b>Depto. Operativo</b></td>
<td class="align-middle no-hover2 text-center" rowspan="3"><h5>Pivoteo</h5></td>
<td class="align-middle no-hover2 text-end"><b>Sucursal:</b></td>
<td class="align-middle no-hover2"><?= $sucursal; ?></td>
</tr>

<tr>
<th class="align-middle no-hover2" rowspan="2">G500 Network Operación y Finanzas</th>
<td class="align-middle no-hover2 text-end"><b>Fecha:</b></td>
<td class="align-middle no-hover2"><?=$ClassHerramientasDptoOperativo->FormatoFecha($fecha); ?></td>
</tr>

<tr>
<th class="align-middle no-hover2 text-end">No. De control:</th>
<td class="align-middle no-hover2">0<?= $nocontrol; ?></td>
</tr>

</tbody>
</table>
</div>


<div class="col-12">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 12.5px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">Causa:</th> </tr>
  </thead>
  <tbody class="bg-light">
  <tr>
  <th class="align-middle text-center no-hover2 fw-normal"><?=$causa2?></th>
  </tr>
  </tbody>
  </table>
  </div>
  <hr>
  </div>


    <?php
    $sql = "SELECT * FROM op_pivoteo_detalle WHERE id_pivoteo = '" . $idReporte . "' ";
    $result = mysqli_query($con, $sql);
    $numero = mysqli_num_rows($result);
    
    if ($numero_lista > 0){
    echo '<div class="row">';

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

        $id_pivoteo = $row['id_pivoteo'];
        $estacionfc = $row['estacion_fc'];
        $destinofc = $row['destino_fc'];
        $productofc = $row['producto_fc'];
        $tanquefc = $row['tanque_fc'];
        $facturafc = $row['factura_fc'];
        $litros = $row['litros'];
        $tad = $row['tad'];
        $unidad = $row['unidad'];
        $chofer = $row['chofer'];
        $estacionfn = $row['estacion_fn'];
        $destinofn = $row['destino_fn'];
        $tanquefn = $row['tanque_fn'];
        $facturafn = $row['factura_fn'];

        echo '<div class="col-12 mb-3">';

        echo '<div class="table-responsive">
        <table class="custom-table" style="font-size: 12.5px;" width="100%">';
      
          echo '
          <thead>
          <tr class="tables-bg text-white text-center">
          <th  colspan="2">Documentación Facturada (CANCELAR)</th>
          <th  colspan="2">Documentación a refacturar</th>
          </tr>
          </thead>';
      
          echo '<tbody class="bg-light">';
          echo '<tr>
          <th class="no-hover2">Estación:</th>
          <td class="no-hover2">' . $estacionfc . '</td>
          <td class="no-hover2"><b>Estación:</b></td>
          <td class="no-hover2">' . $estacionfn . '</td>
          </tr>';
      
          echo '<tr>
          <th class="no-hover2">Destino:</th>
          <td class="no-hover2">' . $destinofc . '</td>
          <td class="no-hover2"><b>Destino:</b></td>
          <td class="no-hover2">' . $destinofn . '</td>
          </tr>';
      
          echo '<tr>
          <th class="no-hover2">Producto:</th>
          <td class="no-hover2">' . $productofc . '</td>
          <td class="no-hover2"><b>Producto:</b></td>
          <td class="no-hover2">' . $productofc . '</td>
          </tr>';
      
          echo '<tr>
          <th class="no-hover2">Tanque:</th>
          <td class="no-hover2">' . $tanquefc . '</td>
          <td class="no-hover2"><b>Tanque:</b></td>
          <td class="no-hover2">' . $tanquefn . '</td>
          </tr>';
      
          echo '<tr>
          <th class="no-hover2">Factura:</th>
          <td class="no-hover2">' . $facturafc . '</td>
          <td class="no-hover2"><b>Factura:</b></td>
          <td class="no-hover2">' . $facturafn . '</td>
          </tr>';
      
          echo '<tr>
          <th class="no-hover2">Litros:</th>
          <td class="no-hover2">' . number_format($litros, 2) . '</td>
          <td class="no-hover2"><b>Litros:</b></td>
          <td class="no-hover2">' . number_format($litros, 2) . '</td>
          </tr>';
      
          echo '<tr>
          <th class="no-hover2">TAD:</th>
          <td class="no-hover2">' . $tad . '</td>
          <td class="no-hover2"><b>TAD:</b></td>
          <td class="no-hover2">' . $tad . '</td>
          </tr>';
      
          echo '<tr>
          <th class="no-hover2">Unidad:</th>
          <td class="no-hover2">' . $unidad . '</td>
          <td class="no-hover2"><b>Unidad:</b></td>
          <td class="no-hover2">' . $unidad . '</td>
          </tr>';
      
          echo '<tr >
          <th class="no-hover2">Chofer:</th>
          <td class="no-hover2">' . $chofer . '</td>
          <td class="no-hover2"><b>Chofer:</b></td>
          <td class="no-hover2">' . $chofer . '</td>
          </tr>';

          echo '</tbody>';
          echo '</table>';
          echo '</div>';
          echo '</div>';
      
    }
    

    echo '</div>';

}
    ?>


<div class="row">
<?php
$sql_firma = "SELECT * FROM op_pivoteo_firma WHERE id_pivoteo = '" . $idReporte . "' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while ($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)) {
$explode = explode(' ', $row_firma['fecha']);
$datosUsuario = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($row_firma['id_usuario']);
$NombreCompleto = $datosUsuario['nombre'];

if ($row_firma['tipo_firma'] == "A") {
$TipoFirma = "NOMBRE Y FIRMA DEL ENCARGADO";
$Detalle = '<img src="../../imgs/firma/' . $row_firma['firma'] . '" width="100%">';

} else if ($row_firma['tipo_firma'] == "B") {
$TipoFirma = "Depto Operativo";
$Detalle = '<div class="text-secondary fw-normal" style="font-size: 13px;" >El pivoteo se firmó por un medio electrónico.</br> <b>Fecha: ' . $ClassHerramientasDptoOperativo->FormatoFecha($explode[0]) . ', ' . date("g:i a", strtotime($explode[1])) . '</b></div>';

}else if ($row_firma['tipo_firma'] == "C") {
$TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
$Detalle = '<div class="text-secondary fw-normal" style="font-size: 13px;" >El pivoteo se firmó por un medio electrónico.</br> <b>Fecha: ' . $ClassHerramientasDptoOperativo->FormatoFecha($explode[0]) . ', ' . date("g:i a", strtotime($explode[1])) . '</b></div>';
}


echo '<div class="col-12">
<div class="table-responsive">
<table class="custom-table" style="font-size: 14px;" width="100%">
<thead class="tables-bg">
<tr> <th class="align-middle text-center">Atentamente</th> </tr>
</thead>
<tbody class="bg-light">
<tr>
<th class="align-middle text-center no-hover2">
'.$NombreCompleto. ' 
<br> <br>
'.$Detalle.'
'.$TipoFirma.'
</th>
</tr>
</tbody>
</table>
</div>
</div>';

}
?>

</div>
</div>