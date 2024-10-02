<?php 
require('../../../../help.php');
$idEstacion = $_GET['idEstacion'];

if($idEstacion == 8){
  $consulta = "AND id_puesto = 6";
}else{
  $consulta = "";	
}

  $sql_personal = "SELECT id, nombre FROM tb_usuarios WHERE id_gas = ".$idEstacion." AND estatus = 0 ".$consulta." ORDER BY nombre ASC";
  $result_personal = mysqli_query($con, $sql_personal);
  $numero_personal = mysqli_num_rows($result_personal);

?>

<select class="form-select titulos" id="Cubre">

<?php
 while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
 $idUser = $row_personal['id'];
 $nombreUser = $row_personal['nombre']; 

  echo '<option value="'.$idUser.'">'.$nombreUser.'</option>';

 }

 echo '<option value="471">Jonathan Armando Legorreta Cano</option>';

?>

</select>


