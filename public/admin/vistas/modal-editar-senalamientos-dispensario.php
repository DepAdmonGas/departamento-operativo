<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idSenalamiento = $_GET['idSenalamiento'];

$sql_lista = "SELECT * FROM op_senalamientos_dispensarios WHERE id = '".$idSenalamiento."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$dispensario = $row_lista['dispensario'];
}

function Especificaciones($idEstacion,$idSenalamiento,$con){

$sql = "SELECT * FROM op_senalamientos_dispensarios_especificaciones WHERE id_senalamiento = '".$idSenalamiento."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
$contenido .= '<div class="table-responsive">';
$contenido .= '<table class="table table-bordered table-sm" style="font-size: .8em;">';
$contenido .= '<thead class="tables-bg">
<tr class>
<th class="align-middle text-center">Dimensión</th>
<th class="align-middle text-center">Aprobación del modelo prototipo</th>
<th class="align-middle text-center">Modelo</th>
<th class="align-middle text-center">Número de serie</th>
<th class="align-middle text-center">Material</th>
<th class="align-middle text-center" width="20"><img src="'.RUTA_IMG_ICONOS.'eliminar.png"></th>
</tr></thead>';
$contenido .= '<tbody>';
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$id = $row['id'];
$contenido .= '<tr>
 
<td class="p-0 m-0"><input type="text" class="form-control border-0 p-1 m-0 text-center align-middle" value="'.$row['dimension'].'" oninput="EditarEspecificaciones(this,'.$idEstacion.','.$idSenalamiento.','.$id.',2)" /></td>

<td class="p-0 m-0"><input type="text" class="form-control border-0 p-1 m-0 text-center align-middle" value="'.$row['aprobacion'].'" oninput="EditarEspecificaciones(this,'.$idEstacion.','.$idSenalamiento.','.$id.',3)" /></td>

<td class="p-0 m-0"><input type="text" class="form-control border-0 p-1 m-0 text-center align-middle" value="'.$row['modelo'].'" oninput="EditarEspecificaciones(this,'.$idEstacion.','.$idSenalamiento.','.$id.',4)" /></td>

<td class="p-0 m-0"><input type="text" class="form-control border-0 p-1 m-0 text-center align-middle" value="'.$row['no_serie'].'" oninput="EditarEspecificaciones(this,'.$idEstacion.','.$idSenalamiento.','.$id.',5)" /></td>

<td class="p-0 m-0"><input type="text" class="form-control border-0 p-1 m-0 text-center align-middle" value="'.$row['material'].'" oninput="EditarEspecificaciones(this,'.$idEstacion.','.$idSenalamiento.','.$id.',6)" /></td>

<td class="align-middle text-center" width="20"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarEspecificaciones('.$idEstacion.','.$idSenalamiento.','.$id.')"></td>
</tr>';
}
$contenido .= '</tbody>';
$contenido .= '</table>';
$contenido .= '</div>';
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

    <div class="mb-1 text-secondary">Dispensario:</div>
    <select class="form-select rounded-0" id="Dispensario">
    <option><?=$dispensario;?></option>
    
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
    <div class="mb-1 mt-2 text-secondary">Diseño:</div>
    <input type="file" class="rounded-0 form-control" id="seleccionArchivos" accept="image/*" style="font-size: .8em;">  
    <div class="text-center mt-2">
    <img id="imagenPrevisualizacion" width="150px">
    </div>
    </div>
    </div>
     	

      <hr>
      <div class="mb-1 mt-2 text-secondary">Especificaciones:</div>
    
    <?=Especificaciones($idEstacion,$idSenalamiento,$con);?>

    <div class="form-group text-end">
      <button type="button" class="btn btn-primary ms-2 btn-sm" onclick="AgregarEspecificacion(<?=$idEstacion;?>,<?=$idSenalamiento;?>)">Agregar</button>
    </div>

      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="Editar(<?=$idEstacion;?>,<?=$idSenalamiento;?>)">Editar</button>
      </div>
