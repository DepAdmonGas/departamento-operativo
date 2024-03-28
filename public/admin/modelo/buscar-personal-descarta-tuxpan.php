<?php
require('../../../app/help.php');

 $sql_listaestacion = "SELECT id, nombre FROM tb_usuarios WHERE id_gas = '".$_POST['idEstacion']."' AND id_puesto = 6 AND estatus = 0 ORDER BY nombre ASC";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);

  echo '<select class="form-control titulos" id="Responsable">';
  echo '<option></option>';

  while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
  $id = $row_listaestacion['id'];
  $estacion = $row_listaestacion['nombre']; 
  echo '<option value="'.$id.'">'.$estacion.'</option>';
  }
  echo '</select>';


//------------------
mysqli_close($con);
//------------------