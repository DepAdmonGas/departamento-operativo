<?php
require('../../../app/help.php');

$Senalamiento = $_GET['Senalamiento'];
$idSenalamiento = $_GET['idSenalamiento'];

$sql_lista = "SELECT * FROM op_senalamientos WHERE id = '".$idSenalamiento."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$dimension = $row_lista['dimension'];
$ubicacion = $row_lista['ubicacion'];
$reproduccion = $row_lista['reproduccion'];
$vinil = $row_lista['vinil'];
$placa = $row_lista['placa'];
}

if($_GET['Senalamiento'] == 1){
$titulo = 'NOM-003-SEGOB-2011';

}else if($_GET['Senalamiento'] == 2){
$titulo = 'NOM-005-ASEA-2016';

}else if($_GET['Senalamiento'] == 3){
$titulo = 'IMAGEN G500';
}

function Colores($Senalamiento,$idSenalamiento,$con){

$sql = "SELECT * FROM op_senalamientos_colores WHERE id_senalamiento = '".$idSenalamiento."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

$contenido = "";
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$idColor = $row['id'];
$contenido .= '<tr>
<td class="p-0 m-0"><input type="text" class="form-control border-0 p-3 m-0 bg-light" placeholder="Escribe el titulo aquí..." value="'.$row['titulo'].'" oninput="EditarColor(this,'.$Senalamiento.','.$idSenalamiento.','.$idColor.',2)" /></td>
<td class="p-0 m-0"><input type="text" class="form-control border-0 p-3 m-0 bg-light" placeholder="Escribe el detalle aquí..." value="'.$row['detalle'].'" oninput="EditarColor(this,'.$Senalamiento.','.$idSenalamiento.','.$idColor.',3)" /></td>
<td class="align-middle text-center no-hover2"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarColor('.$Senalamiento.','.$idSenalamiento.','.$idColor.')"></td></tr>';
}
return $contenido;
}
?>

<script type="text/javascript">
  $(document).ready(function($){
  
const $seleccionArchivos = document.querySelector("#seleccionArchivos"),
$imagenPrevisualizacion = document.querySelector("#imagenPrevisualizacion");


$seleccionArchivos.addEventListener("change", () => {
const archivos = $seleccionArchivos.files;
if (!archivos || !archivos.length) {
$imagenPrevisualizacion.src = "";
return;
}
const primerArchivo = archivos[0];
const objectURL = URL.createObjectURL(primerArchivo);
$imagenPrevisualizacion.src = objectURL;

});

    });
</script>


<div class="modal-header">
<h5 class="modal-title">Editar señalamiento (<?=$titulo?>)</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="row">
<div class="col-12">
<div class="mb-2 text-secondary">Diseño:</div>
<input type="file" class="rounded-0 form-control" id="seleccionArchivos" accept="image/*" style="font-size: .8em;">  
<div class="text-center mt-2"><img id="imagenPrevisualizacion" width="150px"></div>
</div>
</div>

<div class="mb-1 mt-2 text-secondary">Dimensión:</div>
<input type="text" class="form-control rounded-0" id="Dimension" value="<?=$dimension;?>">   

<hr> 

<div class="row">
  
<div class="col-12 mb-3">
<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="AgregarColor(<?=$Senalamiento;?>,<?=$idSenalamiento;?>)">
<span class="btn-label2"><i class="fa-solid fa-table"></i></span>Agregar fila</button>
</div>

</div>
 

<div class="table-responsive">
<table id="tablaprueba" class="custom-table" style="font-size: .9em;" width="100%">
<thead class="tables-bg">
<tr>
<th colspan="3">Colores</th>
</tr>
<tr class="title-table-bg">
<td class="fw-bold">Titulo</td>
<td class="fw-bold">Detalle</td>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</tr>
</thead>
<tbody class="bg-light p-3"><?=Colores($Senalamiento,$idSenalamiento,$con);?></tbody>
</table>
</div> 

<hr>

<div class="mb-2 mt-2 text-secondary">Ubicación:</div>
<textarea class="form-control rounded-0" id="Ubicacion"><?=$ubicacion;?></textarea>

<div class="mb-2 text-secondary">Reproducción:</div>
<textarea class="form-control rounded-0" id="Reproduccion"><?=$reproduccion;?></textarea>


     <div class="row mt-2">
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
          <div class="mb-2 text-secondary">Stock vinil:</div>
          <input type="text" class="form-control rounded-0" id="vinil" value="<?=$vinil;?>">
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
          <div class="mb-2 text-secondary">Stock placa:</div>
          <input type="text" class="form-control rounded-0" id="placa" value="<?=$placa;?>">
          </div>
     </div>


</div>


<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="Editar(<?=$Senalamiento;?>,<?=$idSenalamiento;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Editar</button>
</div>
