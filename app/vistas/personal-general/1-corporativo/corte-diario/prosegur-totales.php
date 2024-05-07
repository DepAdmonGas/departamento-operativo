<?php
require('../../../../help.php');

    $idReporte = $_GET['idReporte'];

    $sql_listaprosegur = "SELECT * FROM op_prosegur WHERE idreporte_dia = '".$idReporte."' ";
    $result_listaprosegur = mysqli_query($con, $sql_listaprosegur);
    $totalImporte = 0;
    while($row_listaprosegur = mysqli_fetch_array($result_listaprosegur, MYSQLI_ASSOC)){
    $importe = $row_listaprosegur['importe'];

    $totalImporte = $totalImporte + $importe;
    }

    ?>

    <th class="bg-light text-center" colspan="2">TOTAL 1</th>
    <td class="bg-light align-middle text-end"><strong><?=number_format($totalImporte,2);?></strong></td>