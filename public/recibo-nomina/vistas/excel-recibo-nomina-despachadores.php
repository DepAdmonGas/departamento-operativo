<?php 
require ('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_idMes = $_GET['mes'];

$sql_estacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_estacion = mysqli_query($con, $sql_estacion);
$numero_estacion = mysqli_num_rows($result_estacion);

while($row_estacion = mysqli_fetch_array($result_estacion, MYSQLI_ASSOC)){
$nombreES = $row_estacion['localidad'];	
}

$nombreMes = nombremes($GET_idMes);

$listadoSemanas = SemanasDelMes($GET_idMes, $GET_year);

//---------- OBTIENE EL NUMERO DE SEMANAS QUE TIENE EL MES ----------
function SemanasDelMes($GET_idMes, $GET_year) {
    // Obtener el primer día del mes
    $primerDia = strtotime("$GET_year-$GET_idMes-01");
  
    // Ajustar el primer día al primer día de la semana
    $primerDia = strtotime("this Wednesday", $primerDia);
  
    // Inicializar el array para almacenar las semanas
    $semanas = array();
  
    // Iterar desde el primer día hasta el último día del mes
    for ($currentDate = $primerDia; date('m', $currentDate) == $GET_idMes; $currentDate = strtotime('+1 week', $currentDate)) {
        // Calcular el número de semana
        $semana = date('W', $currentDate);
  
        // Agregar la semana al array solo si no está ya presente
        if (!in_array($semana, $semanas)) {
            $semanas[] = $semana;
        }
    }
  
    return $semanas;
  }



// Definir la función fechasNominaSemana
function fechasNominaSemana($year, $semana){
    // Obtener la fecha del primer día de la semana
    $inicioDay = new DateTime();
    $inicioDay->setISODate($year, $semana, 1);
    $inicioDay->modify('last thursday');
      
    // Calcular la fecha de fin de la semana (6 días después del inicio)
    $finDay = clone $inicioDay;
    $finDay->modify('+6 days');
      
    // Formatear las fechas para mostrarlas
    $inicioDayFormateada = $inicioDay->format('Y-m-d');
    $finDayFormateada = $finDay->format('Y-m-d');
      
    $array = array(
        'inicioSemanaDay' => $inicioDayFormateada, 
        'finSemanaDay' => $finDayFormateada
    );
      
    return $array; 
}


//---------- OBTENER LOS DATOS DEL PERSONAL DE LA ESTACION ----------
function PersonalNomina($idPersonal, $con){
    $sql = "SELECT
    op_rh_personal.fecha_ingreso, 
    op_rh_personal.no_colaborador, 
    op_rh_personal.nombre_completo, 
    op_rh_puestos.puesto 
    FROM op_rh_personal 
    INNER JOIN op_rh_puestos ON op_rh_personal.puesto = op_rh_puestos.id
    WHERE op_rh_personal.id = '".$idPersonal."' ";
        
    $result = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $fecha_ingreso = $row['fecha_ingreso'];
    $no_colaborador = $row['no_colaborador'];
    $nombreNomina = $row['nombre_completo'];
    $puesto = $row['puesto'];
    }
         
    $array = array(
    'fecha_ingreso' => $fecha_ingreso,  
    'no_colaborador' => $no_colaborador, 
    'nombreNomina' => $nombreNomina,
    'puesto' => $puesto
    );
        
    return $array; 
        
    }

    function importePersonal($id_usuario,$mes,$semana,$con){
        
        $sql_lista = "SELECT importe_total FROM op_recibo_nomina_v2 WHERE id_usuario = '".$id_usuario."' AND no_semana_quincena = '".$semana."' AND mes= '".$mes."'  AND descripcion = 'Semana' ORDER BY id_usuario ASC ";
        $result_lista = mysqli_query($con, $sql_lista);
        $numero_lista = mysqli_num_rows($result_lista);

        if($numero_lista > 0){
           
            while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
                $importe_total = $row_lista['importe_total'];
            }
                
        }else{
            $importe_total = 0;
        }
        
        return $importe_total;
    }


