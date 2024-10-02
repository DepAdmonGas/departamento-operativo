<?php 
require('../../../app/help.php');

if($_POST['Concepto'] == ""){

$nombre = $_POST['Otro'];
$unidad = 0;

}else{

$sql_lista = "SELECT * FROM op_refacciones WHERE id = '".$_POST['Concepto']."' AND status = 1";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$nombre = $row_lista['nombre'];
$unidad = $row_lista['unidad'];    
}
}

if($unidad == 0){
$Nota = 'No se cuenta con piezas en almacén, se creará una orden de compra.';
}else{

if($unidad < $_POST['Cantidad']){

$Faltante = $_POST['Cantidad'] - $unidad;

$Nota = 'Solo se cuenta con '.$unidad.' refacciones, se creará una orden de compra para las refacciones faltantes.'; 
}else{
$Nota = 'La refacción estará en la estación en 5 horas mínimo.';    
}

}


    $sql_insert = "INSERT INTO op_pedido_materiales_detalle (
    id_pedido,
    refaccion,
    concepto,
    cantidad,
    nota
    )
    VALUES 
    (
    '".$_POST['idPedido']."',
    '".$_POST['Concepto']."',
    '".$nombre."',
    '".$_POST['Cantidad']."',
    '".$Nota."'
    )"; 

    mysqli_query($con, $sql_insert);

//------------------
mysqli_close($con);
//------------------