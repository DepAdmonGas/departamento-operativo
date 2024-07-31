<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
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
  <h5 class="modal-title">Agregar Refaccion a inventario</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
      

  <div class="modal-body">

    <div class="row">
   
    <div class="col-12 mb-2">
    <div class="mb-1 text-secondary">Refacción:</div>
    <input type="file" class="rounded-0 form-control" id="seleccionArchivos" accept="image/*" style="font-size: .8em;">  
    <div class="text-center">
    <img id="imagenPrevisualizacion" width="150px">
    </div>

    </div>

    <div class="col-12 mb-2">
    <div class="mb-1 mt-2 text-secondary">Descripción (Factura):</div>
    <input type="text" class="form-control rounded-0" id="DescripcionRefaccion">  
    </div> 


    <div class="col-12 mb-2">
    <div class="mb-1 mt-2 text-secondary">Nombre genérico:</div>
    <input type="text" class="form-control rounded-0" id="NombreRefaccion">  
    </div> 


    <div class="col-12 mb-2">
    <div class="mb-1 text-secondary">Área:</div>
          <select class="form-select rounded-0" id="Area">
            <option></option>
            <?php 
            $sql_area = "SELECT id,nombre_area,abreviatura FROM op_rh_areas ";
            $result_area = mysqli_query($con, $sql_area);
            while($row_area = mysqli_fetch_array($result_area, MYSQLI_ASSOC)){
            $id = $row_area['id'];
            $area = $row_area['nombre_area'];
            $abreviatura = $row_area['abreviatura'];
            echo "<option value='".$id."'>".$area." - ".$abreviatura." </option>";
            }
             ?>
          </select>
  </div> 
          
  
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
          <div class="mb-1 text-secondary">Modelo:</div>
          <input type="text" class="form-control rounded-0" id="Modelo">
          </div>

          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
          <div class="mb-1 text-secondary">Marca:</div>
          <input type="text" class="form-control rounded-0" id="Marca">
          </div>

          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
          <div class="mb-1 text-secondary">Proveedor:</div>
          <input type="text" class="form-control rounded-0" id="Proveedor">
          </div>

          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
          <div class="mb-1 text-secondary">Contacto (Correo, Teléfono):</div>
          <input type="text" class="form-control rounded-0" id="Contacto">
          </div>

          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
          <div class="mb-1 text-secondary">Unidades:</div>
          <input type="number" class="form-control rounded-0" id="Unidad">
          </div>

          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
          <div class="mb-1 text-secondary">Estado:</div>
          <select class="form-select" id="EstadoR">
          <option value="">Selecciona una opción...</option>
          <option value="Nuevo">Nuevo</option>
          <option value="Usado">Usado</option>
          </select>          
          </div>


          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
          <div class="mb-1 text-secondary">Costo por unidad:</div>
          <input type="number" class="form-control rounded-0" id="Costo">
          </div>
  
       </div>

      </div> 

  <div class="modal-footer">
	<button type="button" class="btn btn-labeled2 btn-success" onclick="Guardar(<?=$idEstacion;?>)">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Agregar</button>
  </div>
