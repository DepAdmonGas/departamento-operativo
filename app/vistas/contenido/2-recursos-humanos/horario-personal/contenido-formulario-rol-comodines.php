<?php 
require('../../../../../app/help.php');
$idReporte = $_GET['idReporte'];

// Consulta del reporte
$sql_reporte = "SELECT fecha_inicio, fecha_fin FROM op_rh_rol_comodines WHERE id = '".$idReporte."'";
$result_reporte = mysqli_query($con, $sql_reporte);
$numero_reporte = mysqli_num_rows($result_reporte);

while ($row_reporte = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {
    $fechaInicio = $row_reporte['fecha_inicio'];
    $fechaTermino = $row_reporte['fecha_fin'];
}

// Consulta del personal
$sql_personal = "
    SELECT u.id, u.nombre, u.estatus 
    FROM tb_usuarios u 
    LEFT JOIN op_rh_comodines_dia c ON u.id = c.id_usuario AND c.id_reporte = '$idReporte'
    WHERE ((u.id_gas = 8 AND u.id_puesto = 6) OR u.id = 321)
    AND (u.estatus = 0 OR (u.estatus = 1 AND c.id_usuario IS NOT NULL))
    GROUP BY u.id 
    ORDER BY u.id ASC";
 
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);

function Estaciones($con) {
    $array1 = [];
    $sql_estacion = "SELECT id, nombre FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
    $result_estacion = mysqli_query($con, $sql_estacion);

    while ($row_estacion = mysqli_fetch_array($result_estacion, MYSQLI_ASSOC)) {
        $array1[] = ['id' => $row_estacion['id'], 'nombre' => $row_estacion['nombre']];
    }
    return $array1;
}

function BuscarRolComodines($dia, $idUsuario, $idReporte, $con) {
    $resultado = 0;
    $ClassHerramientasDptoOperativo = new HerramientasDptoOperativo($con);
    $NomDia = $ClassHerramientasDptoOperativo->get_nombre_dia2($dia);

    $sql_estacion = "
        SELECT id_estacion 
        FROM op_rh_comodines_dia 
        WHERE id_reporte = '$idReporte' AND id_usuario = '$idUsuario' AND dia = '$NomDia'
    ";
    $result_estacion = mysqli_query($con, $sql_estacion);

    if ($row_estacion = mysqli_fetch_array($result_estacion, MYSQLI_ASSOC)) {
        $resultado = $row_estacion['id_estacion'];
    }
    return $resultado;
}
?>


<div class="row">
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
<label class="text-secondary fw-bold">* FECHA DE INICIO:</label>
<input class="form-control" type="date" id="fechaInicio" value="<?=$fechaInicio?>">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
<label class="text-secondary fw-bold">* FECHA DE TERMINO:</label>
<input class="form-control" type="date" id="fechaTermino" value="<?=$fechaTermino?>">
</div>
</div>

<div class="table-responsive">
<table class="custom-table" style="font-size: .8em;" width="100%">

<thead class="tables-bg">
<tr>
<th class="text-center align-middle fw-bold">#</th>
<th class="align-middle text-start">Nombre completo</th>
<th class="align-middle">Día</th>
<th class="align-middle">Estación</th>
</tr>
</thead>

<tbody class="bg-light">
<?php
$Estaciones = Estaciones($con);

if ($numero_personal > 0) {
while ($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)) {
$id = $row_personal['id'];
$nombre = $row_personal['nombre'];

// Obtener las estaciones por día
$Dias = [];
for ($dia = 1; $dia <= 7; $dia++) {
$Dias[] = BuscarRolComodines($dia, $id, $idReporte, $con);
}

// Array con los nombres de los días de la semana
$nombresDias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

                    // Solo imprimir el rowspan una vez por persona
                    echo '<tr>';
                    echo '<th class="text-center align-middle fw-normal no-hover2" rowspan="7">'.$id.'</th>';
                    echo '<th class="align-middle text-start fw-normal no-hover2" rowspan="7">'.$nombre.'</th>';
                    
                    // Ahora imprimir cada día y su select en filas individuales
                    foreach ($Dias as $index => $Dia) {
                        if ($index > 0) { // Si no es el primer día, abrimos una nueva fila
                            echo '<tr>';
                        }

                        echo '<th class="align-middle text-center fw-normal">'.$nombresDias[$index].'</th>';
                        echo '<td class="p-0 m-0 align-middle no-hover2">
                                <select class="p-1 border-0 text-center bg-light" style="width: 100%;" onchange="EditEstacion(this, '.($index + 1).', '.$id.', '.$idReporte.')">';
                        
                        // Obtener la estación actual o descanso
                        $estacionActual = ($Dia == "400") ? "Descanso" : $ClassHerramientasDptoOperativo->obtenerDatosEstacion($Dia)['nombre'];
                        echo '<option value="'.$Dia.'">'.$estacionActual.'</option>';
                        
                        // Mostrar todas las estaciones disponibles
                        foreach ($Estaciones as $estacion) {
                            if ($estacion['id'] != $Dia) { // Evitar repetir la estación actual
                                echo '<option value="'.$estacion['id'].'">'.$estacion['nombre'].'</option>';
                            }
                        }
                        
                        // Agregar opción de descanso
                        echo '<option value="400">Descanso</option>';
                        echo '</select></td>';

                        echo '</tr>';
                    }
                }
            }
            ?>
        </tbody>
    </table>
</div>
