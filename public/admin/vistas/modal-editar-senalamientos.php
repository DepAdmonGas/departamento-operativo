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
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$idColor = $row['id'];
$contenido .= '<tr>
<td class="p-0 m-0"><input type="text" class="form-control border-0 p-1 m-0" value="'.$row['titulo'].'" oninput="EditarColor(this,'.$Senalamiento.','.$idSenalamiento.','.$idColor.',2)" /></td>
<td class="p-0 m-0"><input type="text" class="form-control border-0 p-1 m-0" value="'.$row['detalle'].'" oninput="EditarColor(this,'.$Senalamiento.','.$idSenalamiento.','.$idColor.',3)" /></td>
<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarColor('.$Senalamiento.','.$idSenalamiento.','.$idColor.')"></td></tr>';
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
<h5 class="modal-title">Editar señalamiento</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

    <h6><?=$titulo;?></h6>

    <div class="row">
    <div class="col-12">
    <div class="mb-1 text-secondary">Diseño:</div>
    <input type="file" class="rounded-0 form-control" id="seleccionArchivos" accept="image/*" style="font-size: .8em;">  
    <div class="text-center mt-3">
    <img id="imagenPrevisualizacion" width="150px">
    </div>
    </div>
    </div>

      	<div class="mb-1 mt-2 text-secondary">Dimensión:</div>
        <input type="text" class="form-control rounded-0" id="Dimension" value="<?=$dimension;?>">   

      <hr>
      <div class="mb-1 mt-2 text-secondary">Colores:</div>

      <div class="table-responsive">
      <table class="table table-bordered table-sm" id="tablaprueba">
      <thead class="tables-bg">
        <tr>
          <th>Titulo</th>
          <th>Detalle</th>
          <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
        </tr>
      </thead>
      <tbody>
        <?=Colores($Senalamiento,$idSenalamiento,$con);?>
      </tbody>
    </table>
  </div>


<div class="row">
    <div class="col-12">
      <button type="button" class="btn btn-primary mr-2 btn-sm float-end" onclick="AgregarColor(<?=$Senalamiento;?>,<?=$idSenalamiento;?>)">Agregar</button>
    </div>
  </div>

    <hr>

        <div class="mb-2 mt-2 text-secondary">Ubicación:</div>
        <textarea class="form-control rounded-0" id="Ubicacion"><?=$ubicacion;?></textarea>

        <div class="mb-2 text-secondary">Reproducción:</div>
        <textarea class="form-control rounded-0" id="Reproduccion"><?=$reproduccion;?></textarea>

        <div class="row mt-2">
          <div class="col-6">
          <div class="mb-2 text-secondary">Stock vinil:</div>
          <input type="text" class="form-control rounded-0" id="vinil" value="<?=$vinil;?>">
          </div>
          <div class="col-6">
          <div class="mb-2 text-secondary">Stock placa:</div>
          <input type="text" class="form-control rounded-0" id="placa" value="<?=$placa;?>">
          </div>
     </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="Editar(<?=$Senalamiento;?>,<?=$idSenalamiento;?>)">Editar</button>
      </div>
