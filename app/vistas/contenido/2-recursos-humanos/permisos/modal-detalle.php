<?php
require ('../../../../help.php');
$idPermiso = $_GET['idPermiso'];

function Estacion($idEstacion, $con)
{
    $sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '" . $idEstacion . "' ";
    $result_listaestacion = mysqli_query($con, $sql_listaestacion);
    while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
        $estacion = $row_listaestacion['localidad'];
    }
    return $estacion;
}

function Responsable($idUsuario, $con)
{
    $sql_usuario = "SELECT 
tb_usuarios.nombre AS nombreUSU,
tb_estaciones.nombre AS nombrebreES
FROM tb_usuarios
INNER JOIN tb_estaciones
on tb_usuarios.id_gas = tb_estaciones.id
WHERE tb_usuarios.id = '" . $idUsuario . "'";

    $result_usuario = mysqli_query($con, $sql_usuario);
    while ($row_usuario = mysqli_fetch_array($result_usuario, MYSQLI_ASSOC)) {
        $usuario = $row_usuario['nombreUSU'];
        $estacion = $row_usuario['nombrebreES'];
    }
    $array = array('nombreUSU' => $usuario, 'nombrebreES' => $estacion);
    return $array;
}


$sql_lista = "SELECT * FROM op_rh_permisos WHERE id = '" . $idPermiso . "' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
    $id = $row_lista['id'];
    $idestacion = $row_lista['id_estacion'];
    $idpersonal = $row_lista['id_personal'];

    $Estacion = Estacion($idestacion, $con);
    $Responsable = Responsable($idpersonal, $con);
    $nameUSUR = $Responsable['nombreUSU'];


    $diastomados = $row_lista['dias_tomados'];
    $observaciones = $row_lista['observaciones'];
    $FechaInicio = $row_lista['fecha_inicio'];
    $FechaTermino = $row_lista['fecha_termino'];
    $Motivo = $row_lista['motivo'];

    $idComodin = $row_lista['cubre_turno'];
    $Comodin = Responsable($idComodin, $con);

    $nameUSU = $Comodin['nombreUSU'];
    $nameES = $Comodin['nombrebreES'];

}

function Personal($idusuario, $con)
{
    $sql = "SELECT nombre FROM tb_usuarios WHERE id = '" . $idusuario . "' ";
    $result = mysqli_query($con, $sql);
    $numero = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $nombre = $row['nombre'];
    }
    return $nombre;
}

function FirmaSC($idReporte, $tipoFirma, $con)
{
    $sql_lista = "SELECT * FROM op_rh_permisos_firma WHERE id_permiso = '" . $idReporte . "' AND tipo_firma = '" . $tipoFirma . "' ";
    $result_lista = mysqli_query($con, $sql_lista);
    return $numero_lista = mysqli_num_rows($result_lista);
}

$firmaB = FirmaSC($idPermiso, 'B', $con);
$firmaC = FirmaSC($idPermiso, 'C', $con);

?>


<div class="modal-header">
    <h5 class="modal-title">Detalle permiso</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

    <div class="row">

        <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-2">
            <small class="mb-1 text-secondary ">Estación:</small>
            <div class=""><?= $Estacion; ?></div>
        </div>

        <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-2">
            <small class="mb-1 text-secondary ">Colaborador:</small>
            <div class=""><?= $nameUSUR; ?></div>
        </div>

        <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-2">
            <small class="mb-1 text-secondary ">Días tomados:</small>
            <div class=""><?= $diastomados; ?></div>
        </div>


        <div class="col-12">
            <div class="row">

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                    <small class="text-secondary">Del:</small>
                    <div><?= FormatoFecha($FechaInicio); ?></div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                    <small class="text-secondary">Hasta:</small>
                    <div><?= FormatoFecha($FechaTermino); ?></div>
                </div>

                <div class="col-6 mb-3">
                    <small class="text-secondary">Estacion de quien cubre:</small>
                    <div><?= $nameES; ?></div>
                </div>

                <div class="col-6">
                    <small class="text-secondary">Quien cubre:</small>
                    <div><?= $nameUSU; ?></div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                    <small class="text-secondary">Motivo:</small>
                    <div><?= $Motivo; ?></div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                    <small class="text-secondary">Observaciones:</small>
                    <div><?= $observaciones; ?></div>
                </div>

            </div>
        </div>
    </div>


    <hr>

    <div class="row">

        <?php

        $sql_firma = "SELECT * FROM op_rh_permisos_firma WHERE id_permiso = '" . $idPermiso . "' ";
        $result_firma = mysqli_query($con, $sql_firma);
        $numero_firma = mysqli_num_rows($result_firma);
        while ($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)) {

            $explode = explode(' ', $row_firma['fecha']);

            if ($row_firma['tipo_firma'] == "A") {
                $TipoFirma = "NOMBRE Y FIRMA DEL QUE SOLICITA";
                $Detalle = '<div class="border p-1 text-center"><img src="' . RUTA_IMG . 'firma/' . $row_firma['firma'] . '" width="70%"></div>';


            } else if ($row_firma['tipo_firma'] == "B") {
                $TipoFirma = "NOMBRE Y FIRMA DEL QUE CUBRE";
                $Detalle = '<div class="border p-1 text-center"><img src="' . RUTA_IMG . 'firma/' . $row_firma['firma'] . '" width="70%"></div>';

            } else if ($row_firma['tipo_firma'] == "C") {
                $TipoFirma = "NOMBRE Y FIRMA DE VoBo";
                $Detalle = '<div class="border-bottom text-center p-3"><small>La solicitud de permiso se firmó por un medio electrónico.</br> <b>Fecha: ' . FormatoFecha($explode[0]) . ', ' . date("g:i a", strtotime($explode[1])) . '</b></small></div>';


            }

            echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">';
            echo '<div class="border p-3">';
            echo '<div class="text-center">' . Personal($row_firma['id_usuario'], $con) . ' <hr> </div>';
            echo $Detalle;
            echo '<h6 class="mt-2 text-secondary text-center">' . $TipoFirma . '</h6>';
            echo '</div>';
            echo '</div>';
        }



        if ($firmaB == 0) {
            echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mt-2 mb-3"><div class="text-center alert alert-warning" role="alert">
¡Falta firma del personal que cubre!
</div></div>';
        }

        if ($firmaC == 0) {
            echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mt-2 mb-3"><div class="text-center alert alert-warning" role="alert">
¡Falta firma del VoBo!
</div></div>';
        }


        ?>

    </div>

</div>


<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
</div>