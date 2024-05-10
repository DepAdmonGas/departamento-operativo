<?php
require('../../../../help.php');

$idEstacion = $_GET['idEstacion'];

// Obtener el número de clientes de crédito
$numero_credito = $corteDiarioGeneral->getNumeroClientesPorTipo($idEstacion, 'Crédito');

// Obtener el número de clientes de débito
$numero_debito = $corteDiarioGeneral->getNumeroClientesPorTipo($idEstacion, 'Débito');

?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
        <div class="border p-3">

            <div class="font-weight-bold text-primary" style="font-size: 1.1em;">Crédito</div>
            <hr>

            <div class="table-responsive">
                <table class="table table-sm table-bordered pb-0 mb-0">
                    <thead class="tables-bg">
                        <tr>
                            <th>Cuenta</th>
                            <th>Cliente</th>
                            <th>RFC</th>
                            <th width="20px"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png" width="20px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($numero_credito > 0) {
                            $sql_credito = "SELECT * FROM op_cliente WHERE id_estacion = '".$idEstacion."' AND tipo = 'Crédito' AND estado = 1 ";
                            $result_credito = mysqli_query($con, $sql_credito);
                            while($row_credito = mysqli_fetch_array($result_credito, MYSQLI_ASSOC)){
                                echo '<tr>
                                <td class="align-middle font-weight-light"  style="font-size: .9em;">'.$row_credito['cuenta'].'</td>
                                <td class="align-middle font-weight-light"  style="font-size: .9em;">'.$row_credito['cliente'].'</td>
                                <td class="align-middle font-weight-light"  style="font-size: .9em;">'.$row_credito['rfc'].'</td>
                                <td width="20px" class="align-middle">
                                <img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$row_credito['id'].')" width="20px">
                                </td>
                                </tr>';
                            }
                        } else {
                            echo '<tr><td colspan="2" class="text-center"><small>No se encontró información</small></td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
        <div class="border p-3">

            <div class="font-weight-bold text-success" style="font-size: 1.1em;">Débito</div>
            <hr>

            <div class="table-responsive">
                <table class="table table-sm table-bordered pb-0 mb-0">
                    <thead class="tables-bg">
                        <tr>
                            <th>Cuenta</th>
                            <th>Cliente</th>
                            <th width="20px"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png" width="20px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($numero_debito > 0) {
                            $sql_debito = "SELECT * FROM op_cliente WHERE id_estacion = '".$idEstacion."' AND tipo = 'Débito' AND estado = 1 ";
                            $result_debito = mysqli_query($con, $sql_debito);
                            while($row_debito = mysqli_fetch_array($result_debito, MYSQLI_ASSOC)){
                                echo '<tr>
                                <td class="align-middle font-weight-light" style="font-size: .9em;">'.$row_debito['cuenta'].'</td>
                                <td class="align-middle font-weight-light" style="font-size: .9em;">'.$row_debito['cliente'].'</td>
                                <td width="20px" class="align-middle">
                                <img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$row_debito['id'].')" width="20px">
                                </td>
                                </tr>';
                            }
                        } else {
                            echo '<tr><td colspan="2" class="text-center"><small>No se encontró información</small></td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>