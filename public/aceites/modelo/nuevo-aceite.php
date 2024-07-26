<?php
require('../../../app/help.php');

$sql_listaaceite = "SELECT id, id_aceite FROM op_aceites ORDER BY id_aceite DESC LIMIT 1";
$result_listaaceite = mysqli_query($con, $sql_listaaceite);
while($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)){
$anterior = $row_listaaceite['id_aceite'];
$idAceite = $row_listaaceite['id_aceite'] + 1;
}


$sql_insert = "INSERT INTO op_aceites (
id_aceite,
concepto,
piezas,
precio
)
VALUES 
(
'".$idAceite."',
'',
0,
0
)";
mysqli_query($con, $sql_insert);


echo $anterior;

//------------------
mysqli_close($con);
//------------------  