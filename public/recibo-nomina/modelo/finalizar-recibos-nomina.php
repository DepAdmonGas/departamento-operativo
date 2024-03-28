<?php
require('../../../app/help.php');
 
    function fechasNominaSemanas($year, $semana, $semanasASumar, $diasASumar){
    // Obtener la fecha del primer día de la semana
    $inicioDay = new DateTime();
    $inicioDay->setISODate($year, $semana, 1);
    $inicioDay->modify('last thursday');
  
    // Calcular la fecha de fin de la semana (6 días después del inicio)
    $finDay = clone $inicioDay;
    $finDay->modify('+6 days');
  
    // Sumar semanas y días a las fechas
    $inicioDay->modify("+$semanasASumar weeks +$diasASumar days");
    $finDay->modify("+$semanasASumar weeks +$diasASumar days");
  
    // Formatear las fechas para mostrarlas
    $inicioDayFormateada = $inicioDay->format('Y-m-d');
   
    return $inicioDayFormateada;
    }

    //---------- FECHA QUINCENA EVALUACION 1 ----------
    function fechasNominaQuincenas($year,$mes,$quincena,$semanas,$dias) {
    // Calcular el primer día del mes
    $primer_dia = mktime(0, 0, 0, $mes, 1, $year);
      
    // Calcular las fechas de inicio y fin de la quincena seleccionada
    if ($quincena % 2 == 1) {
    $inicioDayFormateada = date('Y-m-d', $primer_dia);
    
    }else{
     $inicioDayFormateada = date('Y-m-16', $primer_dia);
     
    }
      
    // Sumar semanas y días a la fecha obtenida
    $fechaInicio = strtotime($inicioDayFormateada);
    $nuevaFecha = strtotime("+$semanas weeks", $fechaInicio);
    $nuevaFecha = strtotime("+$dias days", $nuevaFecha);
      
    $nuevaFechaFormateada = date('Y-m-d', $nuevaFecha);
      
    return $nuevaFechaFormateada;
    }


    function fechasNominaQuincenas2($year,$mes,$quincena,$semanas,$dias) {
    // Calcular el primer día del mes
    $primer_dia = mktime(0, 0, 0, $mes, 1, $year);
          
    // Calcular las fechas de inicio y fin de la quincena seleccionada
    if ($quincena % 2 == 1) {
    $inicioDayFormateada = date('Y-m-16', $primer_dia);
        
    }else{
    $inicioDayFormateada = date('Y-m-01', strtotime('+1 month', $primer_dia));
         
    }
          
    // Sumar semanas y días a la fecha obtenida
    $fechaInicio = strtotime($inicioDayFormateada);
    $nuevaFecha = strtotime("+$semanas weeks", $fechaInicio);
    $nuevaFecha = strtotime("+$dias days", $nuevaFecha);

    $nuevaFechaFormateada = date('Y-m-d', $nuevaFecha);
          
    return $nuevaFechaFormateada;
    }




    function revisionOperativo($year,$mes,$dias){
    // Construir la fecha del día 15 del mes seleccionado
     $fecha_dia_15 = date("Y-m-d", strtotime("$year-$mes-10"));
         
    // Sumar 1 mes a la fecha del día 15
    $fecha_siguiente_mes = date("Y-m-d", strtotime("+1 month", strtotime($fecha_dia_15)));
        
    // Sumar días a la fecha siguiente al mes
    $fecha_resultado = date("Y-m-d", strtotime("+$dias days", strtotime($fecha_siguiente_mes)));
        
    return $fecha_resultado;
    }


    $idResponsable = $_POST['idResponsable'];
    $idEstacion = $_POST['idEstacion'];
    $year = $_POST['year'];
    $mes = $_POST['mes'];
    $SemQui = $_POST['SemQui'];
    $descripcion = $_POST['descripcion'];

    $fechaActual = new DateTime(); // Obtiene la fecha y hora actual
    $fechaActualFormato = $fechaActual->format('Y-m-d'); // Formatea la fecha según el formato deseado (año,mes,dia)

    //---------- CONFIGURACION SEMANA ----------
    if($descripcion == "Semana"){
    //--Mexdesa--
    $fechaViernesIS = fechasNominaSemanas($year, $SemQui, 1, 1);
    $fechaSabadoIS = fechasNominaSemanas($year, $SemQui, 1, 2);
    $fechaDomingoIS = fechasNominaSemanas($year, $SemQui, 1, 3);

    //--Estaciones--
    $fechaMartesPS = fechasNominaSemanas($year, $SemQui, 1, 5);
    $fechaJuevesPS = fechasNominaSemanas($year, $SemQui, 2, 0);
    $fechaSabadoPS = fechasNominaSemanas($year, $SemQui, 2, 2);

    //--Departamento Operativo--
    $fechaViernesOP = fechasNominaSemanas($year, $SemQui, 2, 1);
    $fechaSabadoOP = fechasNominaSemanas($year, $SemQui, 2, 2);
    $fechaLunesOP = fechasNominaSemanas($year, $SemQui, 2, 4);


    if($idResponsable == 1){
    $responsable = "Recibos Mexdesa";
    
    if($fechaActualFormato <= $fechaViernesIS){
    $puntaje = 3;
    }else if($fechaActualFormato > $fechaViernesIS && $fechaActualFormato <= $fechaSabadoIS){
    $puntaje = 2;
    }else if($fechaActualFormato > $fechaSabadoIS && $fechaActualFormato <= $fechaDomingoIS){
    $puntaje = 1;  
    }else{
    $puntaje = 0;   
    }
    
    }else if($idResponsable == 2){
    $responsable = "Recibos Estacion";

    if($fechaActualFormato <= $fechaMartesPS){
    $puntaje = 3;
    }else if($fechaActualFormato > $fechaMartesPS && $fechaActualFormato <= $fechaJuevesPS){
    $puntaje = 2;
    }else if($fechaActualFormato > $fechaJuevesPS && $fechaActualFormato <= $fechaSabadoPS){
    $puntaje = 1;  
    }else{
    $puntaje = 0;   
    }


    }else if($idResponsable == 3){
    $responsable = "Recibos Operativo";

    if($fechaActualFormato <= $fechaViernesOP){
    $puntaje = 3;
    }else if($fechaActualFormato > $fechaViernesOP && $fechaActualFormato <= $fechaSabadoOP){
    $puntaje = 2;
    }else if($fechaActualFormato > $fechaSabadoOP && $fechaActualFormato <= $fechaLunesOP){
    $puntaje = 1;  
    }else{
    $puntaje = 0;   
    }


    }
    
    //---------- CONFIGURACION QUINCENA ----------
    }else if($descripcion == "Quincena"){
    //--Mexdesa--
    $fecha_16_1 = fechasNominaQuincenas2($year,$mes,$SemQui,0,0); 

    //--Estaciones--
    $fecha_17_2 = fechasNominaQuincenas2($year,$mes,$SemQui,0,1);
    $fecha_18_3 = fechasNominaQuincenas2($year,$mes,$SemQui,0,2);
    $fecha_19_4 = fechasNominaQuincenas2($year,$mes,$SemQui,0,3);

    //--Departamento Operativo--
    $fecha_24_9 = fechasNominaQuincenas2($year,$mes,$SemQui,1,1);
    $fecha_25_10 = fechasNominaQuincenas2($year,$mes,$SemQui,1,2);
    $fecha_26_11 = fechasNominaQuincenas2($year,$mes,$SemQui,1,3);


    if($idResponsable == 1){
    $responsable = "Recibos Mexdesa";

    if($fechaActualFormato <= $fecha_16_1){
    $puntaje = 3;
    }else if($fechaActualFormato > $fecha_16_1 && $fechaActualFormato <= $fecha_17_2){
    $puntaje = 2;
    }else if($fechaActualFormato > $fecha_17_2 && $fechaActualFormato <= $fecha_18_3){
    $puntaje = 1;  
    }else{
    $puntaje = 0;   
    }

    }else if($idResponsable == 2){
    $responsable = "Recibos Estacion";

    if($fechaActualFormato <= $fecha_17_2){
    $puntaje = 3;
    }else if($fechaActualFormato > $fecha_17_2 && $fechaActualFormato <= $fecha_18_3){
    $puntaje = 2;
    }else if($fechaActualFormato > $fecha_18_3 && $fechaActualFormato <= $fecha_19_4){
    $puntaje = 1;  
    }else{
    $puntaje = 0;   
    }
 
    }else if($idResponsable == 3){
    $responsable = "Recibos Operativo";
    
    if($fechaActualFormato <= $fecha_24_9){
    $puntaje = 3;
    }else if($fechaActualFormato > $fecha_24_9 && $fechaActualFormato <= $fecha_25_10){
    $puntaje = 2;
    }else if($fechaActualFormato > $fecha_25_10 && $fechaActualFormato <= $fecha_26_11){
    $puntaje = 1;  
    }else{
    $puntaje = 0;   
    }
    
    }

    }


    $sql_insert1 = "INSERT INTO op_recibo_nomina_v2_puntaje  
    (year,
    mes,
    no_semana_quincena,
    descripcion,
    id_estacion,
    actividad,
    puntaje
    ) 
    VALUES
    ('".$year."',
    '".$mes."',
    '".$SemQui."',
    '".$descripcion."',
    '".$idEstacion."',
    '".$responsable."',
    '".$puntaje."'
    )";

    if(mysqli_query($con, $sql_insert1)){
    echo 1;
        
    }else{
    echo 0;
    
    } 



//------------------
mysqli_close($con);
//------------------  