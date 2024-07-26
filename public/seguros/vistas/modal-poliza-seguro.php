<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

$sql_lista_poliza = "SELECT * FROM op_poliza_es WHERE id_estacion = '".$idEstacion ."' ORDER BY emision DESC";
$result_lista_poliza = mysqli_query($con, $sql_lista_poliza);
$numero_lista_poliza = mysqli_num_rows($result_lista_poliza);

?>

 <div class="modal-header">
  <h5 class="modal-title">Poliza de Seguro <?=$estacion?></h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>


<div class="modal-body">

<h6 class="mb-1">Fecha de emisión:</h6>
<input class="form-control" type="date" id="EmisionP" onchange="VencimientoPoliza()">

<h6 class="mb-1 mt-3">Fecha de vencimiento:</h6>
<div id="fechavencimiento" style="font-size: 1em">S/I</div>


<h6 class="mt-3 mb-1">Documento:</h6>
<input class="form-control" type="file" id="PolizaDoc">


<div class="table-responsive">
<table class="custom-table mt-3" style="font-size: 12.5px;" width="100%">

    <thead class="tables-bg">
      <tr>
        <td class="text-center align-middle"><b>Poliza de seguro</b></td>
        <td class="text-center align-middle"><b>Fecha de emisión</b></td>
        <td class="text-center align-middle"><b>Fecha de vencimiento</b></td>

        <td class="text-center align-middle" width="24px"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></td>
        <td class="text-center align-middle" width="24px"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></td>
      </tr>
    </thead> 

    <tbody class="bg-light">
    <?php
    if ($numero_lista_poliza > 0) {
    while($row_lista_poliza = mysqli_fetch_array($result_lista_poliza, MYSQLI_ASSOC)){
    $id_poliza = $row_lista_poliza['id_poliza'];
    $emision = $row_lista_poliza['emision'];
    $vencimiento = $row_lista_poliza['vencimiento'];

    if($row_lista_poliza['archivo'] == ""){
    $Poliza = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';
    }else{
    $Poliza = '<a href="archivos/poliza-estacion/'.$row_lista_poliza['archivo'].'" download>
    <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png">
    </a>';
    }

    echo '<tr class="align-middle">';
    echo '<th class="text-center">'.$Poliza.'</th>';
    echo '<td class="text-center">'.FormatoFecha($emision).'</td>';
    echo '<td class="text-center">'.FormatoFecha($vencimiento).'</td>';
    echo '<td class="text-center" width="24px"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="ModalEditarPoliza('.$id_poliza.')"></td>';
    echo '<td class="text-center" width="24px"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarPoliza('.$id_poliza.','.$idEstacion.')"></td>';
    echo '</tr>';

    }
    }else{
    echo "<tr><th colspan='5' class='text-center text-secondary fw-normal no-hover2'><small>No se encontró información para mostrar </small></th></tr>";
    }
    ?>
    </tbody>
    </table>
  </div>

</div>


<div class="modal-footer">

<button type="button" class="btn btn-labeled2 btn-success" onclick="GuardarPolizaS(<?=$idEstacion;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>