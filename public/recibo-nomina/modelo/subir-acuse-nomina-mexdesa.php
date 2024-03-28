<?php
require('../../../app/help.php');

function nombreDepartamento($idEstacion, $con){
    $sql = "SELECT localidad
    FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
  
    $result = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $localidad = $row['localidad'];
    }
    return $localidad; 
    }
  
    //$aleatorio = uniqid();
    $numeroAleatorio = rand(1, 1000000);
  
    //$aleatorio = uniqid();
    $numeroAleatorio2 = rand(1000, 9999);
  
    $idAcuse = $_POST['idAcuse'];
    $idEstacion = $_POST['idEstacion'];
    $localidad = nombreDepartamento($idEstacion,$con);
    $year = $_POST['year'];
    $mes = $_POST['mes'];
    $SemQui = $_POST['SemQui'];
    $descripcion = $_POST['descripcion'];

    $NoDoc1  =   $_FILES['DocumentoAcuse_file']['name'];
    $UpDoc1 = "../../../archivos/recibos-nomina-v2/recibos-mexdesa/".$numeroAleatorio."-Acuses".$localidad.$numeroAleatorio2;
   
    if(move_uploaded_file($_FILES['DocumentoAcuse_file']['tmp_name'], $UpDoc1)){
    $NomDoc1 = $numeroAleatorio."-Acuses".$localidad.$numeroAleatorio2;
    }

    if($idAcuse != 0){
    
        $sql_edit1 = "UPDATE op_recibo_nomina_v2_acuses SET 
        doc_nomina_acuse = '".$NomDoc1."'
        WHERE id = '".$idAcuse."'";

        if(mysqli_query($con, $sql_edit1)){
        echo 1;
    
        }else{
        echo 0;
        } 
        

    }else{

        $sql_insert1 = "INSERT INTO op_recibo_nomina_v2_acuses  
        (year,
        mes,
        no_semana_quincena,
        descripcion,
        id_estacion,
        doc_nomina_acuse
        ) 
        VALUES
        ('".$year."',
        '".$mes."',
        '".$SemQui."',
        '".$descripcion."',
        '".$idEstacion."',
        '".$NomDoc1."'
        )";

        if(mysqli_query($con, $sql_insert1)){
        echo 1;
    
        }else{
        echo 0;
        } 

    }


//------------------
mysqli_close($con);
//------------------  