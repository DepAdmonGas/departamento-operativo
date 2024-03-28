<?php
require('../../../app/help.php');

$year = $_GET['year'];
$mes = $_GET['mes'];

$sql_lista = "SELECT * FROM op_orden_compra
WHERE year = '".$year."' AND mes = '".$mes."' ORDER BY no_control ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function Personal($idUsuario,$con){
$sql_lista = "SELECT * FROM tb_usuarios WHERE id = '".$idUsuario."'";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$nombre = $row_lista['nombre'];
}
return $nombre;
}
?>

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <th class="text-center align-middle tableStyle font-weight-bold">No. De control</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Responsable</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Fecha</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
  <!-- <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-firmar-w.png"></th> -->
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 
<tbody> 
<?php
    if ($numero_lista > 0) {
    $num = 1;
    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    $id = $row_lista['id'];
    $iva = $row_lista['iva'];
    $explode = explode(" ", $row_lista['fecha']);
    $Personal = Personal($row_lista['id_usuario'],$con);


    if($row_lista['estatus'] == 0 ){
    $trColor = "table-warning";
    $Detalle = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="Detalle('.$id.')">';
    $PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png">';
    $Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png">';
    $Editar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$id.')">';
    $Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$id.','.$year.','.$mes.')">';
    
    }else if($row_lista['estatus'] == 1){
    $trColor = "";  
    $Detalle = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="Detalle('.$id.')">';
    $PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="Descargar('.$id.')">';
    $Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$id.')">';
    $Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png">';
    $Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$id.','.$year.','.$mes.')">';
    
    }else if($row_lista['estatus'] == 2){
    $trColor = "";  
    $Detalle = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="Detalle('.$id.')">';
    $PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="Descargar('.$id.')">';
    $Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png">';
    $Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png">';
    $Eliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png">';
    }

    echo '<tr class="'.$trColor.'">';
    echo '<td class="text-center align-middle">'.$num.'</td>';
    echo '<td class="align-middle text-center"><b>00'.$row_lista['no_control'].'</b></td>';
    echo '<td class="align-middle text-center">'.$Personal.'</td>';
    echo '<td class="align-middle text-center">'.FormatoFecha($explode[0]).'</td>';
    echo '<td class="align-middle text-center" width="20">'.$Detalle.'</td>';
    echo '<td class="align-middle text-center" width="20">'.$PDF.'</td>';
    //echo '<td class="align-middle text-center" width="20">'.$Firmar.'</td>';
    echo '<td class="align-middle text-center" width="20">'.$Editar.'</td>';
    echo '<td class="align-middle text-center" width="20">'.$Eliminar.'</td>';
    echo '</tr>';
    $num++;
    }
    }else{
    echo "<tr><td colspan='10' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
    }
    ?>
</tbody> 
</table>
</div>
 
