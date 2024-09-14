
<?php
require '../../../../help.php';
require '../../../../lib/dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$GET_idReporte = $_GET['idReporte'];
$formato = $_GET['idFormato'];


$sql = "SELECT * FROM op_rh_formatos WHERE id = '".$GET_idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $explode = explode(' ', $row['fecha']);
    $HoraFormato = date("g:i a",strtotime($explode[1]));
    $idEstacion = $row['id_localidad'];
    $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);
    $formato = $row['formato'];
    $status = $row['status'];
    }

    $estacion = ''.$datosEstacion['localidad'].'';


if($formato == 1){
    $Titulo = 'Alta de Personal '.$estacion;
    
    }else if($formato == 2){
    $Titulo = 'Baja de Personal '.$estacion;
    
    }else if($formato == 3){
    $Titulo = 'Falta de Personal '.$estacion;
    
    }else if($formato == 4){
    $Titulo = 'Reestructuración de Personal '.$estacion;
      
    }else if($formato == 5){
    $Titulo = 'Ajuste Salarial '.$estacion;
        
    }else if($formato == 6){
    $Titulo = 'Vacaciones de Personal '.$estacion;
          
    }else if($formato == 7){
    $Titulo = 'Solicitud Prima Vacacional '.$estacion;
            
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
        width: 32%; /* Ajusta este valor para el número de columnas que desees */
        float: left;
        padding: 0 5px;
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
<h2><?=$Titulo?></h2>

<div class="row">
<div class="col-12">
  <!---------- 1. ALTA DE PERSONAL ---------->
  <?php if($formato == 1){ ?>
  <div class="col-12 text-end mb-3">
  <b>Formato:</b> RH-ALT-01
  <br>
  <b>No. De control:</b> 00<?=$GET_idReporte?>
  <p>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?></p>
  </div>
  
  <div class="col-12">
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <p><b>Departamento de Recursos Humanos</b></p>
  <p>Buenos días por medio del presente solicito de su amable apoyo para realizar la siguiente alta de personal.</p>
  </div>

  <div class="table-responsive mb-4">
  <table class="custom-table" width="100%">

  <thead class="tables-bg">
  <tr>
  <th class="align-middle text-center">#</th>
  <th class="align-middle text-center">Empleado</th>
  <th class="align-middle text-center">Estacion</th>
  <th class="align-middle text-center">Puesto</th>
  <th class="align-middle text-center">Alta</th>
  <th class="align-middle text-center">Salario</th>

  </tr>
  </thead>

  <tbody class="bg-light">
  <?php
  $sql_lista = "SELECT * FROM op_rh_formatos_alta WHERE id_formulario = '" . $GET_idReporte . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if ($numero_lista > 0) {
  $num = 1;
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $id = $row_lista['id'];

  $NombreC = $row_lista['nombre'];
  $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($row_lista['id_estacion']);
  $nombreEstacion = $datosEstacion['localidad'];
  $puesto = $ClassHerramientasDptoOperativo->obtenerPuestoPersonal($row_lista['puesto']);
  $fecha_alta = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha_ingreso']);
  $salario = number_format($row_lista['sd'],2);

  echo '<tr>';              
  echo '<td class="align-middle text-center">' . $num . '</td>';      
  echo '<td class="align-middle text-center">' . $NombreC . '</td>';  
  echo '<td class="align-middle text-center">' . $nombreEstacion . '</td>';           
  echo '<td class="align-middle text-center">' . $puesto . '</td>';           
  echo '<td class="align-middle text-center">' . $fecha_alta . '</td>';       
  echo '<td class="align-middle text-center">$ ' . $salario . '</td>';           
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


  <!---------- 2. BAJA DE PERSONAL ---------->
  <?php } else if($formato == 2){ ?>
  <div class="col-12 text-end mb-3 ">
  <b>Formato:</b> RH-BAJ-02
  <br>
  <b>No. De control:</b> 00<?=$GET_idReporte?>
  
  <p>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?></p>
  </div>

  <div class="col-12">
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <p><b>Departamento de Recursos Humanos</b></p>
  <p>Buenos días por medio del presente solicito de su amable apoyo para realizar las siguientes bajas de personal.</p>
  </div>

  <div class="table-responsive mb-4">
  <table class="custom-table" width="100%">

  <thead class="tables-bg">
  <tr>
  <th class="align-middle text-center">#</th>
  <th class="align-middle text-center">Empleado</th>
  <th class="align-middle text-center">Estacion / Departamento</th>
  <th class="align-middle text-center">Fecha de aplicacion de baja</th>
  <th class="align-middle text-center">Motivo</th>
  <th class="align-middle text-center">Detalle</th>
  </tr>
  </thead>

  <tbody class="bg-light">
  <?php
  $sql_lista = "SELECT * FROM op_rh_formatos_baja WHERE id_formulario = '" . $GET_idReporte . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if ($numero_lista > 0) { 
  $num = 1;
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $id = $row_lista['id'];

  $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($row_lista['id_personal']);
  $NombreC = $datosPersonal['nombre_personal'];

  $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($row_lista['id_estacion']);
  $nombreEstacion = $datosEstacion['localidad'];

  $fecha_baja = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha_baja']);
  
  $motivo = $row_lista['motivo'];
  $detalle = $row_lista['detalle'];

  echo '<tr>';              
  echo '<td class="align-middle text-center">' . $num . '</td>';      
  echo '<td class="align-middle text-center">' . $NombreC . '</td>';  
  echo '<td class="align-middle text-center">' . $nombreEstacion . '</td>';           
  echo '<td class="align-middle text-center">' . $fecha_baja . '</td>';      
  echo '<td class="align-middle text-center">' . $motivo . '</td>';          
  echo '<td class="align-middle text-center">' . $detalle . '</td>';           
  echo '</tr>';
       
  $num++;                     
  }

  }else{
  echo "<tr><th colspan='15' class='text-center text-secondary fw-normal'><small>No se encontró información para mostrar </small></th></tr>";
  }
  ?>

  </tbody>
  </table>
  </div>

  <div class="col-12 text-center"><p>Sin más por el momento quedo de usted.</p><hr></div>
  <!---------- 5. FALTA DE PERSONAL ---------->
  <?php } else if($formato == 3){ ?>

  <div class="col-12 text-end mb-3" style='text-align:right;'>
  <b>Formato:</b> RH-FALT-03
  <br>
  <b>No. De control:</b> 00<?=$GET_idReporte?>
  
  <br>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?>
  </div>

  <div class="col-12">
  <br>
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <b>Departamento de Recursos Humanos</b>
  <p>Por medio del presente se le notifica la siguiente incidencia que corresponde a faltas de personal.</p>
  </div>
 
  <div class="table-responsive mb-4">
  <table class="custom-table" width="100%">

  <thead class="tables-bg">
  <tr>
  <th class="align-middle text-center" style='text-align:center;'>#</th>
  <th class="align-middle text-center" style='text-align:center;'>Colaborador</th>
  <th class="align-middle text-center" style='text-align:center;'>Dia faltante</th>
  <th class="align-middle text-center" style='text-align:center;'>Estacion</th>
  </tr>
  </thead>

  <tbody class="bg-light">
  <?php
  $sql_lista = "SELECT * FROM op_rh_formatos_falta WHERE id_formulario = '" . $GET_idReporte . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if ($numero_lista > 0) { 
  $num = 1;
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $id = $row_lista['id'];

  $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($row_lista['id_personal']);
  $NombreC = $datosPersonal['nombre_personal'];

  $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($row_lista['id_estacion']);
  $nombreEstacion = $datosEstacion['localidad'];

  $dias_falta = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['dias_falta']);

  echo '<tr>';              
  echo '<td class="align-middle text-center" style="text-align:center;">' . $num . '</td>';      
  echo '<td class="align-middle text-center" style="text-align:center;">' . $NombreC . '</td>';  
  echo '<td class="align-middle text-center" style="text-align:center;">' . $dias_falta . '</td>';          
  echo '<td class="align-middle text-center" style="text-align:center;">' . $nombreEstacion . '</td>';           
  echo '</tr>';
       
  $num++;                     
  }

  }else{
  echo "<tr><th colspan='15' class='text-center text-secondary fw-normal' style='text-align:center;'><small>No se encontró información para mostrar </small></th></tr>";
  }
  ?>

  </tbody>
  </table>
  </div>
  
  <div class="col-12 text-center" style='text-align:center;'><p>Sin más por el momento quedo de usted.</p><hr></div>

  <!---------- 4. REESTRUCTURACIÓN DE PERSONAL ---------->
  <?php } else if($formato == 4){ ?>

  <div class="col-12 text-end mb-3 ">
  <b>Formato:</b> RH-REEST-04
  <br>
  <b>No. De control:</b> 00<?=$GET_idReporte?>
  
  <p>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?></p>
  </div>

  <div class="col-12">
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <p><b>Departamento de Recursos Humanos</b></p>
  <p>Buenos días por medio del presente solicito de su amable apoyo para realizar el siguiente cambio de personal.</p>
  </div>

  <div class="table-responsive mb-4">
  <table class="custom-table" width="100%">

  <thead class="tables-bg">
  <tr>
  <th class="align-middle text-center">#</th>
  <th class="align-middle text-center">Empleado</th>
  <th class="align-middle text-center">De Estacion / Departamento</th>
  <th class="align-middle text-center">Cambio a</th>
  <th class="align-middle text-center">Fecha de aplicacion de baja</th>

  </tr>
  </thead>

  <tbody class="bg-light">
  <?php
  $sql_lista = "SELECT * FROM op_rh_formatos_restructuracion WHERE id_formulario = '" . $GET_idReporte . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if ($numero_lista > 0) { 
  $num = 1;
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $id = $row_lista['id'];

  $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($row_lista['id_personal']);
  $NombreC = $datosPersonal['nombre_personal'];

  $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($row_lista['id_estacion']);
  $nombreEstacion = $datosEstacion['localidad'];

  $datosEstacion2 = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($row_lista['id_estacion_cambio']);
  $nombreEstacion2 = $datosEstacion2['localidad'];

  $fecha= $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha']);


  echo '<tr>';              
  echo '<td class="align-middle text-center">' . $num . '</td>';      
  echo '<td class="align-middle text-center">' . $NombreC . '</td>';  
  echo '<td class="align-middle text-center">' . $nombreEstacion . '</td>';           
  echo '<td class="align-middle text-center">' . $nombreEstacion2 . '</td>';       
  echo '<td class="align-middle text-center">' . $fecha . '</td>';          
  echo '</tr>';
       
  $num++;                      
  }

  }else{
  echo "<tr><th colspan='15' class='text-center text-secondary fw-normal'><small>No se encontró información para mostrar </small></th></tr>";
  }
  ?>

  </tbody>
  </table>
  </div>

  <div class="col-12 text-center"><p>Sin más por el momento quedo de usted.</p><hr></div>

    
  <!---------- 5. AJUSTE SALARIAL ---------->
  <?php } else if($formato == 5){ ?>
  <div class="col-12 text-end mb-3 ">
  <b>Formato:</b> RH-ADJS-05
  <br>
  <b>No. De control:</b> 00<?=$GET_idReporte?>
  
  <p>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?></p>
  </div>

  <div class="col-12">
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <p><b>Departamento de Recursos Humanos</b></p>
  <p>Buenos días por medio del presente solicito su apoyo para el ajuste salarial al siguiente colaborador.</p>
  </div>
 

  <div class="table-responsive mb-4">
  <table class="custom-table" width="100%">

  <thead class="tables-bg">
  <tr>
  <th class="align-middle text-center">#</th>
  <th class="align-middle text-center">Colaborador</th>
  <th class="align-middle text-center">Puesto</th>
  <th class="align-middle text-center">Salario Diario</th>
  <th class="align-middle text-center">Ajuste a</th>
  <th class="align-middle text-center">Aplicar a partir del</th>

  </tr>
  </thead>
 
  <tbody class="bg-light">
  <?php
  $sql_lista = "SELECT * FROM op_rh_formatos_ajuste_salarial WHERE id_formulario = '" . $GET_idReporte . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if ($numero_lista > 0) { 
  $num = 1;
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $id = $row_lista['id'];

  $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($row_lista['id_personal']);
  $NombreC = $datosPersonal['nombre_personal']; 
  $Puesto = $datosPersonal['puesto'];  

  $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($row_lista['id_estacion']);
  $nombreEstacion = $datosEstacion['localidad'];

  $salarioActual = $row_lista['salario_actual'];
  $salarioAjustado = $row_lista['salario_ajustado'];

  $fecha_aplicacion = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha_aplicacion']);
 

  echo '<tr>';              
  echo '<td class="align-middle text-center">' . $num . '</td>';      
  echo '<td class="align-middle text-center">' . $NombreC . '</td>';  
  echo '<td class="align-middle text-center">' . $Puesto . '</td>';           
  echo '<td class="align-middle text-center">$' . number_format($salarioActual,2) . '</td>';       
  echo '<td class="align-middle text-center">$' . number_format($salarioAjustado,2) . '</td>';    
  echo '<td class="align-middle text-center">' . $fecha_aplicacion . '</td>';                
  echo '</tr>';
       
  $num++;                     
  }

  }else{
  echo "<tr><th colspan='15' class='text-center text-secondary fw-normal'><small>No se encontró información para mostrar </small></th></tr>";
  }
  ?>

  </tbody>
  </table>
  </div>


  <div class="col-12 text-center"><p>Sin más por el momento quedo de usted.</p><hr></div>


  <!---------- 6. VACACIONES DE PERSONAL ---------->
  <?php } else if($formato == 6){ 
    
  $sql_lista = "SELECT * FROM op_rh_formatos_vacaciones WHERE id_formulario = '" . $GET_idReporte . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

    while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
    $id = $row_lista['id'];
    $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($row_lista['id_usuario']);
    $NombreC = $datosPersonal['nombre_personal']; 
    $Puesto = $datosPersonal['puesto'];  
    $idEstaciones = $datosPersonal['idEstacion'];  
 
    $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstaciones);
    $nombreEstacion = $datosEstacion['localidad'];
      
    $num_dias = $row_lista['num_dias'];      
    $fecha_inicio = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha_inicio']);
    $fecha_termino = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha_termino']);
    $fecha_regreso = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha_regreso']);

    $observaciones = $row_lista['observaciones'];      
    }
    
    if($observaciones == ""){
    $observaciones2 = "N/A";
    }else{
    $observaciones2 = $observaciones;
    }

    ?>


  <div class="col-12 text-end mb-3 ">
  <b>Formato:</b> RH-FV-06
  <br>
  <b>No. De control:</b> 00<?=$GET_idReporte?>
  
  <p>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?></p>
  </div>

  <div class="col-12">
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <p><b>Departamento de Recursos Humanos</b></p>
  <p>Por medio de la presente, solicito su apoyo para llevar a cabo la autorizacion correspondiente en las vacaciones al siguiente colaborador.</p>
  </div>


  <!---------- TABLA DEL PERSONAL ---------->
  <div class="col-12">
  <div class="table-responsive">
    <table class="custom-table mb-3" style="font-size: 12.5px;" width="100%">
    <tr>
    <td class="font-weight-bold tables-bg"><b>Área o Departamento:</b></td>
    <td class="font-weight-bold tables-bg"><b>Nombre completo:</b></td>
    <td class="font-weight-bold tables-bg"><b>Número de días a disfrutar:</b></td>
    </tr>
    <tr>
    <td class="bg-light"><?=$nombreEstacion?></td>
    <td class="bg-light"><?=$NombreC?></td>
    <td class="bg-light"><?=$num_dias;?></td>
    </tr>

    <tr>
    <th class="tables-bg">Del:</th>
    <td class="tables-bg"><b>Al:</b></td>
    <th class="tables-bg">Regresando el:</th>
    </tr>
    <tr>
    <td class="bg-light"><?=$fecha_inicio?></td>
    <td class="bg-light"><?=$fecha_termino?></td>
    <td class="bg-light"><?=$fecha_regreso?></td>
    </tr>

    <tr>
    <th class="tables-bg" colspan="3">Observaciones:</th>
    </tr>
    <tr>
    <td class="bg-light" colspan="3"><?=$observaciones2?></td>
    </tr>

    </table>
    </div>
    </div>
 

    
  <div class="col-12 text-center"><p>Sin más por el momento quedo de usted.</p><hr></div>

  <!---------- 7. PRIMA VACACIONAL ---------->
  <?php } else if($formato == 7){ 
 $sql_lista = "SELECT * FROM op_rh_formatos_prima_vacacional WHERE id_formulario = '" . $GET_idReporte . "' ";
 $result_lista = mysqli_query($con, $sql_lista);
 $numero_lista = mysqli_num_rows($result_lista);

     while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
     $id = $row_lista['id'];
     $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($row_lista['id_personal']);
     $NombreC = $datosPersonal['nombre_personal']; 
     $fecha_ingreso = $ClassHerramientasDptoOperativo->FormatoFecha($datosPersonal['fecha_ingreso']); 
  
     $idEstaciones = $row_lista['id_estacion'];      
     $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstaciones);
     $nombreEstacion = $datosEstacion['localidad'];
       
     $periodo = $row_lista['periodo'];      
 
     }
 
     $contenido = '<th class="text-center fw-normal">'.$NombreC.'</th>
     <th class="text-center fw-normal">'.$fecha_ingreso.'</th>
     <th class="text-center fw-normal">'.$nombreEstacion.'</th>';

  ?>
  


  <div class="col-12 text-end mb-3 ">
  <b>Formato:</b> RH-FV-06
  <br>
  <b>No. De control:</b> 00<?=$GET_idReporte?>
  
  <p>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?></p>
  </div>

  <div class="col-12">
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <p><b>Departamento de Recursos Humanos</b></p>
  <p>
  Sirva la presente para enviarle un cordial saludo, al mismo tiempo, me permito solicitarle el pago de mi prima vacacional, correspondiente al periodo de  
  <b><?=$periodo?></b>
  </p>
  </div>


  <!---------- TABLA DEL PERSONAL ---------->
  <div class="col-12">
  <div class="table-responsive mb-4">
  <table class="custom-table" width="100%">

  <thead class="tables-bg">
  <tr>
  <th class="align-middle text-center">Colaborador</th>
  <th class="align-middle text-center">Fecha de ingreso</th>
  <th class="align-middle text-center">Estacion / Departamento</th>

  </tr>
  </thead>

  <tbody class="bg-light">
  <tr>             
    <?=$contenido?>      
  </tr>
  </tbody>
  </table>
  </div>
  </div>
 

    
  <div class="col-12 text-center"><p>Sin más por el momento quedo de usted.</p><hr></div>

  <?php } ?>


  <!---------- FIRMAS DE ELABORACIÓN DEL FORMATO ---------->
<div class="firmas-contenedor">
    <?php 
    $sql_firma = "SELECT * FROM op_rh_formatos_firma WHERE id_formato = '".$GET_idReporte."' ";
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
            $TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
            $Detalle = '<div><small>La solicitud de cheque se firmó por un medio electrónico.<br><b>Fecha: '.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
        } else if($row_firma['tipo_firma'] == "C"){
            $TipoFirma = "NOMBRE Y FIRMA DEL VOBO";
            $Detalle = '<div><img src="'.RUTA_IMG_Firma.''.$row_firma['firma'].'"></div>';
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
$dompdf->stream(''.$Titulo.'.pdf', ['Attachment' => 0]);

?>

