<?php

class HomeCorporativo
{

	function __construct()
	{

	}


    function tituloMenuCorporativoYear($Pagina,$Session_IDUsuarioBD,$session_idpuesto){
    $result = "";

    if($Pagina == "corte-diario"){
    $titulo = "Corte Diario";
    $referencia = "corporativo";
    $menuName = "Corporativo";

    }else if($Pagina == "solicitud-cheque"){
    $titulo = "Solicitud de Cheques";
    $referencia = "corporativo";
    $menuName = "Corporativo";

    }else if($Pagina == "ingresos-facturacion"){
    $titulo = "Ingresos VS Facturación";
    $referencia = "corporativo";
    $menuName = "Corporativo";
    
    }else if($Pagina == "despacho-factura"){
    $titulo = "Despachos VS Ventas";
    $referencia = "corporativo";
    $menuName = "Corporativo";

    }else if($Pagina == "solicitud-vales"){
    $titulo = "Solicitud de Vales";
    $menuName = "Corporativo";
    } 


    if($session_idpuesto == 3 || $session_idpuesto == 31 || $session_idpuesto == 3){
    $referencia = "../administracion/corporativo";
    $menuName = "Corporativo";
    
    }else if($session_idpuesto == 6 || $session_idpuesto == 3){
    $referencia = "corporativo";
    $menuName = "Corporativo";
    
    }else if($session_idpuesto == 5){
    $referencia = "../departamento-operativo";
    $menuName = "Inicio";
    
    }else if($session_idpuesto == 15 || $Session_IDUsuarioBD == 292){
    $referencia = "../../portal-app/home";
    $menuName = "Portal";
    
    }
        
    $result .= '  <div class="col-12">
    <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
    <ol class="breadcrumb breadcrumb-caret">
    <li class="breadcrumb-item"><a onclick="menuCorporativoYear(\''.$referencia.'\')" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> '.$menuName.'</a></li>
    <li aria-current="page" class="breadcrumb-item active text-uppercase">'.$titulo.'</li>
    </ol>
    </div>
   
    <div class="row"> 
    <div class="col-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">'.$titulo.'</h3> </div>
    </div>
  
    <hr>
    </div>';

    return $result;
    }


    function tituloMenuCorporativoMes($Pagina,$Session_IDUsuarioBD,$session_idpuesto,$year){
    $result = "";

    if($Pagina == "corte-diario"){
    $titulo = "Corte Diario";
    $referencia = "corporativo";
    $menuName = "Corporativo";

    }else if($Pagina == "solicitud-cheque"){
    $titulo = "Solicitud de Cheques";
    $referencia = "corporativo";
    $menuName = "Corporativo";

    }else if($Pagina == "despacho-factura"){
    $titulo = "Despachos VS Ventas";
    $referencia = "corporativo";
    $menuName = "Corporativo";

    }else if($Pagina == "solicitud-vales"){
    $titulo = "Solicitud de Vales";
    $referencia = "corporativo";
    $menuName = "Corporativo"; 
    }

    if($session_idpuesto == 3 || $session_idpuesto == 31 || $session_idpuesto == 3){
    $referencia = "../../administracion/corporativo";
    $menuName = "Corporativo";
    
    }else if($session_idpuesto == 6 || $session_idpuesto == 3){
    $referencia = "../corporativo";
    $menuName = "Corporativo";
    
    }else if($session_idpuesto == 5){
    $referencia = "../../departamento-operativo";
    $menuName = "Inicio";
    
    }else if($session_idpuesto == 15 || $Session_IDUsuarioBD == 292){
    $referencia = "../../../portal-app/home";
    $menuName = "Portal";
    
    }

    
    $result .= '  <div class="col-12">
    <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
    <ol class="breadcrumb breadcrumb-caret">
    <li class="breadcrumb-item"><a onclick="menuCorporativoMes(\''.$referencia.'\')" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> '.$menuName.'</a></li>
    <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer">'.$titulo.'</a></li>
    <li aria-current="page" class="breadcrumb-item active text-uppercase">'.$year.'</li>
    </ol>
    </div>
       
    <div class="row"> 
    <div class="col-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">'.$titulo.' '.$year.'</h3> </div>
    </div>
      
    <hr>
    </div>';
    
    return $result;
    }


