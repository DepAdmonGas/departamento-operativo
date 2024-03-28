  <?php
require('../../../app/help.php');

$idFuncion = $_POST['idFuncion'];

if($idFuncion == 0){

  $sql = "INSERT INTO op_orden_compra_razon_social (
      id_ordencompra, 
      id_estacion
      )
      VALUES
      (
      '".$_POST['idReporte']."',
      '".$_POST['idEstacion']."'
      )";    

      }else if($idFuncion == 1){

      $sql = "UPDATE op_orden_compra_razon_social 
      SET id_estacion = '".$_POST['idEstacion']."'
      WHERE id_ordencompra =  '".$_POST['idReporte']."' ";
      }

      if(mysqli_query($con, $sql)){
      echo 1;
      }else{
      echo 0;
      }
 

//------------------
mysqli_close($con);
//------------------