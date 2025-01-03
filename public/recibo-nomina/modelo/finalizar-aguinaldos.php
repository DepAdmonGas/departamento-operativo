<?php
require('../../../app/help.php');

$idAguinaldo = $_POST['idAguinaldo'];

$sql_edit1 = "UPDATE op_recibo_nomina_aguinaldo SET 
status = 1 WHERE id = '".$idAguinaldo."'";

if(mysqli_query($con, $sql_edit1)){
echo 1;
    
}else{
echo 0;
} 

?>