header('Content-Encoding: UTF-8');
header('Content-Type:text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="Importe de Nomina '.$nombreES.' '.$nombreMes.' '.$GET_year.'.csv"');

$salida = fopen('php://output', 'w');

// Inicializar el array $arrayHead
$arrayHead = array(
    'No.',
    'No. de Colaborador',
    'Nombre del personal'
);

// Agregar las semanas y las fechas al array $arrayHead dentro del bucle foreach
foreach ($listadoSemanas as $semana) {
    // Puedes convertir $semana a entero si es necesario
    $GET_idSemana = (int)$semana;

    // Llamar a la función y obtener el array de fechas
    $fechasSemana = fechasNominaSemana($GET_year, $GET_idSemana);

    // Agregar el resultado de la función al array $arrayHead
    $arrayHead[] = 'Semana ' . $GET_idSemana . ' ' . PHP_EOL . 'del ' . $fechasSemana['inicioSemanaDay'] . ' al ' . $fechasSemana['finSemanaDay'];
}
 
$arrayHead[] = 'Total a percibir';


$map1 = array_map("utf8_decode", $arrayHead);
fputcsv($salida, $map1);


$sql_lista = "SELECT DISTINCT id_usuario FROM op_recibo_nomina_v2 WHERE id_estacion = '".$idEstacion."' AND year = '".$GET_year."' AND mes= '".$GET_idMes."'  AND descripcion = 'Semana' AND id_puesto = 4 ORDER BY id_usuario ASC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


$sumaTotales = array(); // Inicializar el array para almacenar los totales de cada fila
$sumaTotal = 0; 

$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    $id_usuario = $row_lista['id_usuario'];

    $datosNomina = PersonalNomina($id_usuario, $con);
    $fecha_ingreso = $datosNomina['fecha_ingreso'];
    $no_colaborador = $datosNomina['no_colaborador'];
    $nombreNomina = $datosNomina['nombreNomina'];
    $puestoNomina = $datosNomina['puesto'];

    if($no_colaborador == 0){
        $no_colaborador2 = "S/I";
    }else{
        $no_colaborador2 = $no_colaborador;
    }

    // Agregar la información correspondiente a cada semana
    $arrayContenido1 = array(
        $num,
        $no_colaborador2,
        $nombreNomina
    );

    $totalAPercibir = 0; // Inicializar la variable para calcular la suma

    foreach ($listadoSemanas as $semana) {
        $GET_idSemana = (int)$semana;

        // Modificar el orden para agregar las semanas en la fila
        //$arrayContenido1[] = $GET_idSemana;
        $importe = importePersonal($id_usuario,$GET_idMes,$GET_idSemana,$con);
        $arrayContenido1[] = $importe;

        // Acumular la suma total
        $totalAPercibir += $importe;
    }

    // Sumar al total general
    $sumaTotal += $totalAPercibir;

    // Formatear el total a percibir con dos decimales
    $totalAPercibirFormateado = number_format($totalAPercibir, 2, '.', '');

    // Agregar el total a percibir al final del arrayContenido1
    $arrayContenido1[] = $totalAPercibirFormateado;

   // Agregar el total a percibir al array de totales
   $sumaTotales[] = $totalAPercibir;
    
    $contenidoPQDecode = array_map("utf8_decode", $arrayContenido1);
    fputcsv($salida, $contenidoPQDecode);

    $num = $num + 1;
}

// Imprimir la fila con la suma total al final del archivo CSV
$arrayTotal = array('', '', '   Total');
foreach ($listadoSemanas as $semana) {
    $arrayTotal[] = ''; // Las columnas de las semanas quedan vacías en la fila de suma total
}

// Sumar los totales y agregar la suma total al arrayTotal
$sumaTotal = array_sum($sumaTotales);
$arrayTotal[] = number_format($sumaTotal, 2, '.', ''); // Agregar la suma total formateada


$contenidoTotalDecode = array_map("utf8_decode", $arrayTotal);
fputcsv($salida, $contenidoTotalDecode);

// Cerrar el archivo CSV
fclose($salida);