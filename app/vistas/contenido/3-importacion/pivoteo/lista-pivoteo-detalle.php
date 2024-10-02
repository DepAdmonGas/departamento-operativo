<?php
require ('../../../../help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_pivoteo_detalle WHERE id_pivoteo = '" . $idReporte . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0){
echo '<div class="row">';

while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
$id = $row_lista['id'];
$id_pivoteo = $row_lista['id_pivoteo'];
$estacionfc = $row_lista['estacion_fc'];
$destinofc = $row_lista['destino_fc'];
$productofc = $row_lista['producto_fc'];
$tanquefc = $row_lista['tanque_fc'];
$facturafc = $row_lista['factura_fc'];
$litros = $row_lista['litros'];
$tad = $row_lista['tad'];
$unidad = $row_lista['unidad'];
$chofer = $row_lista['chofer'];
$estacionfn = $row_lista['estacion_fn'];
$destinofn = $row_lista['destino_fn'];
$tanquefn = $row_lista['tanque_fn'];
$facturafn = $row_lista['factura_fn'];


echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2 mt-1">';

  echo '<div class="table-responsive">
  <table id="tabla_bitacora" class="custom-table" style="font-size: 12.5px;" width="100%">';

    echo '
	<thead  class="bg-white">
	<tr class="tables-bg text-white text-center">
	<th width="50%" colspan="2">Documentación Facturada (CANCELAR)</th>
	<th width="50%" colspan="2">Documentación a refacturar</th>
	</tr>
	</thead>';

	echo '<tbody class="bg-white">';
    echo '<tr>
	<th class="no-hover">Estación:</th>
	<td class="no-hover">' . $estacionfc . '</td>
	<td class="no-hover"><b>Estación:</b></td>
	<td class="no-hover">' . $estacionfn . '</td>
	</tr>';

    echo '<tr>
	<th class="no-hover">Destino:</th>
	<td class="no-hover">' . $destinofc . '</td>
	<td class="no-hover"><b>Destino:</b></td>
	<td class="no-hover">' . $destinofn . '</td>
	</tr>';

    echo '<tr>
	<th class="no-hover">Producto:</th>
	<td class="no-hover">' . $productofc . '</td>
	<td class="no-hover"><b>Producto:</b></td>
	<td class="no-hover">' . $productofc . '</td>
	</tr>';

    echo '<tr>
	<th class="no-hover">Tanque:</th>
	<td class="no-hover">' . $tanquefc . '</td>
	<td class="no-hover"><b>Tanque:</b></td>
	<td class="no-hover">' . $tanquefn . '</td>
	</tr>';

    echo '<tr>
	<th class="no-hover">Factura:</th>
	<td class="no-hover">' . $facturafc . '</td>
	<td class="no-hover"><b>Factura:</b></td>
	<td class="no-hover">' . $facturafn . '</td>
	</tr>';

    echo '<tr>
	<th class="no-hover">Litros:</th>
	<td class="no-hover">' . number_format($litros, 2) . '</td>
	<td class="no-hover"><b>Litros:</b></td>
	<td class="no-hover">' . number_format($litros, 2) . '</td>
	</tr>';

    echo '<tr>
	<th class="no-hover">TAD:</th>
	<td class="no-hover">' . $tad . '</td>
	<td class="no-hover"><b>TAD:</b></td>
	<td class="no-hover">' . $tad . '</td>
	</tr>';

    echo '<tr>
	<th class="no-hover">Unidad:</th>
	<td class="no-hover">' . $unidad . '</td>
	<td class="no-hover"><b>Unidad:</b></td>
	<td class="no-hover">' . $unidad . '</td>
    </tr>';

    echo '<tr >
	<th class="no-hover">Chofer:</th>
	<td class="no-hover">' . $chofer . '</td>
	<td class="no-hover"><b>Chofer:</b></td>
	<td class="no-hover">' . $chofer . '</td>
	</tr>';

	echo '<tr>
	<th colspan="4" class="bg-danger text-white p-2" onclick="Eliminar(' . $idReporte . ',' . $id . ')"> Eiminar Registro</th>
	</tr>';

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';

}

echo '<div class="col-12">';
echo '<hr>

<button type="button" class="btn btn-labeled2 btn-success float-end" onclick="Finalizar('.$idReporte.')">
<span class="btn-label2"><i class="fa fa-check"></i></span>Finalizar</button>';
echo '</div>';

echo '</div>';


}else{

	echo '<header class="bg-light py-5">
    <div class="container px-5">
    <div class="row gx-5 align-items-center justify-content-center">
  
    <div class="col-xl-5 col-xxl-6 d-xl-block text-center">
    <img class="my-2" style="width: 100%" src="'.RUTA_IMG_ICONOS.'no-busqueda.png" width="50%">
    </div>
   
    <div class="col-lg-8 col-xl-7 col-xxl-6">
    <div class="my-2 text-center"> <h1 class="display-3 fw-bolder text-dark">No se encontró la información</h1> </div>
    </div>
    
    </div>
    </div>
    </header>';


}
  