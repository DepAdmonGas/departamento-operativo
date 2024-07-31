<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idRefaccion = $_GET['idRefaccion'];
 
$sql_lista = "SELECT * FROM op_refacciones WHERE id = '".$idRefaccion."' AND status = 1 ORDER BY id ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$descripcion_f = $row_lista['descripcion_f'];
$nombre = $row_lista['nombre'];
$unidad = $row_lista['unidad'];
$estado_r = $row_lista['estado_r'];
$costo = $row_lista['costo'];
$modelo = $row_lista['modelo'];
$marca = $row_lista['marca'];
$proveedor = $row_lista['proveedor'];
$contacto = $row_lista['contacto'];
$idarea = !empty($row_lista['area']) ? $row_lista['area'] : '';

}

$sql_nom_area = "SELECT id,nombre_area,abreviatura FROM op_rh_areas WHERE id = '".$idarea."' ";
$result_nom_area = mysqli_query($con, $sql_nom_area);
$numero_lista_area = mysqli_num_rows($result_nom_area);

if($numero_lista_area > 0){
while($row_nom_area = mysqli_fetch_array($result_nom_area, MYSQLI_ASSOC)){
$area = $row_nom_area['nombre_area'];
$abreviatura = $row_nom_area['abreviatura'];
} 
}else{
$area = "";
$abreviatura = "";
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
<h5 class="modal-title">Editar Refaccion</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

  <div class="modal-body">

    <div class="row">
    <div class="col-12 mb-2">
    <div class="mb-1 text-secondary">Refacción:</div>
    <input type="file" class="rounded-0 form-control" id="seleccionArchivos" accept="image/*" style="font-size: .8em;">  
    <div class="text-center">
    <img class="mt-2" id="imagenPrevisualizacion" width="150px">
    </div>
    </div>
    </div>


        <div class="mb-1 text-secondary">Descripción (Factura):</div>
        <input type="text" class="form-control rounded-0" id="DescripcionRefaccion" value="<?=$descripcion_f;?>"> 

      	<div class="mb-1 mt-2 text-secondary">Nombre genérico:</div>
        <input type="text" class="form-control rounded-0" id="NombreRefaccion" value="<?=$nombre;?>">   

        <div class="row">

            <div class="col-12 mb-2">
          <div class="mb-1 mt-2 text-secondary">Área:</div>
          <select class="form-select rounded-0" id="Area">
            <option value="<?=$idarea;?>"><?=$area;?> - <?=$abreviatura?></option>
            <?php 
            $sql_area = "SELECT id,nombre_area,abreviatura FROM op_rh_areas WHERE id <> '".$idarea."' ";
            $result_area = mysqli_query($con, $sql_area);
            while($row_area = mysqli_fetch_array($result_area, MYSQLI_ASSOC)){
            $id = $row_area['id'];
            $abreviatura = $row_area['abreviatura'];
            $nombrearea = $row_area['nombre_area'];
            echo "<option value='".$id."'>".$nombrearea." - ".$abreviatura."</option>";
            }
             ?>
          </select>
          </div> 
           
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
          <div class="mb-1 text-secondary">Modelo:</div>
          <input type="text" class="form-control rounded-0" id="Modelo" value="<?=$modelo;?>">
          </div>

          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
          <div class="mb-1 text-secondary">Marca:</div>
          <input type="text" class="form-control rounded-0" id="Marca" value="<?=$marca;?>">
          </div>

          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
          <div class="mb-1 text-secondary">Proveedor:</div>
          <input type="text" class="form-control rounded-0" id="Proveedor" value="<?=$proveedor;?>">
          </div>

          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
          <div class="mb-1 text-secondary">Contacto (Correo, Teléfono):</div>
          <input type="text" class="form-control rounded-0" id="Contacto" value="<?=$contacto;?>">
          </div>

          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
          <div class="mb-1 text-secondary">Unidades:</div>
          <input type="number" class="form-control rounded-0" id="Unidad" value="<?=$unidad;?>">
          </div>

          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
          <div class="mb-1 text-secondary">Estado:</div>
          <select class="form-select" id="EstadoR">
          <option value="<?=$estado_r?>"><?=$estado_r?></option>
          <option value="Nuevo">Nuevo</option>
          <option value="Usado">Usado</option>
          </select>          
          </div> 

          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
          <div class="mb-1 text-secondary">Costo por unidad:</div>
          <input type="number" class="form-control rounded-0" id="Costo" value="<?=$costo;?>">
          </div>

          <div class="col-12 mb-2">
          <div class="mb-1 text-secondary">Archivo:</div>
          <input type="file" id="Archivo" class="form-control">
          </div>
          
        </div>

      </div>

  <div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-success" onclick="EditarRefaccion(<?=$idEstacion;?>,<?=$idRefaccion;?>)">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Editar</button>
  </div>
