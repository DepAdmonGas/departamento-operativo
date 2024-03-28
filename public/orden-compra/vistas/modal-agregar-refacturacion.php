<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];
?>
<div class="modal-header">
<h5 class="modal-title">Agregar Refacturación</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
      <div class="modal-body">

        <div class="mb-1 text-secondary">Estación:</div>
        <select class="form-select" id="Estacion">
          <option></option>
          <?php 
          $sql_listaestacion = "SELECT id, localidad FROM op_rh_localidades WHERE numlista <= 8 ORDER BY numlista ASC";
          $result_listaestacion = mysqli_query($con, $sql_listaestacion);
          while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
          $estacion = $row_listaestacion['localidad'];

          echo '<option value="'.$row_listaestacion['id'].'">'.$estacion.'</option>';
          }
          ?>
        </select>

        <div class="mb-1 mt-2 text-secondary">Descripción:</div>
        <textarea class="form-control" id="Descripcion"></textarea>

        <div class="mb-1 mt-2 text-secondary">Cantidad:</div>
        <input type="number" class="form-control" id="Cantidad">

        <div class="mb-1 mt-2 text-secondary">Importe:</div>
        <input type="number" class="form-control" id="Importe">

        <div class="mb-1 mt-2 text-secondary">Porcentaje:</div>
        <input type="number" class="form-control" id="Porcentaje">

        <div class="mb-1 mt-2 text-secondary">Estacion:</div>
        <input type="number" class="form-control" id="CantidadES">

        <div class="mb-1 mt-2 text-secondary">Almacén:</div>
        <input type="number" class="form-control" id="CantidadAl">
 
      </div>
          <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="AgregarRefacturacion(<?=$idReporte;?>)">Agregar</button>
      </div>
   