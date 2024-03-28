<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];
$idFuncion = $_GET['idFuncion'];

if($idFuncion == 0){
$botonFunction = '<button type="button" class="btn btn-success" onclick="AgregarEstacion('.$idReporte.','.$idFuncion.')">Agregar</button>';
$nameModal = "Agregar";
}else if($idFuncion == 1){
$botonFunction = '<button type="button" class="btn btn-success" onclick="AgregarEstacion('.$idReporte.','.$idFuncion.')">Editar</button>';
$nameModal = "Editar";
}

?>


<div class="modal-header">
<h5 class="modal-title"><?=$nameModal?> estacion</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


  <div class="modal-body">

      <div class="mb-1 text-secondary">Estacion:</div>
      <select class="form-select" id="estacionName">
          <option></option>
        <?php 
        $sql = "SELECT id, localidad FROM op_rh_localidades WHERE numlista <= 8 OR (numlista BETWEEN 22 AND 23)";
        $result = mysqli_query($con, $sql);
        $numero = mysqli_num_rows($result);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $id = $row['id'];
        $nombreES = $row['localidad'];

        echo '<option value="'.$id.'">'.$nombreES.'</option>';
        }        
        ?>
        </select>

  </div>


  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <?=$botonFunction?>
   </div>
   