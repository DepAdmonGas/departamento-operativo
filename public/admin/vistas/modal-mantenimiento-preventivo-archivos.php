<?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

?>


  <div class="modal-header">
  <h5 class="modal-title">Prueba de Eficiencia</h5>   
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>

  <div class="modal-body">

  <div class="row">
           
  <div class="col-12 mb-2">
  <div class="mb-1 text-secondary">Fecha:</div>
  <input class="form-control" type="date" id="Fecha">
  </div>
 
  <div class="col-12 mb-2 mb-2">
  <div class="mb-1 text-secondary">Archivo:</div>
  <input class="form-control" type="file" id="Archivo">
  </div>

  </div>

<div class="table-responsive">
<table class="custom-table" style="font-size: .9em;" width="100%">

<thead class="tables-bg">
          <th class="text-center align-middle font-weight-bold">Fecha</th>
            <th class="text-center align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
            <th class="text-center align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
 </thead> 

        <tbody class="bg-light">
         <?php

$sql_lista = "SELECT * FROM op_mantenimiento_preventivo_documentos WHERE id_estacion = '".$idEstacion."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

echo '<tr>'; 
echo '<td class="align-middle text-center no-hover2">'.$ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha']).'</td>';
echo '<td class="align-middle text-center no-hover2"><a href="'.RUTA_ARCHIVOS.'prueba-eficiencia/'.$row_lista['archivo'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '<td class="align-middle text-center no-hover2"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarPrueba('.$id.','.$idEstacion.')"></td>';
echo '</tr>';

$num++;
}
}else{
echo "<tr><th colspan='8' class='text-center text-secondary fw-normal no-hover2'><small>No se encontró información para mostrar </small></th></tr>";
}
?> 
        </tbody>
      </table>
    </div>

</div>
<div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-success mb-3" onclick="GuardarArchivo(<?=$idEstacion?>)">
  <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>

  </div>
