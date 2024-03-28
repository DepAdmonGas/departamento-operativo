<?php 
require('../../../app/help.php');


$sql_lista = "SELECT * FROM op_refacciones_transaccion WHERE id = '".$_POST['id']."'";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$idRefaccion = $row_lista['id_refaccion'];
$idRefaccionReceptora = $row_lista['id_refaccion_receptora'];
}

$sql = "SELECT unidad FROM op_refacciones WHERE id = '".$idRefaccion."'";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$unidad = $row['unidad'];
}

$sql1 = "SELECT unidad FROM op_refacciones WHERE id = '".$idRefaccionReceptora."'";
$result1 = mysqli_query($con, $sql1);
while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)){
$unidadReceptora = $row1['unidad'];
}
 
$Piezas = $unidad + 1;
$PiezasReceptora = $unidadReceptora - 1;


if ($_POST['estado'] == "Editar"){

$sql = "UPDATE op_refacciones_transaccion SET estado = 404 WHERE id = '".$_POST['id']."' ";
if (mysqli_query($con, $sql)) {

    $sql_edit = "UPDATE op_refacciones SET 
    unidad = '".$Piezas."'
    WHERE id = '".$idRefaccion."' ";
    mysqli_query($con, $sql_edit);

    $sql_edit1 = "UPDATE op_refacciones SET 
    unidad = '".$PiezasReceptora."'
    WHERE id = '".$idRefaccionReceptora."' ";
    mysqli_query($con, $sql_edit1);

echo 1;
}else{
echo 0;
}


}else if($_POST['estado'] == "Eliminar"){

$sql = "DELETE FROM op_refacciones_transaccion WHERE id = '".$_POST['id']."' ";
if (mysqli_query($con, $sql)) {

    $sql_edit = "UPDATE op_refacciones SET 
    unidad = '".$Piezas."'
    WHERE id = '".$idRefaccion."' ";
    mysqli_query($con, $sql_edit);

    $sql_edit1 = "UPDATE op_refacciones SET 
    unidad = '".$PiezasReceptora."'
    WHERE id = '".$idRefaccionReceptora."' ";
    mysqli_query($con, $sql_edit1);

echo 1;
}else{
echo 0;
}

}





//------------------
mysqli_close($con);
//------------------
?> 