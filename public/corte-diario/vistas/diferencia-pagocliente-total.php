<?php
require('../../../app/help.php');

    $idReporte = $_GET['idReporte'];

     $sql_listaclientes = "SELECT * FROM op_pago_clientes WHERE idreporte_dia = '".$idReporte."' ";
    $result_listaclientes = mysqli_query($con, $sql_listaclientes);
    while($row_listaclientes = mysqli_fetch_array($result_listaclientes, MYSQLI_ASSOC)){
    $importe = $row_listaclientes['importe'];

    $totalImporte = $totalImporte + $importe;
    }

    $sql_listacontrol = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '".$idReporte."' ";
    $result_listacontrol = mysqli_query($con, $sql_listacontrol);
    while($row_listacontrol = mysqli_fetch_array($result_listacontrol, MYSQLI_ASSOC)){

    $pago = $pago + $row_listacontrol['pago'];
    
    }

echo "<strong>".number_format($pago - $totalImporte,2)."</strong>";

    //------------------
mysqli_close($con);
//------------------