    function ValidaYearReporte($Session_IDEstacion,$fecha_year,$con){

    $sql_reporte = "SELECT id_estacion, year FROM op_corte_year WHERE id_estacion = '".$Session_IDEstacion."' AND year = '".$fecha_year."' ";
    $result_reporte = mysqli_query($con, $sql_reporte);
    $numero_reporte = mysqli_num_rows($result_reporte);

    if($numero_reporte == 0){
    $sql_insert = "INSERT INTO op_corte_year (
    id_estacion,
    year
    )
    VALUES 
    (
    '".$Session_IDEstacion."',
    '".$fecha_year."'
    )";

    return mysqli_query($con, $sql_insert);

    }

    }


    function cardsCorporativoYear($Pagina,$Session_IDEstacion,$con){
    $result = "";
    
    if($Pagina == "solicitud-vales"){
    $fecha_year = date("Y");    

    for ($i = $fecha_year; $i >= 2023; $i--) {
    $year = $i;
         
    $result .= ' <div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mb-2 mt-1">
    <article class="plan card2 border-0 shadow position-relative" onclick="corporativoYear(\''.$Pagina.'\','.$year.')">
           
    <div class="inner">
    <div class="row">
    <div class="col-2"> <span class="pricing"><i class="fa-solid fa-calendar"></i></span> </div>
    <div class="col-10"><h5 class="text-white text-center">'.$year.'</h5></div>
    </div>
   
    </div>
    </article>
    </div>';
    
    }

    }else{

    $sql_listayear = "SELECT id_estacion, year FROM op_corte_year WHERE id_estacion = '".$Session_IDEstacion."' ORDER BY year DESC";
    $result_listayear = mysqli_query($con, $sql_listayear);
      
    while($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)){
    $year = $row_listayear['year'];


    $result .= ' <div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mb-2 mt-1">
    <article class="plan card2 border-0 shadow position-relative" onclick="corporativoYear(\''.$Pagina.'\','.$year.')">
           
    <div class="inner">
    <div class="row">
    <div class="col-2"> <span class="pricing"><i class="fa-solid fa-calendar"></i></span> </div>
    <div class="col-10"><h5 class="text-white text-center">'.$year.'</h5></div>
    </div>
   
    </div>
    </article>
    </div>';


    }
    
    }   
    
    return $result;
    }


    function IdReporte($Session_IDEstacion,$year,$con){
    $sql_reporte = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$Session_IDEstacion."' AND year = '".$year."' ";
    $result_reporte = mysqli_query($con, $sql_reporte);
    while($row_listayear = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)){
    $id = $row_listayear['id'];
    }
     
    return $id;
    }

    function ValidaMesReporte($IdReporte,$fecha_mes,$con){
    $fecha_mes = date("m");

    $sql_reporte = "SELECT id_year, mes FROM op_corte_mes WHERE id_year = '".$IdReporte."' AND mes = '".$fecha_mes."' ";
    $result_reporte = mysqli_query($con, $sql_reporte);
    $numero_reporte = mysqli_num_rows($result_reporte);
      
    if($numero_reporte == 0){
    $sql_insert = "INSERT INTO op_corte_mes (
    id_year,
    mes
    ) 
    VALUES 
    (
    '".$IdReporte."',
    '".$fecha_mes."'
    )";
    return mysqli_query($con, $sql_insert);

    }
    }


    function cardsCorporativoMes($Pagina,$idReporte,$Session_IDEstacion,$Session_IDUsuarioBD,$session_idpuesto,$year,$con){
    $result = "";

    $year_c = date("Y");
    $mes_c = date("m");

    if($Pagina == "corte-diario"){
    $sql_listayear = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '".$idReporte."' ORDER BY mes ASC";
    $result_listayear = mysqli_query($con, $sql_listayear);

    while($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)){
    $id = $row_listayear['id'];
    $mes = $row_listayear['mes'];


    $result .= '<div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mb-2 mt-1">
    <article class="plan card2 border-0 shadow position-relative" onclick="corporativoMes('.$year.','.$mes.')">
           
    <div class="inner">
    <div class="row">
    <div class="col-2"> <span class="pricing"><i class="fa-solid fa-calendar-days"></i></span> </div>
    <div class="col-10"><h5 class="text-white text-center">'.nombremes($mes).' '.$year.'</h5></div>
    </div>
   
    </div>
    </article>
    </div>';
    
    }


    }else if($Pagina == "solicitud-vales"){

    for ($i=1; $i <= 12; $i++) { 
    if ($year >= $year_c) {
    if ($mes_c >= $i) {
    
    $ocultarCard = "";
    }else{
    $ocultarCard = "d-none";
    }
    }else{
    $ocultarCard = "";
    }
          
          
    //---------- Puestos: Direccion y Comercializadora; Usuario: Mauricio 
    if($session_idpuesto == 3 || $session_idpuesto == 4 || $Session_IDUsuarioBD == 292){
   
    $result .= '<div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mb-2 mt-1 '.$ocultarCard.'">
    <article class="plan card2 border-0 shadow position-relative" onclick="corporativoMesAdmin('.$year.','.$i.')">
               
    <div class="inner">
    <div class="row">
    <div class="col-2"> <span class="pricing"><i class="fa-solid fa-calendar-days"></i></span> </div>
    <div class="col-10"><h5 class="text-white text-center">'.nombremes($i).' '.$year.'</h5></div>
    </div>
       
    </div>
    </article>
    </div>';   
    
          
    //---------- Puestos: Gestoria, Encargado, Auxiliar Administrativo, Direccion de Operaciones y Dpto. Juridico
    }else if($session_idpuesto == 5 || $session_idpuesto == 6 || $session_idpuesto == 7 || $session_idpuesto == 13 || $session_idpuesto == 15){
    
    $result .= '<div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mb-2 mt-1 '.$ocultarCard.'">
    <article class="plan card2 border-0 shadow position-relative"  onclick="corporativoMes('.$year.','.$i.')">
                   
    <div class="inner">
    <div class="row">
    <div class="col-2"> <span class="pricing"><i class="fa-solid fa-calendar-days"></i></span> </div>
    <div class="col-10"><h5 class="text-white text-center">'.nombremes($i).' '.$year.'</h5></div>
    </div>
           
    </div>
    </article>
    </div>';   
          
    }
          
    }

    }else{

    for ($i=1; $i <= 12; $i++) { 
    if ($year >= $year_c) {
    if ($mes_c >= $i) {
            
    $ocultarCard = "";
    }else{
    $ocultarCard = "d-none";
    }
    }else{
    $ocultarCard = "";
    }           

    $result .= '<div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mb-2 mt-1 '.$ocultarCard.'">
    <article class="plan card2 border-0 shadow position-relative" onclick="corporativoMes('.$year.','.$i.')">
                           
    <div class="inner">
    <div class="row">
    <div class="col-2"> <span class="pricing"><i class="fa-solid fa-calendar-days"></i></span> </div>
    <div class="col-10"><h5 class="text-white text-center">'.nombremes($i).' '.$year.'</h5></div>
    </div>
                   
    </div>
    </article>
    </div>';                    
                  
    }
   
    }


    return $result;

    }

}

