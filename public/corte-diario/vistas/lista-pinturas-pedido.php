<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

?>

<div class="table-responsive">
      <table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
       <thead class="tables-bg">
      <tr>
      <td class="text-center align-middle tableStyle font-weight-bold"><b>#</b></td>
      <td class=" text-center align-middle tableStyle font-weight-bold"><b>Unidad</b></td>
      <td class=" text-center align-middle tableStyle font-weight-bold"><b>Nombre Producto</b></td>
      <td class="align-middle tableStyle font-weight-bold text-center"><b>Piezas</b></td>
      <td class="align-middle tableStyle font-weight-bold text-center"><b>¿Para que?</b></td>
      <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
      </tr>
    </thead>  
    <tbody>
    <?php
    $sql_lista = "SELECT * FROM op_pedido_pinturas_detalle WHERE id_pedido = '".$idReporte."' ";
    $result_lista = mysqli_query($con, $sql_lista);
    $numero_lista = mysqli_num_rows($result_lista);

    if ($numero_lista > 0) {
    $num = 1;
    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    $id = $row_lista['id'];


    $ToPiezas = $ToPiezas + $row_lista['piezas'];

    echo '<tr>';
    echo '<td class="align-middle text-center">'.$num.'</td>';
    echo '<td class="align-middle text-center">'.$row_lista['unidad'].'</td>';
    echo '<td class="align-middle text-center"><b>'.$row_lista['producto'].'</b></td>';
    echo '<td class="align-middle text-center p-0"><input id="Piezas-'.$id.'" class="form-control border-0 rounded-0 text-center" type="number" value="'.$row_lista['piezas'].'" onchange="EditPiezas('.$id.','.$idReporte.')" /></td>';
    echo '<td class="align-middle text-center p-0"><textarea rows="1" class="form-control p-1 border-0 rounded-0 text-center" onkeyup="EditDetalle(this,'.$id.','.$idReporte.')">'.$row_lista['detalle'].'</textarea></td>';
    echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarItem('.$id.','.$idReporte.')"></td>';
    echo '</tr>';

    $num++;
    }
    echo '<tr>
    <td colspan="3" class="text-end"><b>Total piezas:</b></td>
    <td class="text-center"><b>'.$ToPiezas.'</b></td>
    <td class="text-center" colspan="2"></td>

    </tr>';

    }else{
    echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
    }
    ?>
    </tbody>
    </table>
</div>

