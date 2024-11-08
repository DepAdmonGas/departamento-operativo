<?php
require '../../../../help.php';
require '../../../../lib/dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (isset($_GET["fecha_inicio"]) && isset($_GET["fecha_fin"]) && !empty($_GET["fecha_inicio"]) && !empty($_GET["fecha_fin"])) {
    $fechaInicio = $_GET["fecha_inicio"];
    $fechaFin = $_GET["fecha_fin"];
    $consulta = "WHERE op_rh_personal_lista_negra.fecha BETWEEN '".$fechaInicio."' AND '".$fechaFin."'";
    $textoDetalle = "del: '".$ClassHerramientasDptoOperativo->FormatoFecha($fechaInicio)."' al: '".$ClassHerramientasDptoOperativo->FormatoFecha($fechaFin)."'";
} else {
    $fechaInicio = "";
    $fechaFin = "";
    $consulta = "";
    $textoDetalle = "General";
}

        
    $sql_lista = "SELECT 
    op_rh_personal.id_estacion,
    op_rh_personal.nombre_completo,
    op_rh_personal.id_estacion,
    op_rh_personal.puesto,
    op_rh_personal.fecha_ingreso,
    op_rh_personal.estado,
    op_rh_personal_lista_negra.id,
    op_rh_personal_lista_negra.fecha,
    op_rh_personal_lista_negra.motivo,
    op_rh_personal_lista_negra.detalle,
    op_rh_puestos.puesto
    FROM op_rh_personal_lista_negra
    INNER JOIN op_rh_personal ON op_rh_personal_lista_negra.id_personal = op_rh_personal.id
    INNER JOIN op_rh_puestos ON op_rh_personal.puesto = op_rh_puestos.id
    ORDER BY op_rh_personal.id_estacion ASC ";
        
    $result_lista = mysqli_query($con, $sql_lista);
    $numero_lista = mysqli_num_rows($result_lista);

// Genera el contenido HTML de la tabla
ob_start();
?>

<html>
<head>
    <style>
body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
    background-image: url(<?=RUTA_IMG_LOGOS?>Fondo1-A.jpg); /* Usa la ruta correcta */
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}

.content-wrapper {
    position: relative;
    z-index: 1;
    width: calc(100% - 40px); /* Ajusta el ancho de acuerdo al padding */
    height: 90%;
    margin: 0 auto; /* Centra el contenido horizontalmente */
    padding: 40px; /* Aquí puedes ajustar el padding */
    box-sizing: border-box; /* Asegura que el padding no afecte el ancho total */
}

.custom-table {
    width: 100%; /* Asegúrate de que la tabla ocupe el 100% del área disponible */
   
}

        .custom-table {
            width: 100%;
            font-size: .75em;
        }

        .custom-table thead th,
        .custom-table tbody td {
            text-align: left;
            padding: 10px;
            font-size: 10.5px;
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

        .bg-light {
    background-color: #f8f9fa;
}
    </style>
</head>
<body>

<div class="content-wrapper">
<h2>Listado de lista negra <br> <?=$textoDetalle?></h2>

<div class="col-12">
    <div class="table-responsive">
    
    <table class="custom-table">
    <thead class="tables-bg">
<tr> 
  <th class="text-center align-middle ">#</th>
  <th class="align-middle text-start">Nombre completo</th>
  <th class="align-middle text-center">Puesto</th>
  <th class="align-middle text-center">Fecha de baja</th>
  <th class="align-middle text-center" width="150px">Estacion donde se dio de baja</th>
  <th class="align-middle text-center">Motivo de Baja</th>
  <th class="align-middle text-center" width="400px">Descripción</th>
</tr>
</thead> 

<tbody class="bg-light">
<?php
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$idListaNegra = $row_lista['id'];
$GET_idEstacion = $row_lista['id_estacion'];
$nombre_completo = $row_lista['nombre_completo'];
$fecha = $row_lista['fecha'];
$puesto = $row_lista['puesto'];
$motivo = $row_lista['motivo'];
$detalle = $row_lista['detalle'];

$datosEstaciones = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($GET_idEstacion);
$nombreEstacion = $datosEstaciones['localidad'];

echo '<tr>';
echo '<th class="text-center align-middle">'.$num.'</th>';
echo '<td class="text-start align-middle">'.$nombre_completo.'</td>';
echo '<td class="text-center align-middle">'.$puesto.'</td>';
echo '<td class="text-center align-middle">'.$ClassHerramientasDptoOperativo->FormatoFecha($fecha).'</td>';
echo '<td class="text-center align-middle"> '.$nombreEstacion.'</td>';
echo '<td class="text-center align-middle">'.$motivo.'</td>';
echo '<td class="text-center align-middle">'.$detalle.'</td>';
echo '</tr>';

$num++;
}
?>
</tbody>
        </table>


    </div>
</div>
</div>
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
$dompdf->setPaper('A4', 'landscape'); // Configura el tamaño y la orientación del papel en vertical
$dompdf->render();

// Salida del PDF generado al navegador
$dompdf->stream("Listado Lista Negra.pdf", ["Attachment" => 1]); // Attachment => false lo abre en el navegador

?>
