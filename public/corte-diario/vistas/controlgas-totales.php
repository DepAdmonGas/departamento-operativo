<?php
require('../../../app/help.php');

    $idReporte = $_GET['idReporte'];

   $sql_listacontrol = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '".$idReporte."' ";
    $result_listacontrol = mysqli_query($con, $sql_listacontrol);
    $pago = 0;
    $consumo = 0;
    while($row_listacontrol = mysqli_fetch_array($result_listacontrol, MYSQLI_ASSOC)){

    $pago = $pago + $row_listacontrol['pago'];
    $consumo = $consumo + $row_listacontrol['consumo'];
    
    }

    ?>

    <th class="bg-light text-center">TOTAL 3</th>
    <td class="bg-light align-middle text-end"><strong><?=number_format($pago,2);?></strong></td>
    <td class="bg-light align-middle text-end"><strong><?=number_format($consumo,2);?></strong></td>