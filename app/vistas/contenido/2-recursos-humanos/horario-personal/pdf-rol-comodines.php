
<?php
require '../../../../help.php';
require '../../../../lib/dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

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
// Genera el contenido HTML de la tabla
ob_start();
?>

<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?=RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?=RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>alertify.css">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>themes/default.rtl.css">
  <link href="<?=RUTA_CSS2;?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?=RUTA_CSS2;?>navbar-utilities.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">


  <style>
  /* Estilos generales */
           
  body {
    height: 100%;
    width: 100%;
    background-image: url("<?=RUTA_IMG_LOGOS?>Fondo3.jpg"); /* Usa la ruta correcta */
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}

  .content-wrapper {       
    margin: 0;  
    padding: 0;
    height: 100%;
    width: 100%;
  }


    .custom-table {
        width: 100%; /* Asegúrate de que la tabla ocupe el 100% del área disponible */
    
    }

    /* Ajuste adicional para las celdas de la tabla */
    .custom-table th,
    .custom-table td {
        max-width: 100px; /* Ajusta según tus necesidades */
        word-wrap: break-word;
    }
      
    .custom-table thead tr, .custom-table thead th {
      border-top: none;
      border-bottom: none !important;
      text-transform: uppercase;
    }
    
    /* Estilo para th en el encabezado de la tabla */
    .custom-table thead th {
      color: #000;
      padding-bottom: 10px;
      padding-top: 10px;
      font-size: 9.5px !important;
    }
    
    .custom-table thead th small {
      color: #000;
    }
     
    /* Estilo para th en el cuerpo de la tabla con mayor especificidad */
    .custom-table thead tr th {
      border: none; 
      color: #fff;
    }
    
    /*---------- TD (DESING TD) ----------- */
    .custom-table tbody th, .custom-table tbody td {
      /* color: #000; */
      padding-bottom: 10px;
      padding-top: 10px;
      font-size: 10.5px !important;
    }
    
    .custom-table tbody th small, .custom-table tbody td small {
      color: #aaaaaa;
    }
    
    .custom-table tbody tr th, .custom-table tbody tr td {
      border: none; 
    }
    
    /* Asegúrate de que no haya reglas más específicas que sobrescriban esta */
.custom-table tbody th, .custom-table tbody td {
    cursor: pointer !important;
  }
    
    .custom-table thead tr th:first-child, .custom-table tbody tr td:first-child{
      border-top-left-radius: 7px;
      border-bottom-left-radius: 0px; 
      
    }
    
    .custom-table thead tr th:last-child {
      border-top-right-radius: 7px;
      border-bottom-right-radius: 0px; 
    }
    
    .custom-table tbody tr.active {
      opacity: .4; 
    }

    /* Mantener el estilo hover para las filas */
    .custom-table tbody tr:hover {
        background-color: #e1e1e1 !important; /* Cambia el color de fondo cuando se hace hover */
        cursor: pointer; /* Cambia el cursor a una mano cuando pasa sobre la fila */
    }

    /* Quitar el estilo hover para celdas específicas */
    .custom-table tbody tr:hover th.no-hover, 
    .custom-table tbody tr:hover td.no-hover {
        background-color: #fff !important; /* Quita el color de fondo cuando se hace hover */
    }

    /* Asegurarse de que el estilo se aplique incluso si hay reglas más específicas */
    .custom-table tbody tr:hover th.no-hover,
    .custom-table tbody tr:hover td.no-hover {
        background-color: #fff !important; /* Quita el color de fondo cuando se hace hover */
    }


    /* Quitar el estilo hover para celdas específicas */
    .custom-table tbody tr:hover th.no-hover2, 
    .custom-table tbody tr:hover td.no-hover2 {
    background-color: #f8f9fa !important; /* Quita el color de fondo cuando se hace hover */
    }
    
    /* Asegurarse de que el estilo se aplique incluso si hay reglas más específicas */
    .custom-table tbody tr:hover th.no-hover2,
    .custom-table tbody tr:hover td.no-hover2 {
    background-color: #f8f9fa !important; /* Quita el color de fondo cuando se hace hover */
    }

    /* Quitar el estilo hover para celdas específicas */
    .custom-table tbody tr:hover th.no-hoverRed, 
    .custom-table tbody tr:hover td.no-hoverRed {
    background-color: #ffb6af !important; /* Quita el color de fondo cuando se hace hover */
    }
        
    /* Asegurarse de que el estilo se aplique incluso si hay reglas más específicas */
    .custom-table tbody tr:hover th.no-hoverRed,
    .custom-table tbody tr:hover td.no-hoverRed {
    background-color: #ffb6af !important; /* Quita el color de fondo cuando se hace hover */

    }

    .tables-bg {
        background: #215D98;
        color: white;
    }

    .title-table-bg {
    background: #749ABF;
    color: white;
    }

    .contenido-table-bg {
    background: #f2f2f2;
    color: dark;
    }
</style>
</head>
<body>

<div class="content-wrapper ">
<h2 class="mt-3">Rol de comodines</h2>


<div class="row">

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
<small class="mb-1 text-secondary ">FECHA DE INICIO:</small>
<div class=""><?=$ClassHerramientasDptoOperativo->FormatoFecha(fechaFormato: $fechaInicio)?></div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
<small class="mb-1 text-secondary ">FECHA DE TERMINO:</small>
<div class=""><?=$ClassHerramientasDptoOperativo->FormatoFecha(fechaFormato: $fechaTermino)?></div>
</div>

<div class="col-12">
 
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
         
$contador = 0;
$maxFilasPorPagina = 26; // Ajusta según lo necesario

// Ahora imprimir cada día y su select en filas individuales
foreach ($Dias as $index => $Dia) {
    if ($contador % $maxFilasPorPagina == 0 && $contador != 0) {
        echo '</tbody></table><div style="page-break-after: always;"></div><table class="custom-table"><tbody>'; // Generar nueva tabla
    }

    if ($index > 0) {
        echo '<tr>';
    }
echo '<th class="align-middle text-center fw-normal">'.$nombresDias[$index].'</th>';

if ($Dia == "400") {
    $estacionActual = "Descanso";
} elseif ($Dia == "0") {
    $estacionActual = "S/I";  // Cuando $Dia es "0", se muestra "S/I"
} else {
    $estacionActual = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($Dia)['nombre'];
}

echo '<th class="align-middle text-center fw-normal">'.$estacionActual.'</th>';

echo '</tr>';
}
}
}
?>
</tbody>
</table>
</div>

</div>

</div>


</div>

<!---------- FUNCIONES - NAVBAR ---------->
<script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>
</body>
</html>

<?php

$html = ob_get_clean(); // Captura el contenido HTML generado

// Configuración de DomPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait'); // Configura el tamaño y la orientación del papel en vertical
$dompdf->render();

// Salida del PDF generado al navegador
$dompdf->stream('Rol de Comodines ('.$fechaInicio.').pdf', ['Attachment' => 1]);

?>

