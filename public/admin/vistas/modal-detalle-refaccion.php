<?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];
$idRefaccion = $_GET['idRefaccion'];

$sql_lista = "SELECT * FROM op_refacciones WHERE id = '".$idRefaccion."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
  $descripcion_f = !empty($row_lista['descripcion_f']) ? $row_lista['descripcion_f'] : 'S/I';
  $nombre = !empty($row_lista['nombre']) ? $row_lista['nombre'] : 'S/I';
  $imagen = !empty($row_lista['imagen']) ? $row_lista['imagen'] : '';
  $unidad = !empty($row_lista['unidad']) ? $row_lista['unidad'] : 'S/I';
  $costo = !empty(number_format($row_lista['costo'],2)) ? $row_lista['costo'] : 'S/I';
  $total = ($unidad !== 'S/I' && $costo !== 'S/I') ? $unidad * $costo : 0;

  $modelo = !empty($row_lista['modelo']) ? $row_lista['modelo'] : 'S/I';
  $marca = !empty($row_lista['marca']) ? $row_lista['marca'] : 'S/I';
  $proveedor = !empty($row_lista['proveedor']) ? $row_lista['proveedor'] : 'S/I';
  $contacto = !empty($row_lista['contacto']) ? $row_lista['contacto'] : 'S/I';
  $idarea = !empty($row_lista['area']) ? $row_lista['area'] : '';
  $archivo = !empty($row_lista['archivo']) ? $row_lista['archivo'] : '';
}


$sql_nom_area = "SELECT id,nombre_area FROM op_rh_areas WHERE id = '".$idarea."' ";
$result_nom_area = mysqli_query($con, $sql_nom_area);
$numero_lista_area = mysqli_num_rows($result_nom_area);


if($numero_lista_area > 0){
while($row_nom_area = mysqli_fetch_array($result_nom_area, MYSQLI_ASSOC)){
$area = $row_nom_area['nombre_area'];
} 
}else{
$area = "S/I";
}

?>
<div class="modal-header">
<h5 class="modal-title">Detalle de la Refacción</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

  <div class="modal-body">
  <div class="row">
    
  <div class="col-12 mb-3">
  <h6 class="mb-2 text-secondary ">REFACCIÓN:</h6>
  <?php if($imagen != ""){ ?>
  <div class="border p-1 text-center"><img src="<?=RUTA_ARCHIVOS;?><?=$imagen;?>" width="350px"></div>
  <?php }else{ ?>
  <div class="">Sin información</div>
  <?php } ?>
  </div>


  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
  <h6 class="mb-1 text-secondary ">DESCRIPCIÓN (FACTURA):</h6>
  <div class=""><?=$descripcion_f;?></div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
  <h6 class="mb-1 text-secondary ">NOMBRE GENÉRICO:</h6>
  <div class=""><?=$nombre;?></div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
  <h6 class="mb-1 mt-2 text-secondary ">ÁREA:</h6>
  <div class=""><?=$area;?></div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
  <h6 class="mb-1 text-secondary ">MODELO:</h6>
  <div class=""><?=$modelo;?></div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
  <h6 class="mb-1 text-secondary ">MARCA:</h6>
  <div class=""><?=$marca;?></div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
    <h6 class="mb-1 text-secondary ">PROVEEDOR:</h6>
    <div class=""><?=$proveedor;?></div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
  <h6 class="mb-1 text-secondary ">CONTACTO:</h6>
  <div class=""><?=$contacto;?></div>
  </div>


  <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mb-3">
  <h6 class="mb-2 text-secondary ">DOCUMENTO:</h6>
  <?php if($archivo != ""){ ?>
  <a href="<?=RUTA_ARCHIVOS;?><?=$archivo;?>" download>
  <button type="button" class="btn btn-labeled2 btn-danger">
  <span class="btn-label2"><i class="fa-solid fa-file-arrow-down"></i></span>Descargar</button>
  </a>
  <?php }else{ 
  echo '<div class="">S/I</div>';
  } ?>
  </div>


  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
    <h6 class="mb-2 text-secondary ">UNIDADES:</h6>
    <div class=""><?=$unidad;?></div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
    <h6 class="mb-2 text-secondary ">COSTO POR UNIDAD:</h6>
    <div class="">$ <?= $costo?></div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
    <h6 class="mb-2 text-secondary ">TOTAL:</h6>
    <div class=""><b>$ <?=number_format($total,2);?></b></div>
  </div>


</div>
</div>