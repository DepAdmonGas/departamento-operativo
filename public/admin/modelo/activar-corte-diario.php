<?php
require('../../../app/help.php');

$sql_insert = "INSERT INTO op_corte_dia_hist (
   id_corte,
   id_usuario,
   detalle
    )
    VALUES 
    (
    '".$_POST['idDias']."',
    '".$Session_IDUsuarioBD."',
    '".$_POST['Detalle']."'
    )";

if(mysqli_query($con, $sql_insert)){

$sql = "UPDATE op_corte_dia SET ventas = 0, tpv = 0, monedero = 0 WHERE id = '".$_POST['idDias']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else{
echo 0;
 
}  
 
//------------------
mysqli_close($con);
//------------------   