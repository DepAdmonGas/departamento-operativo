  
<?php
require '../../../../../help.php';
require '../../../../../lib/dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$GET_idReporte = $_GET['idReporte']; 

$sql_formatos = "SELECT fecha_creacion, year, quincena, status FROM op_rh_dia_doble_registro WHERE id = '" . $GET_idReporte . "' ";
$result_formatos = mysqli_query($con, $sql_formatos);

while ($row_formatos = mysqli_fetch_array($result_formatos, MYSQLI_ASSOC)) {
$explode = explode(' ', $row_formatos['fecha_creacion']);
$HoraFormato = date("g:i a",strtotime($explode[1]));
$quincena = $row_formatos['quincena'];
$year = $row_formatos['year'];
$status = $row_formatos['status'];

}

$mes = $ClassHerramientasDptoOperativo->obtenerMesPorQuincena($quincena);
//---------- FECHA DE INICIO Y FIN DE LA QUINCENA ----------
$fechaNomiaQuincena = $ClassHerramientasDptoOperativo->fechasNominaQuincenas($year,$mes,$quincena);
$inicioQuincenaDay = $fechaNomiaQuincena['inicioQuincenaDay'];
$finQuincenaDay = $fechaNomiaQuincena['finQuincenaDay'];


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
body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
    background-image: url(<?=RUTA_IMG_LOGOS?>Fondo2.jpg); /* Usa la ruta correcta */
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

        .firmas-contenedor {
        width: 100%;
    }
    .firma-col {
    width: 33%; /* Ajusta a 25% para 4 columnas */
    float: left;
    padding: 0 1px;
    box-sizing: border-box;
    text-align: center;
}
    .firma-col img {
        width: 70%; /* Ajusta este valor para el tamaño de las firmas */
    }
    .clearfix {
        clear: both;
    }

    </style>
</head>
<body>

<div class="content-wrapper">
    <br><br>
<h2>Formato Dia Doble (Quicena <?=$quincena?>)</h2>

<div class="row">

<div class="col-12 text-end mb-3 ">
  <b>No. de Folio:</b> 00<?=$GET_idReporte?>
  
  <p>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?></p>
  </div>

  <div class="col-12">
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <p><b>Departamento de Recursos Humanos</b></p>
  <p>Buenos días, Por medio de la presente, les informo sobre los días dobles asignados al personal del Departamento de Dirección de Operaciones, correspondientes a la <b>Quincena No. <?=$quincena?></b>, 
  que abarca del <b><?=$ClassHerramientasDptoOperativo->FormatoFecha($inicioQuincenaDay)?></b>
  al <b><?=$ClassHerramientasDptoOperativo->FormatoFecha($finQuincenaDay)?></b> 
  <br> A continuación, detallo la información para cada uno de los colaboradores:
  </p>
  </div>


  <div class="col-12">

  <div class="table-responsive mb-4">
  <table class="custom-table" width="100%">

  <thead class="tables-bg">
  <tr>
  <th class="align-middle text-center">#</th>
  <th class="align-middle text-center">Empleado</th>
  <th class="align-middle text-center">Dia Doble</th>

  </tr>
  </thead>

  <tbody class="bg-light">
  <?php
  $sql_lista = "SELECT * FROM op_rh_dia_doble_personal WHERE id_registro = '" . $GET_idReporte . "' ORDER BY id_usuario ASC";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if ($numero_lista > 0) {
  $num = 1;
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $id = $row_lista['id'];
 
  $idUsuario = $row_lista['id_usuario'];
  $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($idUsuario);
  $NombreC = $datosPersonal['nombre_personal'];
  $fecha_doble = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha_doble']);

  echo '<tr>';              
  echo '<th class="align-middle text-center">' . $num . '</th>';      
  echo '<td class="align-middle text-center">' . $NombreC . '</td>';  
  echo '<td class="align-middle text-center">' . $fecha_doble . '</td>';       
  echo '</tr>';
       
  $num++;                     
  }

  } else {
  echo "<tr><th colspan='15' class='text-center text-secondary fw-normal'><small>No se encontró información para mostrar </small></th></tr>";
  }
  ?>

  </tbody>
  </table>
  </div>




  <div class="col-12 text-center"><p>Sin más por el momento quedo de usted.</p><hr></div>
  </div>


<div class="col-12">




  <!---------- FIRMAS DE ELABORACIÓN DEL FORMATO ---------->
<div class="firmas-contenedor">
    <?php 
    $sql_firma = "SELECT * FROM op_rh_dias_dobles_firma WHERE id_formato = '".$GET_idReporte."' ";
    $result_firma = mysqli_query($con, $sql_firma);
    $numero_firma = mysqli_num_rows($result_firma);

    while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){
        $explode = explode(' ', $row_firma['fecha']);

        $datosUsuario = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($row_firma['id_usuario']);
        $nombreUser = $datosUsuario['nombre'];

        if($row_firma['tipo_firma'] == "A"){
            $TipoFirma = "NOMBRE Y FIRMA DE QUIEN ELABORÓ";
            $Detalle = '<div><img src="'.RUTA_IMG_Firma.''.$row_firma['firma'].'"></div>';
        } else if($row_firma['tipo_firma'] == "B"){
            $TipoFirma = "NOMBRE Y FIRMA DEL VOBO";
            $Detalle = '<div><small>La solicitud de cheque se firmó por un medio electrónico.<br><b>Fecha: '.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
        } else if($row_firma['tipo_firma'] == "C"){
            $TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
            $Detalle = '<div><small>La solicitud de cheque se firmó por un medio electrónico.<br><b>Fecha: '.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
        }

        echo '
        <div class="firma-col">
                <table class="custom-table" style="font-size: 14px;" width="100%">
                    <thead class="tables-bg">
                        <tr> <th class="align-middle text-center">'.$nombreUser.'</th> </tr>
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
    ?>
    <div class="clearfix"></div>

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
$dompdf->stream('Formato Dia Doble - Quincena '.$quincena.'.pdf', ['Attachment' => 1]);

?>

