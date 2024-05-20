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

?>

<div class="row">
    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-3">
        <?= $archivo; ?>
    </div>
    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-3">
        
            <div class="p-3">
                <div class="row">
                    <div class="col-12 mb-2">
                        <div class="float-end pointer"><img src="<?= RUTA_IMG_ICONOS; ?>agregar.png"
                                onclick="Mas(<?= $idEstacion; ?>)">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="custom-table mt-2" style="font-size: .8em;" width="100%">
                        <thead class="tables-bg">
                            <tr>
                                <th class="text-center align-middle tableStyle font-weight-bold">Versión</th>
                                <th class="text-center align-middle tableStyle font-weight-bold">Fecha y hora</th>
                                <th class="text-center align-middle tableStyle font-weight-bold">Observaciones</th>
                                <th class="align-middle text-center" width="20"><img
                                        src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-light">
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
        if ($idEstacion == 1) {
            echo '<div class="border p-3 mt-3">
                <div class="row">
                <div class="col-12">
                <table class="table table-bordered table-sm mb-0">
                <tbody class="text-center">

                <tr class="tables-bg">
                <td><b>Nombre de la empresa</b></td>
                <td><b>Administradora de Gasolineras Interlomas</b></td>
                </tr>

                <tr>
                <th>Registro Patronal</th>
                <td>AGI990422EL7</td>
                </tr>

                <tr>
                <th>Calle</th>
                <td>Boulevard Magnocentro</td>
                </tr>

                <tr>
                <th>Numero Ext.</th>
                <td>8</td>
                </tr>

                <tr>
                <th>Numero Int. </th>
                <td></td>
                </tr>

                <tr>
                <th>Colonia</th>
                <td>Bosque de las Palmas</td>
                </tr>

                <tr>
                <th>Codigo Postal</th>
                <td>52787</td>
                </tr>

                <tr>
                <th>Estado</th>
                <td>México</td>
                </tr>

                <tr>
                <th>Municipio</th>
                <td>Huixquilucan</td>
                </tr>

                <tr>
                <th>Numero de telefono</th>
                <td>55 5291 7577</td>
                </tr>


                </tbody>
                </table>
                </div>
                </div>
                </div>';

        } else if ($idEstacion == 2) {
            echo '<div class="p-3 mt-3">
                <div class="row">
                <div class="col-12">
                <table class="table table-bordered table-sm mb-0">
                <tbody class="text-center">

                <tr class="tables-bg">
                <td><b>Nombre de la empresa</b></td>
                <td><b>Administradora de Gasolineras SA de CV (Palo Solo)</b></td>
                </tr>

                <tr>
                <th>Registro Patronal</th>
                <td>AGA960830CW6</td>
                </tr>

                <tr>
                <th>Calle</th>
                <td>Av. Palo Solo</td>
                </tr>

                <tr>
                <th>Numero Ext.</th>
                <td>3515</td>
                </tr>

                <tr>
                <th>Numero Int. </th>
                <td></td>
                </tr>

                <tr>
                <th>Colonia</th>
                <td>Palo Solo</td>
                </tr>

                <tr>
                <th>Codigo Postal</th>
                <td>52778</td>
                </tr>

                <tr>
                <th>Estado</th>
                <td>México</td>
                </tr>

                <tr>
                <th>Municipio</th>
                <td>Huixquilucan</td>
                </tr>

                <tr>
                <th>Numero de telefono</th>
                <td>55 5291 2673</td>
                </tr>


                </tbody>
                </table>
                </div>
                </div>
                </div>';
        } else if ($idEstacion == 3) {
            echo '<div class="border p-3 mt-3">
            <div class="row">
            <div class="col-12">
            <table class="table table-bordered table-sm mb-0">
            <tbody class="text-center">

            <tr class="tables-bg">
            <td><b>Nombre de la empresa</b></td>
            <td><b>Administradora de Gasolineras San Agustin</b></td>
            </tr>

            <tr>
            <th>Registro Patronal</th>
            <td>AGS9904221T6</td>
            </tr>

            <tr>
            <th>Calle</th>
            <td>Calzada San Agustin</td>
            </tr>
            
            <tr>
            <th>Numero Ext.</th>
            <td>1</td>
            </tr>

            <tr>
            <th>Numero Int. </th>
            <td></td>
            </tr>

            <tr>
            <th>Colonia</th>
            <td>Diez de Abril</td>
            </tr>

            <tr>
            <th>Codigo Postal</th>
            <td>53320</td>
            </tr>

            <tr>
            <th>Estado</th>
            <td>México</td>
            </tr>

            <tr>
            <th>Municipio</th>
            <td>Naucalpan de Juárez</td>
            </tr>

            <tr>
            <th>Numero de telefono</th>
            <td>55 5236 5090</td>
            </tr>


            </tbody>
            </table>
            </div>
            </div>
            </div>';
        } else if ($idEstacion == 4) {
            echo '<div class="border p-3 mt-3">
            <div class="row">
            <div class="col-12">
            <table class="table table-bordered table-sm mb-0">
            <tbody class="text-center">

            <tr class="tables-bg">
            <td><b>Nombre de la empresa</b></td>
            <td><b>Gasomira SA de CV</b></td>
            </tr>

            <tr>
            <th>Registro Patronal</th>
            <td>GAS031201398</td>
            </tr>

            <tr>
            <th>Calle</th>
            <td>Carretera Rio Hondo Huixquilucan</td>
            </tr>

            <tr>
            <th>Numero Ext.</th>
            <td>401</td>
            </tr>

            <tr>
            <th>Numero Int. </th>
            <td></td>
            </tr>

            <tr>
            <th>Colonia</th>
            <td>La Magdalena Chichicaspa</td>
            </tr>

            <tr>
            <th>Codigo Postal</th>
            <td>53320</td>
            </tr>

            <tr>
            <th>Estado</th>
            <td>México</td>
            </tr>

            <tr>
            <th>Municipio</th>
            <td>Huixquilucan</td>
            </tr>

            <tr>
            <th>Numero de telefono</th>
            <td>55 8288 9447</td>
            </tr>


            </tbody>
            </table>
            </div>
            </div>
            </div>';


        } else if ($idEstacion == 5) {
            echo '<div class="border p-3 mt-3">
            <div class="row">
            <div class="col-12">
            <table class="table table-bordered table-sm mb-0">
            <tbody class="text-center">

            <tr class="tables-bg">
            <td><b>Nombre de la empresa</b></td>
            <td><b>Gasolineras Valle de Guadalupe</b></td>
            </tr>

            <tr>
            <th>Registro Patronal</th>
            <td>GVG031014GU6</td>
            </tr>

            <tr>
            <th>Calle</th>
            <td>Lago de Guadalupe</td>
            </tr>

            <tr>
            <th>Numero Ext.</th>
            <td>Km 5.5</td>
            </tr>

            <tr>
            <th>Numero Int. </th>
            <td></td>
            </tr>

            <tr>
            <th>Colonia</th>
            <td>Villas de la Hacienda</td>
            </tr>

            <tr>
            <th>Codigo Postal</th>
            <td>52929</td>
            </tr>

            <tr>
            <th>Estado</th>
            <td>México</td>
            </tr>

            <tr>
            <th>Municipio</th>
            <td>Atizapán de Zaragoza</td>
            </tr>

            <tr>
            <th>Numero de telefono</th>
            <td>55 5236 5090</td>
            </tr>


            </tbody>
            </table>
            </div>
            </div>
            </div>';



        } else if ($idEstacion == 6) {
            echo '<div class="border p-3 mt-3">
            <div class="row">
            <div class="col-12">
            <table class="table table-bordered table-sm mb-0">
            <tbody class="text-center">

            <tr class="tables-bg">
            <td><b>Nombre de la empresa</b></td>
            <td><b>Administradora de Gasolineras Esmegas</b></td>
            </tr>

            <tr>
            <th>Registro Patronal</th>
            <td>C-22-33658-10-5</td>
            </tr>

            <tr>
            <th>Calle</th>
            <td>Av. Jorge Jimenez Cantu</td>
            </tr>

            <tr>
            <th>Numero Ext.</th>
            <td>30</td>
            </tr>

            <tr>
            <th>Numero Int. </th>
            <td></td>
            </tr>

            <tr>
            <th>Colonia</th>
            <td>Bosque Esmeralda</td>
            </tr>

            <tr>
            <th>Codigo Postal</th>
            <td>52930</td>
            </tr>

            <tr>
            <th>Estado</th>
            <td>México</td>
            </tr>

            <tr>
            <th>Municipio</th>
            <td>Atizapán de Zaragoza</td>
            </tr>

            <tr>
            <th>Numero de telefono</th>
            <td>55 2165 5521</td>
            </tr>


            </tbody>
            </table>
            </div>
            </div>
            </div>';



        } else if ($idEstacion == 7) {
            echo '<div class="border p-3 mt-3">
            <div class="row">
            <div class="col-12">
            <table class="table table-bordered table-sm mb-0">
            <tbody class="text-center">

            <tr class="tables-bg">
            <td><b>Nombre de la empresa</b></td>
            <td><b>Administradora de Gasolineras Xochimilco</b></td>
            </tr>

            <tr>
            <th>Registro Patronal</th>
            <td>Z-39-14304-10-3</td>
            </tr>

            <tr>
            <th>Calle</th>
            <td>Prolongación División del Norte</td>
            </tr>

            <tr>
            <th>Numero Ext.</th>
            <td>5322</td>
            </tr>

            <tr>
            <th>Numero Int.</th>
            <td></td>
            </tr>

            <tr>
            <th>Colonia</th>
            <td>Ampliación San Marcos Norte</td>
            </tr>

            <tr>
            <th>Codigo Postal</th>
            <td>16038</td>
            </tr>

            <tr>
            <th>Estado</th>
            <td>Ciudad de México</td>
            </tr>

            <tr>
            <th>Municipio</th>
            <td>Xochimilco</td>
            </tr>

            <tr>
            <th>Numero de telefono</th>
            <td>55 5334 9220</td>
            </tr>


            </tbody>
            </table>
            </div>
            </div>
            </div>';

        } else if ($idEstacion == 14) {
            echo '<div class="border p-3 mt-3">
            <div class="row">
            <div class="col-12">
            <table class="table table-bordered table-sm mb-0">
            <tbody class="text-center">

            <tr class="tables-bg">
            <td><b>Nombre de la empresa</b></td>
            <td><b>Administradora de Gasolinerias Bosque Real</b></td>
            </tr>

            <tr>
            <th>Registro Patronal</th>
            <td>AGB160722SP1</td>
            </tr>

            <tr>
            <th>Calle</th>
            <td>Rio Hondo-Huixquilucan</td>
            </tr>

            <tr>
            <th>Numero Ext.</th>
            <td>Km 8.22 Lote 5 </td>
            </tr>

            <tr>
            <th>Numero Int. </th>
            <td></td>
            </tr>

            <tr>
            <th>Colonia</th>
            <td>Bosque Real</td>
            </tr>

            <tr>
            <th>Codigo Postal</th>
            <td>52774</td>
            </tr>

            <tr>
            <th>Estado</th>
            <td>México</td>
            </tr>

            <tr>
            <th>Municipio</th>
            <td>Huixquilucan</td>
            </tr>

            <tr>
            <th>Numero de telefono</th>
            <td>55 9155 7395</td>
            </tr>


            </tbody>
            </table>
            </div>
            </div>
            </div>';
        }
        ?>
    </div>
</div>
</div>