<?php
require ('../../../../help.php');
$idPermiso = $_GET['idPermiso'];

$sql_lista = "SELECT * FROM op_rh_permisos WHERE id = '" . $idPermiso . "' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
    $id = $row_lista['id'];
    $idestacion = $row_lista['id_estacion'];
    $idpersonal = $row_lista['id_personal'];

    $datosLocalidad = $ClassHerramientasDptoOperativo-> obtenerDatosLocalidades($idestacion);
    $Estacion = $datosLocalidad['localidad'];

    $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($idpersonal);
    $nameUSUR = $datosPersonal['nombre'];
     
    $diastomados = $row_lista['dias_tomados'];
    $observaciones = $row_lista['observaciones'];
    $FechaInicio = $row_lista['fecha_inicio'];
    $FechaTermino = $row_lista['fecha_termino'];
    $Motivo = $row_lista['motivo'];
    
    $idComodin = $row_lista['cubre_turno'];
    $datosPersonalC = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($idComodin);
    $nameUSU = $datosPersonalC['nombre'];
    $nameES = $datosPersonalC['nombreES'];
}



  function FirmaSC($idReporte, $tipoFirma, $con){
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
            <small class="mb-1 text-secondary ">ESTACIÓN:</small>
            <div class=""><?= $Estacion; ?></div>
        </div>

        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-2">
            <small class="mb-1 text-secondary ">COLABORADOR:</small>
            <div class=""><?= $nameUSUR; ?></div>
        </div>



        <div class="col-12">
            <div class="row">

                <div class="col-xl-5 col-lg-5 col-md-6 col-sm-12 mb-2">
                    <small class="text-secondary">DEL:</small>
                    <div><?=$ClassHerramientasDptoOperativo->FormatoFecha($FechaInicio); ?></div>
                </div>

                <div class="col-xl-5 col-lg-5 col-md-6 col-sm-12 mb-2">
                    <small class="text-secondary">HASTA:</small>
                    <div><?=$ClassHerramientasDptoOperativo->FormatoFecha($FechaTermino); ?></div>
                </div>


                <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-2">
                <small class="mb-1 text-secondary ">DÍAS TOMADOS:</small>
                <div class=""><?= $diastomados; ?></div>
                </div>

                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-2">
                <small class="text-secondary">ESTACION DE QUIEN CUBRE:</small>
                    <div><?= $nameES; ?></div>
                </div>

                <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-2">
                <small class="text-secondary">QUIEN CUBRE:</small>
                    <div><?= $nameUSU; ?></div>
                </div>

                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-2">
                <small class="text-secondary">MOTIVO:</small>
                    <div><?= $Motivo; ?></div>
                </div>

                <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-2">
                    <small class="text-secondary">OBSERVACIONES:</small>
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
                $Detalle = '<div class="border-0 p-1 text-center"><img src="' . RUTA_IMG . 'firma/' . $row_firma['firma'] . '" width="70%"></div>';


            } else if ($row_firma['tipo_firma'] == "B") {
                $TipoFirma = "NOMBRE Y FIRMA DEL QUE CUBRE";
                $Detalle = '<div class="border-0 p-1 text-center"><img src="' . RUTA_IMG . 'firma/' . $row_firma['firma'] . '" width="70%"></div>';

            } else if ($row_firma['tipo_firma'] == "C") {
                $TipoFirma = "NOMBRE Y FIRMA DE VoBo";
                $Detalle = '<div class="border-0 text-center p-3"><small>La solicitud de permiso se firmó por un medio electrónico.</br> <b>Fecha: ' . FormatoFecha($explode[0]) . ', ' . date("g:i a", strtotime($explode[1])) . '</b></small></div>';


            }

            $datosUsuario = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($row_firma['id_usuario']);
            $NomUsuario = $datosUsuario['nombre'];
        

            echo '  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-1 mt-1">
            <table class="custom-table" style="font-size: 14px;" width="100%">
            <thead class="tables-bg">
            <tr> <th class="align-middle text-center">'.$NomUsuario.'</th> </tr>
            </thead>
            <tbody class="bg-light">
            <tr>
            <th class="align-middle text-center no-hover2">'.$Detalle.'</th>
            </tr>
          
            <tr>
            <th class="align-middle text-center no-hover2">'.$TipoFirma.'</th>
            </tr>
            
            </tbody>
            </table>
            </div>';
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
<button type="button" class="btn btn-labeled2 btn-danger" data-bs-dismiss="modal">
<span class="btn-label2"><i class="fa fa-xmark"></i></span>Cerrar</button>
</div>