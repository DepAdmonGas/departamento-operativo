<?php
require('../../../app/help.php');


	$sql = "UPDATE op_consumos_pagos_resumen SET saldo_inicial='".$_POST['total']."' WHERE id='".$_POST['id']."' ";

	if (mysqli_query($con, $sql)) {

$sql_credito = "SELECT 
op_consumos_pagos_resumen.id,
op_consumos_pagos_resumen.id_mes,
op_consumos_pagos_resumen.id_cliente,
op_consumos_pagos_resumen.saldo_inicial,
op_consumos_pagos_resumen.consumos,
op_consumos_pagos_resumen.pagos,
op_consumos_pagos_resumen.saldo_final,
op_cliente.id_estacion,
op_cliente.cuenta,
op_cliente.cliente,
op_cliente.tipo,
op_cliente.estado
FROM op_consumos_pagos_resumen
INNER JOIN op_cliente 
ON op_consumos_pagos_resumen.id_cliente = op_cliente.id
WHERE op_consumos_pagos_resumen.id = '".$_POST['id']."' ";
$result_credito = mysqli_query($con, $sql_credito);
$numero_credito = mysqli_num_rows($result_credito);

while($row_credito = mysqli_fetch_array($result_credito, MYSQLI_ASSOC)){

$saldofinalC = $row_credito['saldo_inicial'] + $row_credito['consumos'] - $row_credito['pagos'];

}

$sql1 = "UPDATE op_consumos_pagos_resumen SET saldo_final='".$saldofinalC."' WHERE id='".$_POST['id']."' ";
if (mysqli_query($con, $sql1)) {
echo "$ ".number_format($saldofinalC,2);
}
	
	} else {
	echo 0;
	}

//------------------
mysqli_close($con);
//------------------
?>