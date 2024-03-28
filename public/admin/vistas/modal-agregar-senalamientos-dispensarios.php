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
<h5 class="modal-title">Agregar señalamiento</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
      <div class="modal-body">
 
    <div class="mb-1 text-secondary">Dispensario:</div>
    <select class="form-select rounded-0" id="Dispensario">
    <option></option>
    
    <?php  
    if($idEstacion == 1){
    echo '<option>Dispensario: 1, Lado: A</option>
    <option>Dispensario: 1, Lado: B</option>
    <option>Dispensario: 2, Lado: A</option>
    <option>Dispensario: 2, Lado: B</option>
    <option>Dispensario: 3, Lado: A</option>
    <option>Dispensario: 3, Lado: B</option>
    <option>Dispensario: 4, Lado: A</option>
    <option>Dispensario: 4, Lado: B</option>
    <option>Dispensario: 5, Lado: A</option>
    <option>Dispensario: 5, Lado: B</option>
    <option>Dispensario: 6, Lado: A</option>
    <option>Dispensario: 6, Lado: B</option>';
    
    }else if($idEstacion == 2){
    echo '<option>Dispensario: 1, Lado: A</option>
    <option>Dispensario: 1, Lado: B</option>
    <option>Dispensario: 2, Lado: A</option>
    <option>Dispensario: 2, Lado: B</option>
    <option>Dispensario: 3, Lado: A</option>
    <option>Dispensario: 3, Lado: B</option>
    <option>Dispensario: 4, Lado: A</option>
    <option>Dispensario: 4, Lado: B</option>';
    

    }else if($idEstacion == 3){
    echo '<option>Dispensario: 1, Lado: A</option>
    <option>Dispensario: 1, Lado: B</option>
    <option>Dispensario: 2, Lado: A</option>
    <option>Dispensario: 2, Lado: B</option>
    <option>Dispensario: 3, Lado: A</option>
    <option>Dispensario: 3, Lado: B</option>
    <option>Dispensario: 4, Lado: A</option>
    <option>Dispensario: 4, Lado: B</option>
    <option>Dispensario: 5, Lado: A</option>
    <option>Dispensario: 5, Lado: B</option>
    <option>Dispensario: 6, Lado: A</option>
    <option>Dispensario: 6, Lado: B</option>
    <option>Dispensario: 7, Lado: A</option>
    <option>Dispensario: 7, Lado: B</option>
    <option>Dispensario: 8, Lado: A</option>
    <option>Dispensario: 8, Lado: B</option>
    <option>Dispensario: 9, Lado: A</option>
    <option>Dispensario: 9, Lado: B</option>';

    }else if($idEstacion == 4){
    echo '<option>Dispensario: 1, Lado: A</option>
    <option>Dispensario: 1, Lado: B</option>
    <option>Dispensario: 2, Lado: A</option>
    <option>Dispensario: 2, Lado: B</option>
    <option>Dispensario: 3, Lado: A</option>
    <option>Dispensario: 3, Lado: B</option>
    <option>Dispensario: 4, Lado: A</option>
    <option>Dispensario: 4, Lado: B</option>
    <option>Dispensario: 5, Lado: A</option>
    <option>Dispensario: 5, Lado: B</option>
    <option>Dispensario: 6, Lado: A</option>
    <option>Dispensario: 6, Lado: B</option>
    <option>Dispensario: 7, Lado: A</option>
    <option>Dispensario: 7, Lado: B</option>';
    

    }else if($idEstacion == 5){
    echo '<option>Dispensario: 1, Lado: A</option>
    <option>Dispensario: 1, Lado: B</option>
    <option>Dispensario: 2, Lado: A</option>
    <option>Dispensario: 2, Lado: B</option>
    <option>Dispensario: 3, Lado: A</option>
    <option>Dispensario: 3, Lado: B</option>
    <option>Dispensario: 4, Lado: A</option>
    <option>Dispensario: 4, Lado: B</option>';
    

    }else if($idEstacion == 6){
    echo '<option>Dispensario: 1, Lado: A</option>
    <option>Dispensario: 1, Lado: B</option>
    <option>Dispensario: 2, Lado: A</option>
    <option>Dispensario: 2, Lado: B</option>
    <option>Dispensario: 3, Lado: A</option>
    <option>Dispensario: 3, Lado: B</option>
    <option>Dispensario: 4, Lado: A</option>
    <option>Dispensario: 4, Lado: B</option>
    <option>Dispensario: 5, Lado: A</option>
    <option>Dispensario: 5, Lado: B</option>
    <option>Dispensario: 6, Lado: A</option>
    <option>Dispensario: 6, Lado: B</option>';
    

    }else if($idEstacion == 7){
    echo '<option>Dispensario: 1, Lado: A</option>
    <option>Dispensario: 1, Lado: B</option>
    <option>Dispensario: 2, Lado: A</option>
    <option>Dispensario: 2, Lado: B</option>
    <option>Dispensario: 3, Lado: A</option>
    <option>Dispensario: 3, Lado: B</option>';
    

    }else if($idEstacion == 14){
    echo '<option>Dispensario: 1, Lado: A</option>
    <option>Dispensario: 1, Lado: B</option>
    <option>Dispensario: 2, Lado: A</option>
    <option>Dispensario: 2, Lado: B</option>
    <option>Dispensario: 3, Lado: A</option>
    <option>Dispensario: 3, Lado: B</option>
    <option>Dispensario: 4, Lado: A</option>
    <option>Dispensario: 4, Lado: B</option>
    <option>Dispensario: 5, Lado: A</option>
    <option>Dispensario: 5, Lado: B</option>
    <option>Dispensario: 6, Lado: A</option>
    <option>Dispensario: 6, Lado: B</option>';


    } 
    ?>

    </select>



    <div class="row">
    <div class="col-12">
    <div class="mb-2 mt-2 text-secondary">Diseño:</div>
    <input type="file" class="rounded-0 form-control" id="seleccionArchivos" accept="image/*" style="font-size: .8em;">  
    <div class="text-center mt-3">
    <img id="imagenPrevisualizacion" width="150px">
    </div>
    </div>
    </div>

   
      <hr>

      <div class="mb-2 mt-2 text-secondary">Especificaciones:</div>
      

<div class="table-responsive">
      <table class="table table-bordered table-sm mb-3" id="tablaprueba" style="font-size: .8em;">
        <thead class="tables-bg">
          <tr>
            <th class="align-middle text-center">Dimensión</th>
            <th class="align-middle text-center">Aprobación del modelo prototipo</th>
            <th class="align-middle text-center">Modelo</th>
            <th class="align-middle text-center">Número de serie</th>
            <th class="align-middle text-center">Material</th>
          </tr>
        </thead>
      <tbody>
      </tbody>
      </table>
</div>


    <div class="form-group text-end">
    <button type="button" class="btn btn-primary mr-2 btn-sm" onclick="agregarFila()">Agregar</button>
    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila()">Eliminar</button>
    </div>


      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="Guardar(<?=$idEstacion;?>)">Guardar</button>
      </div>
