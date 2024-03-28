<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idRefaccion = $_GET['idRefaccion'];

$sql_lista = "SELECT * FROM op_refacciones WHERE id = '".$idRefaccion."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$descripcion_f = $row_lista['descripcion_f'];
$nombre = $row_lista['nombre'];
$imagen = $row_lista['imagen'];
$unidad = $row_lista['unidad'];
$costo = $row_lista['costo'];
$total = $unidad * $costo;

$modelo = $row_lista['modelo'];
$marca = $row_lista['marca'];
$proveedor = $row_lista['proveedor'];
$contacto = $row_lista['contacto'];
$idarea = $row_lista['area'];
$archivo = $row_lista['archivo'];
}

$sql_nom_area = "SELECT id,nombre_area FROM op_rh_areas WHERE id = '".$idarea."' ";
$result_nom_area = mysqli_query($con, $sql_nom_area);
while($row_nom_area = mysqli_fetch_array($result_nom_area, MYSQLI_ASSOC)){
$area = $row_nom_area['nombre_area'];
} 

?>
<div class="modal-header">
<h5 class="modal-title">Detalle de la Refacción</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="row">
 


  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">
    <h6 class="mb-2 text-secondary ">Refacción:</h6>
    <div class="border p-1 text-center"><img src="../archivos/<?=$imagen;?>" width="150px"></div>
  </div>


  <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mb-2">

<div class="row">
  <div class="col-12 mt-2">
    <h6 class="mb-1 text-secondary ">Descripción (Factura):</h6>
    <div class=""><?=$descripcion_f;?></div>
  </div>

  <div class="col-12 mt-2">
    <h6 class="mb-1 text-secondary ">Nombre genérico:</h6>
    <div class=""><?=$nombre;?></div>
  </div>

  <div class="col-12">
    <h6 class="mb-1 mt-2 text-secondary ">Área:</h6>
    <div class=""><?=$area;?></div>
  </div>
</div>

<div class="row ">
  <div class="col-6 mt-2">
    <h6 class="mb-1 text-secondary ">Modelo:</h6>
    <div class=""><?=$modelo;?></div>
  </div>
  <div class="col-6">
    <h6 class="mb-1 text-secondary ">Marca:</h6>
    <div class=""><?=$marca;?></div>
  </div>
  <div class="col-6 mt-2">
    <h6 class="mb-1 text-secondary ">Proveedor:</h6>
    <div class=""><?=$proveedor;?></div>
  </div>
    <div class="col-6 mt-2">
    <h6 class="mb-1 text-secondary ">Contacto:</h6>
    <div class=""><?=$contacto;?></div>
  </div>

    <?php if($archivo != ""){ ?>
    <div class="col-6 mt-2">
    <h6 class="mb-2 text-secondary ">Documento:</h6>
    <a href="../archivos/<?=$archivo;?>" download><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></a>
    </div>
    <?php } ?>
  
</div>

<hr>
<div class="row mt-4">
  <div class="col-3">
    <h6 class="mb-2 text-secondary ">Unidades:</h6>
    <div class=""><?=$unidad;?></div>
  </div>
  <div class="col-5">
    <h6 class="mb-2 text-secondary ">Costo por unidad:</h6>
    <div class="">$ <?=number_format($costo,2);?></div>
  </div>
  <div class="col-4">
    <h6 class="mb-2 text-secondary ">Total:</h6>
    <div class=""><b>$ <?=number_format($total,2);?></b></div>
  </div>
</div>

  </div>
</div>

</div>
