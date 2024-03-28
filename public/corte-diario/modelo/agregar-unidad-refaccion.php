<?php
require('../../../app/help.php');

$idRefaccion = $_POST['id'];
$MasUnidades = $_POST['Unidades'];

$sql_lista = "SELECT unidad FROM op_refacciones WHERE id = '".$idRefaccion."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$unidad = $row_lista['unidad'];
}

$totalUnidades = $unidad + $MasUnidades;


  $sql_insert2 = "INSERT INTO op_refacciones_unidades (
        id_refaccion,
        unidad
    )
    VALUES 
    (
    '".$idRefaccion."',
    '".$MasUnidades."'
    )"; 

    if(mysqli_query($con, $sql_insert2)){

    $sql_edit = "UPDATE op_refacciones SET 
    unidad = '".$totalUnidades."'
    WHERE id='".$idRefaccion."' ";
    mysqli_query($con, $sql_edit);

    echo 1;
    }else{
    echo 0;    
    }


 //------------------
mysqli_close($con);
//------------------