<?php
require('../../../app/help.php');

$sql_insert = "INSERT INTO op_cierre_lote (
idreporte_dia,
empresa,
no_cierre_lote,
importe,
ticktes
)
VALUES 
(
'".$_POST['idReporte']."',
'".$_POST['empresa']."',
'',
0,
0
)";
mysqli_query($con, $sql_insert);

//------------------
mysqli_close($con);
//------------------