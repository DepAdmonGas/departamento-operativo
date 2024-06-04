<?php
require('../../../app/help.php');

$sql_insert = "INSERT INTO op_ventas_dia (
idreporte_dia,
producto,
litros,
jarras,
precio_litro,
ieps
)
VALUES 
(
'".$_POST['idReporte']."',
'',
0,
0,
0,
0
)";
mysqli_query($con, $sql_insert);

//------------------
mysqli_close($con);
//------------------