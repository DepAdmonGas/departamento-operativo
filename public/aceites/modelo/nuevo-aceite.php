<?php
require('../../../app/help.php');

$sql_listaaceite = "SELECT id FROM op_aceites ORDER BY id DESC LIMIT 1";
$result_listaaceite = mysqli_query($con, $sql_listaaceite);
while($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)){
$anterior = $row_listaaceite['id'];
$idAceite = $row_listaaceite['id'] + 1;
}

$sql_insert = "INSERT INTO op_aceites (
id,
id_aceite,
concepto,
piezas,
precio
)
VALUES 
(
'".$idAceite."',
'',
'',
0
)";
mysqli_query($con, $sql_insert);


echo $anterior;

//------------------
mysqli_close($con);
//------------------