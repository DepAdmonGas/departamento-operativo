<?php
require ('../../../../help.php');
$idOrganigrama = $_GET['idOrganigrama'];
$idEstacion = $_GET['idEstacion'];
$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '" . $idEstacion . "' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
    $estacion = $row_listaestacion['localidad'];
}


if ($idOrganigrama == 0) {
    $sql_organigrama = "SELECT * FROM op_rh_organigrama_estacion WHERE id_estacion = '" . $idEstacion . "' ORDER BY version DESC LIMIT 1";
} else {
    $sql_organigrama = "SELECT * FROM op_rh_organigrama_estacion WHERE id = '" . $idOrganigrama . "' ";
}


$result_organigrama = mysqli_query($con, $sql_organigrama);
$numero_organigrama = mysqli_num_rows($result_organigrama);
if ($numero_organigrama > 0) {
    while ($row_organigrama = mysqli_fetch_array($result_organigrama, MYSQLI_ASSOC)) {
        $archivo = '<img style="width: 100%" src="archivos/organigrama/' . $row_organigrama['archivo'] . '">';
    }
} else {
    $archivo = '';
}

$sql_lista = "SELECT * FROM op_rh_organigrama_estacion WHERE id_estacion = '" . $idEstacion . "' ORDER BY version DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
echo '';
if ($idEstacion == 9):
    echo '<hr>';
    echo '<div class="row"> 
        <div class="col-12 mb-3"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Autolavado</h3> </div>
        </div>';
endif;
?>
<div class="row">
    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-3">
        <?= $archivo; ?>
    </div>
    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
        <div>
            <div class="table-responsive">
                <table class="custom-table " style="font-size: .8em;" width="100%">
                    <thead class="navbar-bg">
                        <tr>
                            <th class="text-center align-middle tableStyle font-weight-bold">Versión</th>
                            <th class="text-center align-middle tableStyle font-weight-bold">Fecha y hora</th>
                            <th class="text-center align-middle tableStyle font-weight-bold">Observaciones</th>
                            <th class="align-middle text-center" width="20"><img
                                    src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <?php
                        if ($numero_lista > 0) {

                            while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
                                $id = $row_lista['id'];
                                $explode = explode(' ', $row_lista['fechacreacion']);

                                echo '<tr class="pointer" onclick="SelEstacion(' . $idEstacion . ',' . $id . ')">
                                    <th class="align-middle text-center"><b>' . $row_lista['version'] . '</b></th>
                                    <td class="align-middle">' . FormatoFecha($explode[0]) . ', ' . date("g:i a", strtotime($explode[1])) . '</td>
                                    <td class="text-center align-middle"><small>' . $row_lista['observaciones'] . '</small></td>
                                    <td class="align-middle text-center pointer" width="20" onclick="Eliminar(' . $idEstacion . ',' . $id . ')"><img src="' . RUTA_IMG_ICONOS . 'eliminar.png"></td>
                                    </tr>';
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        // verifica la estacion en la que se encuentra
        if (in_array($idEstacion, [1, 2, 3, 4, 5, 6, 7, 14])):
            echo $ClassRecursosHumanosGeneral->mostrarEstacion($idEstacion);
        endif;
        ?>
    </div>
</div>
</div>