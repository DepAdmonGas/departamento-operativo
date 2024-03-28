<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$depu = $_GET['depu'];
$year = $_GET['year'];
$mes = $_GET['mes'];

 
$sql_listaestacion = "SELECT razonsocial FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['razonsocial'];
} 

$sql_lista = "SELECT * FROM op_solicitud_cheque_telcel WHERE id_year = '".$year."' AND id_mes = '".$mes."' AND id_estacion = '".$idEstacion."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?> 

 <div class="modal-header">
  <h5 class="modal-title">Facturas telcel, <?=nombremes($mes);?> del <?=$year;?></h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>
 
  <div class="modal-body">

    <b><?=$estacion;?></b>

    <div class="text-secondary mt-2">* Factura telcel:</div>
    <div class="input-group mt-2">
    <input type="file" class="form-control" aria-describedby="button-addon2" id="Factura">
    <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="AgregarFactura(<?=$idEstacion;?>,<?=$depu;?>,<?=$year;?>,<?=$mes;?>)">Agregar</button>
    </div>
    </div>
    <hr>

<div class="table-responsive">
    <table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
    <thead class="tables-bg">
      <tr>
        <td class="text-center align-middle"><b>Factura telcel</b></td>
        <td class="text-center align-middle"><b>Comprobante de pago</b></td>
        <td class="text-center" width="24px"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></td>
        <td class="text-center" width="24px"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></td>
      </tr>
    </thead> 
    <tbody>
    <?php
    if ($numero_lista > 0) {
    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    $id = $row_lista['id'];

    if($row_lista['factura'] == ""){
    $Factura = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';
    }else{
    $Factura = '<a href="../../../archivos/'.$row_lista['factura'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a>';
    }

    if($row_lista['c_pago'] == ""){
    $Pago = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';
    }else{
    $Pago = '<a href="../../../archivos/'.$row_lista['c_pago'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a>';
    }


    echo '<tr>';
    echo '<td class="text-center">'.$Factura.'</td>';
    echo '<td class="text-center">'.$Pago.'</td>';
    echo '<td class="text-center" width="24px"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="EditarTelcel('.$idEstacion.','.$depu.','.$year.','.$mes.','.$id.')"></td>';
    echo '<td class="text-center" width="24px"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarTelcel('.$idEstacion.','.$depu.','.$year.','.$mes.','.$id.')"></td>';
    echo '</tr>';

    }
    }else{
    echo "<tr><td colspan='4' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
    }
    ?>
    </tbody>
    </table>
  </div>

  </div>



