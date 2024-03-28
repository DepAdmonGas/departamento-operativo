<?php
require('../../../app/help.php');
 
$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

?>

<div class="border-0 p-3">

<div class="row">
<div class="col-11"><h5><?=$estacion;?></h5></div>
<div class="col-1"><img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="Regresar()"></div>
</div>

<hr>

<div class="row">

<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-0">
<img src="https://gotradehub.com/new/lib/images/news/thumbs/Noticias%2022.jpg" jsaction="VQAsE" class="sFlh5c pT0Scc iPVvYb" style="max-width: 100%; height: 800px; margin: 0px; width: 100%;" alt="G500 Network abre hoy su primera gasolinera propia" jsname="kn3ccd" aria-hidden="false"></div>

<div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-0">
<div class="table-responsive">
<table class="table table-sm table-bordered table-hover" style="font-size: .9em;">

<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">No.</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Nombre de la estructura</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>reparar-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead>

<tbody>
<tr class="pointer" onclick="SelEstacion()">
<th class="text-center align-middle tableStyle font-weight-bold">1</th>
<th class="text-center align-middle tableStyle font-weight-bold">Dispensario 1</th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>reparar-tb.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</tbody>

</table>
</div>
</div>


</div>


</div>