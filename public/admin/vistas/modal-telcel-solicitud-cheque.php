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
  <h5 class="modal-title">Facturas telcel, <?=nombremes($mes);?> <?=$year;?></h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>
 
  <div class="modal-body">

    <div class="text-secondary mb-1">* Factura telcel:</div>
    <input type="file" class="form-control" id="Factura">

<hr>

<div class="text-end">
  <button type="button" class="btn btn-labeled2 btn-success" onclick="AgregarFactura(<?=$idEstacion;?>,<?=$depu;?>,<?=$year;?>,<?=$mes;?>)">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Agregar</button>
  </div>


  <div class="table-responsive">
  <table class="custom-table mt-3" width="100%" style="font-size: .9em;">
  <thead class="title-table-bg">

  <tr class="tables-bg">
  <th colspan="4"><?=$estacion;?></th>
  </tr>

      <tr>
        <td class="text-center align-middle"><b>Factura telcel</b></td>
        <td class="text-center align-middle"><b>Comprobante de pago</b></td>
        <td class="text-center" width="24px"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></td>
        <td class="text-center" width="24px"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></td>
      </tr>
    </thead> 

    <tbody class="bg-light">
    <?php
    if ($numero_lista > 0) {
    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    $id = $row_lista['id'];

    if($row_lista['factura'] == ""){
    $Factura = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';
    }else{
    $Factura = '<a href="'.RUTA_ARCHIVOS.''.$row_lista['factura'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a>';
    }

    if($row_lista['c_pago'] == ""){
    $Pago = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';
    }else{
    $Pago = '<a href="'.RUTA_ARCHIVOS.''.$row_lista['c_pago'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a>';
    }


    echo '<tr>';
    echo '<td class="text-center">'.$Factura.'</td>';
    echo '<td class="text-center">'.$Pago.'</td>';
    echo '<td class="text-center" width="24px"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="EditarTelcel('.$idEstacion.','.$depu.','.$year.','.$mes.','.$id.')"></td>';
    echo '<td class="text-center" width="24px"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarTelcel('.$idEstacion.','.$depu.','.$year.','.$mes.','.$id.')"></td>';
    echo '</tr>';
 
    }
    }else{
    echo "<tr><th colspan='4' class='text-center text-secondary no-hover2 fw-normal'><small>No se encontró información para mostrar </small></th></tr>";
    }
    ?>
    </tbody>
    </table>
  </div>
 
  </div>






