<?php 
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

$sql_lista = "SELECT * FROM op_orden_mantenimiento
WHERE id_estacion = '".$idEstacion."' ORDER BY fecha ASC";
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

 
<div class="p-3">

    <div class="row">

    <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12">
    <h5>Orden de mantenimiento <?=$estacion;?></h5>
    </div>


    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12">
    <img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="Nuevo(<?=$idEstacion;?>)">
    </div>

    </div>

<hr> 

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Folio</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Personal</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Fecha</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-firmar-w.png"></th>
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

    if($row_lista['estatus'] == 0){
    $trColor = "table-warning";
    $Detalle = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="Detalle('.$id.')">';
    $PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png">';
    $Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png">';
    $Editar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$id.')">';
    $Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idEstacion.','.$id.')">';
    }else if($row_lista['estatus'] == 1){
    $trColor = "";  
    $Detalle = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="Detalle('.$id.')">';
    $PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png">';
    $Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$id.')">';
    $Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png">';
    $Eliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png">';
    }else if($row_lista['estatus'] == 2){
    $trColor = "";  
    $Detalle = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="Detalle('.$id.')">';
    $PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="Descargar('.$id.')">';
    $Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png">';
    $Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png">';
    $Eliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png">';
    }

    echo '<tr class="'.$trColor.'">';
    echo '<td class="text-center">'.$num.'</td>';
    echo '<td class="align-middle text-center"><b>00'.$row_lista['folio'].'</b></td>';
    echo '<td class="align-middle text-center">'.$Personal.'</td>';
    echo '<td class="align-middle text-center">'.FormatoFecha($explode[0]).'</td>';
    echo '<td class="align-middle text-center" width="20">'.$Detalle.'</td>';
    echo '<td class="align-middle text-center" width="20">'.$PDF.'</td>';
    echo '<td class="align-middle text-center" width="20">'.$Firmar.'</td>';
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

</div>