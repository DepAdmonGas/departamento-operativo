<?php
require ('../../../../help.php');
$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_pivoteo_detalle WHERE id_pivoteo = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if($numero_lista > 0){

echo '<div class="row">';
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
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
  <table id="tabla_bitacora" class="custom-table" style="font-size: 0.9em;" width="100%">';

    echo '
	<thead  class="bg-white">
	<tr class="title-table-bg text-white text-center">
	<th width="50%" colspan="3">Documentación Facturada (CANCELAR)</th>
	<th width="50%" colspan="3">Documentación a refacturar</th>
	</tr>
	</thead>';

	echo '<tbody class="bg-white">';
    echo '<tr>
	<th class="no-hover">Estación:</th>
    <td class="no-hover">'.$estacionfc.'</td>
	<td class="no-hover" width="20px">
    <button type="button" class="btn btn-primary" onclick="ModalEditar('.$id.',1)"><i class="fa-solid fa-pencil"></i></span>
    </td>
	<td class="no-hover"><b>Estación:</b></td>
	<td class="no-hover">' . $estacionfn . '</td>
    <th class="no-hover" width="20px">
    <button type="button" class="btn btn-primary" onclick="ModalEditar('.$id.',2)"><i class="fa-solid fa-pencil"></i></span>
    </th>
	</tr>';

    echo '<tr>
	<th class="no-hover">Destino:</th>
	<td class="no-hover" colspan="2">' . $destinofc . '</td>
	<td class="no-hover"><b>Destino:</b></td>
	<td class="no-hover" colspan="2">' . $destinofn . '</td>
	</tr>';

    echo '<tr>
	<th class="no-hover">Producto:</th>
	<td class="no-hover p-0" colspan="2">
    <select class="form-select border-0 rounded-0" onchange="Editar(this,'.$id.',12)">
    <option>'.$productofc.'</option>
    <option>87 OCTANOS</option>
    <option>91 OCTANOS</option>
    <option>DIESEL</option>
    </select></td>
    </td>
	<td class="no-hover"><b>Producto:</b></td>
	<td class="no-hover" colspan="2"><div id="Producto'.$id.'">'.$productofc.'</div></td>
	</tr>';

    echo '<tr>
	<th class="no-hover">Tanque:</th>
	<td class="no-hover p-0" colspan="2">
    <select class="form-select border-0 rounded-0" id="Tanque" onchange="Editar(this,'.$id.',10)">
    <option>'.$tanquefc.'</option>
    <option>Pipa</option>
    <option>Tanque 1</option>
    <option>Tanque 2</option>
    </select>
    </td>
	<td class="no-hover"><b>Tanque:</b></td>
	<td class="no-hover" colspan="2"><div id="Tanque'.$id.'">'.$tanquefn.'</div></td>
	</tr>';

    echo '<tr>
	<th class="no-hover">Factura:</th>
	<td class="no-hover p-0" colspan="2">
    <input type="text" class="form-control border-0 rounded-0" value="'.$facturafc.'" onkeyup="Editar(this,'.$id.',1)">
    </td>
	<td class="no-hover"><b>Factura:</b></td>
	<td class="no-hover p-0" colspan="2">
    <input type="text" class="form-control border-0 rounded-0" value="'.$facturafn.'" onkeyup="Editar(this,'.$id.',2)">
    </td>
	</tr>';

    echo '<tr>
	<th class="no-hover">Litros:</th>
	<td class="no-hover p-0" colspan="2">
    <input type="number" class="form-control border-0 rounded-0" value="'.$litros.'" onkeyup="Editar(this,'.$id.',11)">
    </td>
	<td class="no-hover"><b>Litros:</b></td>
	<td class="no-hover" colspan="2"><div id="Litros'.$id.'">'.number_format($litros,2).'</div></td>
	</tr>';

    echo '<tr>
	<th class="no-hover">TAD:</th>
	<td class="no-hover p-0" colspan="2">
    <select class="form-select border-0 rounded-0" onchange="Editar(this,'.$id.',3)">
    <option>'.$tad.'</option>
    <option>Atlacomulco</option>
    <option>Tizayuca</option>
    <option>Tuxpan</option>
    <option>Puebla</option>
    <option>Vopack</option>
    </select>
    </td>
	<td class="no-hover"><b>TAD:</b></td>
	<td class="no-hover" colspan="2"><div id="TAD'.$id.'">'.$tad.'</div></td>
	</tr>';

    echo '<tr>
	<th class="no-hover">Unidad:</th>
	<td class="no-hover p-0" colspan="2">
    
    <select class="form-select border-0 rounded-0" onchange="Editar(this,'.$id.',4)">
    <option>'.$unidad.'</option>';

    $sql_unidades = "SELECT no_unidad FROM tb_unidades_transporte WHERE estado = 0 ORDER BY no_unidad ASC";
    $result_unidades = mysqli_query($con, $sql_unidades);
    $numero_unidades = mysqli_num_rows($result_unidades);

    while ($row_unidades = mysqli_fetch_array($result_unidades, MYSQLI_ASSOC)) {
    $no_unidad = $row_unidades['no_unidad'];
    echo '<option>' . $no_unidad . '</option>';
    }

    echo '</select>
    </td>
	<td class="no-hover"><b>Unidad:</b></td>
	<td class="no-hover" colspan="2"><div id="Unidad'.$id.'">'.$unidad.'</div></td>
    </tr>';

    echo '<tr >
	<th class="no-hover">Chofer:</th>
	<td class="no-hover p-0" colspan="2">
    
    <select class="form-select border-0 rounded-0" onchange="Editar(this,'.$id.',5)">
    <option>'.$chofer.'</option>';

    $sql_chofer = "SELECT nombre_chofer FROM tb_pivoteo_chofer WHERE estado = 0 ORDER BY nombre_chofer ASC";
    $result_chofer = mysqli_query($con, $sql_chofer);
    $numero_chofer = mysqli_num_rows($result_chofer);

    while ($row_chofer = mysqli_fetch_array($result_chofer, MYSQLI_ASSOC)) {
    $nombre_chofer = $row_chofer['nombre_chofer'];
    echo '<option>' . $nombre_chofer . '</option>';
    }
    echo '</select>
    </td>
	<td class="no-hover"><b>Chofer:</b></td>
	<td class="no-hover" colspan="2">' . $chofer . '</td>
	</tr>';

	echo '<tr>
	<th colspan="6" class="bg-danger text-white p-2" onclick="Eliminar('.$idReporte.','.$id.')"><i class="fa-regular fa-trash-can"></i> Eliminar Registro</th>
	</tr>';

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';

}
echo '</div>';

}else{

	echo '<header class="bg-white py-5 mb-3">
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

