<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_pivoteo WHERE id = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$idestacion = $row_lista['id_estacion'];
$nocontrol = $row_lista['nocontrol'];
$fecha = $row_lista['fecha'];
$sucursal = $row_lista['sucursal'];
$causa = $row_lista['causa'];
$estatus = $row_lista['estatus'];
}

function Personal($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}

?>
<div class="modal-header">
<h5 class="modal-title">Detalle pivoteo</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

  <div class="modal-body">

<div class="table-responsive">
  <table class="table table-sm table-bordered mb-3">
  <tbody>
  <tr>
    <td class="align-middle"><b>Depto. Operativo</b></td>
    <td class="align-middle text-center" rowspan="3"><h5>Pivoteo</h5></td>
    <td class="align-middle text-end"><b>Sucursal:</b></td>
    <td class="align-middle"><?=$sucursal;?></td>
  </tr>
  <tr>
    <td class="align-middle" rowspan="2"><b>G500 Network Operación y Finanzas</b></td>
    <td class="align-middle text-end"><b>Fecha:</b></td>
    <td class="align-middle"><?=FormatoFecha($fecha);?></td>
  </tr>
  <tr>
    <td class="align-middle text-end"><b>No. De control:</b></td>
    <td>0<?=$nocontrol;?></td>
  </tr>
  </tbody>
  </table>
</div>

    <h6>Causa:</h6>
    <div class="p-2 border mb-3"><?=$causa;?></div>

    <?php
    $sql = "SELECT * FROM op_pivoteo_detalle WHERE id_pivoteo = '".$idReporte."' ";
    $result = mysqli_query($con, $sql);
    $numero = mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

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

    echo '<div class="table-responsive" >';

    echo '<table class="table table-sm table-bordered">';
    echo '<tbody>';
    echo '<tr class="tables-bg text-center ">
    <th width="50%" colspan="2">Documentación Facturada (CANCELAR)</th>
    <th width="50%" colspan="2">Documentación a refacturar</th>
    </tr>';

    echo '<tr>
    <td class="align-middle"><b>Estación:</b></td>
    <td>'.$estacionfc.'</td>
    <td class="align-middle"><b>Estación:</b></td>
    <td>'.$estacionfn.'</td>
    </tr>';

    echo '<tr>
    <td><b>Destino:</b></td>
    <td>'.$destinofc.'</td>
    <td><b>Destino:</b></td>
    <td>'.$destinofn.'</td>
    </tr>';

    echo '<tr>
    <td><b>Producto:</b></td>
    <td>'.$productofc.'</td>
    <td><b>Producto:</b></td>
    <td>'.$productofc.'</td>
    </tr>';

    echo '<tr>
    <td><b>Tanque:</b></td>
    <td>'.$tanquefc.'</td>
    <td><b>Tanque:</b></td>
    <td>'.$tanquefn.'</td>
    </tr>';

    echo '<tr>
    <td><b>Factura:</b></td>
    <td>'.$facturafc.'</td>
    <td><b>Factura:</b></td>
    <td>'.$facturafn.'</td>
    </tr>';

    echo '<tr>
    <td><b>Litros:</b></td>
    <td>'.number_format($litros,2).'</td>
    <td><b>Litros:</b></td>
    <td>'.number_format($litros,2).'</td>
    </tr>';

    echo '<tr>
    <td><b>TAD:</b></td>
    <td>'.$tad.'</td>
    <td><b>TAD:</b></td>
    <td>'.$tad.'</td>
    </tr>';

    echo '<tr>
    <td><b>Unidad:</b></td>
    <td>'.$unidad.'</td>
    <td><b>Unidad:</b></td>
    <td>'.$unidad.'</td>
    </tr>';

    echo '<tr>
    <td><b>Chofer:</b></td>
    <td>'.$chofer.'</td>
    <td><b>Chofer:</b></td>
    <td>'.$chofer.'</td>
    </tr>';

    echo '</tbody>';
    echo '</table>';
    echo '</div>';

    
}
?>


<div class="row">
<?php
$sql_firma = "SELECT * FROM op_pivoteo_firma WHERE id_pivoteo = '".$idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){

$TipoFirma = "NOMBRE Y FIRMA DEL ENCARGADO";
$Detalle = '<div class="border p-1 text-center">
<img src="../../imgs/firma/'.$row_firma['firma'].'" width="70%">
</div>';

}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "Depto Operativo";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>El pivoteo se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';

}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>El pivoteo se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}

echo '<div class="col-12">';
echo '<div class="border p-3">';
echo '<div class="text-center"><b>Atentamente</b></div>';
echo '<div class="mt-2 mb-2 text-center">'.Personal($row_firma['id_usuario'],$con).'</div>';
echo $Detalle;
echo '<h6 class="mt-2 text-secondary text-center">'.$TipoFirma.'</h6>';
echo '</div>';
echo '</div>';

}
?>
</div>
</div>

