<?php
require('../../../app/help.php');

    $idReporte = $_GET['idReporte'];

    $sql_listaprosegur = "SELECT * FROM op_prosegur WHERE idreporte_dia = '".$idReporte."' ";
    $result_listaprosegur = mysqli_query($con, $sql_listaprosegur);
    while($row_listaprosegur = mysqli_fetch_array($result_listaprosegur, MYSQLI_ASSOC)){
    $importe = $row_listaprosegur['importe'];

    $totalImporte = $totalImporte + $importe;
    }

    $sql_listatarjetas = "SELECT * FROM op_tarjetas_c_b WHERE idreporte_dia = '".$idReporte."' ";
    $result_listatarjetas = mysqli_query($con, $sql_listatarjetas);
    while($row_listatarjetas = mysqli_fetch_array($result_listatarjetas, MYSQLI_ASSOC)){
    
    $baucherTotal = $baucherTotal + $row_listatarjetas['baucher'];
    }

    $sql_listacontrol = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '".$idReporte."' ";
    $result_listacontrol = mysqli_query($con, $sql_listacontrol);
    while($row_listacontrol = mysqli_fetch_array($result_listacontrol, MYSQLI_ASSOC)){

    $consumo = $consumo + $row_listacontrol['consumo'];
    
    }

    echo "<strong>".number_format($totalImporte + $baucherTotal + $consumo,2)."</strong>";


    //------------------
mysqli_close($con);
//------------------ 




   