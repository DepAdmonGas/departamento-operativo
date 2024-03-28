<?php
require('../../../app/help.php');

function PersonalNomina($idUsuario, $con){
    $sql = "SELECT 
    op_rh_personal.no_colaborador, 
    op_rh_personal.nombre_completo, 
    op_rh_puestos.puesto 
    FROM op_rh_personal 
    INNER JOIN op_rh_puestos ON op_rh_personal.puesto = op_rh_puestos.id
    WHERE op_rh_personal.id = '".$idUsuario."' ";
  
    $result = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $nombreNomina = $row['nombre_completo'];
    }
    return $nombreNomina; 
    }

    function nominaDeshabilitada($idUsuario, $con){
    
    $sql_listaPV = "SELECT id FROM op_recibo_nomina_v2_prima_vacacional
    WHERE id_usuario = '".$idUsuario."' AND status = 0 ORDER BY id ASC LIMIT 1"; 
        
    $result_listaPV = mysqli_query($con, $sql_listaPV);
    $numero_listaPV = mysqli_num_rows($result_listaPV); 
      
    if($numero_listaPV > 0){
      
    while($row_listaPV = mysqli_fetch_array($result_listaPV, MYSQLI_ASSOC)){
    $GET_id_primaV = $row_listaPV['id'];
    }
      
    return $GET_id_primaV;
        
    }
    }

    function nominaHabilitada($idUsuario, $con){
        
        $sql_listaPV = "SELECT id FROM op_recibo_nomina_v2_prima_vacacional
        WHERE id_usuario = '".$idUsuario."' AND status = 1 ORDER BY id DESC LIMIT 1"; 
                
        $result_listaPV = mysqli_query($con, $sql_listaPV);
        $numero_listaPV = mysqli_num_rows($result_listaPV); 
              
        if($numero_listaPV > 0){    
        while($row_listaPV = mysqli_fetch_array($result_listaPV, MYSQLI_ASSOC)){
        $GET_id_primaV = $row_listaPV['id'];
        }
            
        return $GET_id_primaV;
    
        }
    }


    //$aleatorio = uniqid();
    $numeroAleatorio = rand(1, 1000000);
  
    //$aleatorio = uniqid();
    $numeroAleatorio2 = rand(1000, 9999);
  
    $idReporte = $_POST['idReporte'];
    $idUsuario = $_POST['idUsuario'];
    $nombreUser = PersonalNomina($idUsuario,$con);
    $Importe = $_POST['Importe'];
    $NominaOriginal = $_POST['NominaOriginal'];
    $PrimaVacacional = $_POST['PrimaVacacional'];
    $ValorPrima = $_POST['ValorPrima'];
    $ValorAlerta = $_POST['ValorAlerta'];

    $NoDoc1  =   $_FILES['DocumentoAcuse_file']['name'];
    $UpDoc1 = "../../../archivos/recibos-nomina-v2/acuses/".$numeroAleatorio."-AcuseNomina".$nombreUser.$numeroAleatorio2;
    $NomDoc1 = $numeroAleatorio."-AcuseNomina".$nombreUser.$numeroAleatorio2;

    $NoDoc2  =   $_FILES['DocumentoFirma_file']['name'];
    $UpDoc2 = "../../../archivos/recibos-nomina-v2/firmados/".$numeroAleatorio."-FirmaNomina".$nombreUser.$numeroAleatorio2;
    $NomDoc2 = $numeroAleatorio."-FirmaNomina".$nombreUser.$numeroAleatorio2;
  

    $nominaDeshabilitada = nominaDeshabilitada($idUsuario,$con);
    $nominaHabilitada = nominaHabilitada($idUsuario,$con);


    if(move_uploaded_file($_FILES['DocumentoAcuse_file']['tmp_name'], $UpDoc1)){
    
    $sql_edit1 = "UPDATE op_recibo_nomina_v2 SET 
    doc_nomina = '".$NomDoc1."'
    WHERE id = '".$idReporte."'";
    mysqli_query($con, $sql_edit1);

    }
         
    if(move_uploaded_file($_FILES['DocumentoFirma_file']['tmp_name'], $UpDoc2)){
    
    $sql_edit2 = "UPDATE op_recibo_nomina_v2 SET 
    doc_nomina_firma = '".$NomDoc2."'
    WHERE id = '".$idReporte."'";
    mysqli_query($con, $sql_edit2);
    }
 
   
    if($ValorPrima == 0 && $ValorAlerta == 0 && $PrimaVacacional == 2){

    $sql_update2 = "UPDATE op_recibo_nomina_v2_prima_vacacional 
    SET status = 1
    WHERE id = '".$nominaDeshabilitada."'";

    mysqli_query($con, $sql_update2);
    
    }else if($ValorPrima == 0 && $ValorAlerta == 0 && $PrimaVacacional == 0){

    $sql_update2 = "UPDATE op_recibo_nomina_v2_prima_vacacional 
    SET status = 0
    WHERE id = '".$nominaDeshabilitada."'";
        
    mysqli_query($con, $sql_update2);
            
    }else if($ValorPrima == 2 && $ValorAlerta == 1 && $PrimaVacacional == 0){

    $sql_update2 = "UPDATE op_recibo_nomina_v2_prima_vacacional 
    SET status = 0
    WHERE id = '".$nominaHabilitada."'";
    
    mysqli_query($con, $sql_update2);
        
    }else if($ValorPrima == 2 && $ValorAlerta == 1 && $PrimaVacacional == 2){

    $sql_update2 = "UPDATE op_recibo_nomina_v2_prima_vacacional 
    SET status = 1
    WHERE id = '".$nominaHabilitada."'";
        
    mysqli_query($con, $sql_update2);
            
    }

    
    $sql_update = "UPDATE op_recibo_nomina_v2 
    SET importe_total = '".$Importe."', 
    nomina_original = '".$NominaOriginal."',
    prima_vacacional = '".$PrimaVacacional."'
    WHERE id = '".$idReporte."'";

    if(mysqli_query($con, $sql_update)){
    echo 1;


    }else{
    echo 0;
    } 


//------------------
mysqli_close($con);
//------------------  