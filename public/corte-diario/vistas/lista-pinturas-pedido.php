<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

?>

<div class="table-responsive">
	<table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
		<thead class="navbar-bg">
      <tr>
      <th class="text-center align-middle">#</th>
      <th class=" text-center align-middle">Unidad</th>
      <th class=" text-center align-middle">Nombre Producto</th>
      <th class="align-middle text-center">Piezas</th>
      <th class="align-middle text-center">¿Para que?</th>
      <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
      </tr>
    </thead>  
    <tbody class="bg-white">
    <?php
    $sql_lista = "SELECT * FROM op_pedido_pinturas_detalle WHERE id_pedido = '".$idReporte."' ";
    $result_lista = mysqli_query($con, $sql_lista);
    $numero_lista = mysqli_num_rows($result_lista);
    $ToPiezas=0;
    if ($numero_lista > 0) {
    $num = 1;
    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    $id = $row_lista['id'];


    $ToPiezas = $ToPiezas + $row_lista['piezas'];

    echo '<tr>';
    echo '<th class="align-middle text-center">'.$num.'</th>';
    echo '<td class="align-middle text-center">'.$row_lista['unidad'].'</td>';
    echo '<td class="align-middle text-center"><b>'.$row_lista['producto'].'</b></td>';
    echo '<td class="align-middle text-center p-0"><input id="Piezas-'.$id.'" class="form-control border-0 rounded-0 text-center" type="number" value="'.$row_lista['piezas'].'" onchange="EditPiezas('.$id.','.$idReporte.')" /></td>';
    echo '<td class="align-middle text-center p-0"><textarea rows="1" class="form-control p-1 border-0 rounded-0 text-center" onkeyup="EditDetalle(this,'.$id.','.$idReporte.')">'.$row_lista['detalle'].'</textarea></td>';
    echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarItem('.$id.','.$idReporte.')"></td>';
    echo '</tr>';

    $num++;
    }
    echo '<tr>
    <th colspan="3" class="text-end">Total piezas:</th>
    <td class="text-start" colspan="3"><b>'.$ToPiezas.'</b></td>
    
    </tr>';

    }else{
    echo "<tr><th colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
    }
    ?>
    </tbody>
    </table>
</div>

