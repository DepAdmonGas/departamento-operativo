<?php 
require('../../app/help.php');

date_default_timezone_set('America/Mexico_City');
$fecha_del_dia = date("Y-m-d");
$fechaval = date("Y-m-d",strtotime($fecha_del_dia."- 2 days"));

$sql_listadia = "SELECT id, fecha FROM op_corte_dia WHERE ventas = 0 AND fecha < '".$fechaval."' ";
$result_listadia = mysqli_query($con, $sql_listadia);
$numero_listadia = mysqli_num_rows($result_listadia);
while($row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC)){
$id = $row_listadia['id'];

EditCorte($id, $con);
}

function EditCorte($id, $con){

$sql_edit = "UPDATE op_corte_dia SET 
    ventas = 1,
    tpv = 1,
    monedero = 1
    WHERE id = '".$id."' ";
mysqli_query($con, $sql_edit); 

}

//------------------
mysqli_close($con);
//------------------



