<?php
require('../../../app/help.php');

$idEstacion = $_POST['idER'];
?>

 <select class="form-control rounded-0" id="RefaccionE">
 <option value="0"></option>
 <?php 
 $sqlRS = "SELECT * FROM op_refacciones WHERE id_estacion = '".$idEstacion."' AND status = 1 ORDER BY id ASC";
 $resultRS = mysqli_query($con, $sqlRS);
 $numeroRS = mysqli_num_rows($resultRS);
 while($rowRS = mysqli_fetch_array($resultRS, MYSQLI_ASSOC)){
 echo '<option value="'.$rowRS['id'].'">'.$rowRS['nombre'].'</option>';
 }
 ?>
 </select>