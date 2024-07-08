<?php
require('../../../app/help.php');

$idPersonal = $_POST['idPersonal'];
$idIncidencia = $_POST['idAsistencia'];
$idEstacion = $_POST['idEstacion'];

$aleatorio = uniqid();
$file = $_FILES['Documento_file']['name'];
$NombreDoc = $aleatorio."-".$file;
$upload_folder = "../../../archivos/incidencias/".$NombreDoc;

$date1 = new DateTime($_POST['FechaInicio']);
$date2 = new DateTime($_POST['FechaFin']);
$diff = $date1->diff($date2);

$Todias = $diff->days;

function Incidencia($idAsistencia, $con){
    
  $sql_incidencia = "SELECT * FROM op_rh_personal_asistencia_incidencia WHERE id_asistencia = '".$idAsistencia."' LIMIT 1 ";
  $result_incidencia = mysqli_query($con, $sql_incidencia);
  $numero_incidencia = mysqli_num_rows($result_incidencia);
  
  if ($numero_incidencia > 0) {
  while($row_incidencia = mysqli_fetch_array($result_incidencia, MYSQLI_ASSOC)){
  $fecha = $row_incidencia['fecha'];  
  $incidencia = $row_incidencia['incidencia']; 
  $comentario = $row_incidencia['comentario']; 
  $documento = $row_incidencia['documento'];  
  $estado = $row_incidencia['estado'];
  
  
  $return = array (
  "fecha" => $fecha,
  "incidencia" => $incidencia,
  "comentario" => $comentario,
  "documento" => $documento,
  "estado" => $estado,
  "resultado" => 1
  ); 
  }
  
  }else{
  $return = array (
  "fecha" => "",
  "incidencia" => "",
  "comentario" => "",
  "documento" => "",
  "estado" => "",
  "resultado" => 0
  ); 
  }
  
  return $return;
}


$incidencia = Incidencia($idIncidencia, $con);

    function idAsistencia($con){
    $sql = "SELECT id FROM op_rh_personal_asistencia ORDER BY id DESC LIMIT 1 ";
    $result = mysqli_query($con, $sql);
    $numero = mysqli_num_rows($result);  
    if($numero > 0){
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $idAsistencia = $row['id'] + 1;
    }
    }else{
    $idAsistencia = 1;
    }    
    return $idAsistencia; 
    }

    function ValidaAsistencia($id,$fecha,$con){
      $sql = "SELECT id FROM op_rh_personal_asistencia
      WHERE id_personal = '".$id."' AND fecha = '".$fecha."' LIMIT 1 ";
      $result_root = mysqli_query($con, $sql);
      $row_root = mysqli_num_rows($result_root);
      if ($row_root > 0) {   
      $resultado = 1;
      }else{
      $resultado = 0; 
      }   
      return $resultado;
    }

    function HentradaHsalida($idPDecrypt,$diaFecha,$con){

    $sql = "SELECT hora_entrada, hora_salida FROM op_rh_personal_horario
    WHERE id_personal = '".$idPDecrypt."' AND dia = '".$diaFecha."' LIMIT 1 ";
    $result_root = mysqli_query($con, $sql);
    $row_root = mysqli_num_rows($result_root);
    while($row_root = mysqli_fetch_array($result_root, MYSQLI_ASSOC)){   
    $horaentrada = $row_root['hora_entrada'];
    $horasalida = $row_root['hora_salida'];
    }

    $return = array (
    "horaentrada" => $horaentrada,
    "horasalida" => $horasalida            
    );          

    return $return;

    }

    function Retardo($idEmpresa,$con){
    $sql_retardo = "SELECT retardo FROM op_rh_localidades_retardo_incidencia ";
    $result_retardo = mysqli_query($con, $sql_retardo);
    $numero_retardo = mysqli_num_rows($result_retardo);  
    while($row_retardo = mysqli_fetch_array($result_retardo, MYSQLI_ASSOC)){
    $retardo = $row_retardo['retardo'];
    }
    return $retardo;
    }

    function Incidencias($idEmpresa,$con){
    $sql_incidencia = "SELECT incidencia FROM op_rh_localidades_retardo_incidencia ";
    $result_incidencia = mysqli_query($con, $sql_incidencia);
    $numero_incidencia = mysqli_num_rows($result_incidencia);  
    while($row_incidencia = mysqli_fetch_array($result_incidencia, MYSQLI_ASSOC)){
    $incidencia = $row_incidencia['incidencia'];
    }
    return $incidencia;
    }

    function Salario($id,$con){
    $sql_incidencia = "SELECT id, sd FROM op_rh_personal WHERE id = '".$id."' ";
    $result_incidencia = mysqli_query($con, $sql_incidencia);
    $numero_incidencia = mysqli_num_rows($result_incidencia);  
    while($row_incidencia = mysqli_fetch_array($result_incidencia, MYSQLI_ASSOC)){
    $salario = $row_incidencia['sd'];
    }
    return $salario;  
    }

for ($i = 1; $i <= $Todias; $i++) {



$fecha = date("Y-m-d",strtotime($_POST['FechaInicio']."+ $i days")); 

if(ValidaAsistencia($idPersonal,$fecha,$con) == 0){
$diaFecha = nombreDia($fecha);
$idAsistencia = idAsistencia($con);
$HentradaHsalida = HentradaHsalida($idPersonal,$diaFecha,$con); 
$retardo = Retardo($idEstacion,$con);
$incidencias = Incidencias($idEstacion,$con);
$Salario = Salario($idPersonal,$con);

if($HentradaHsalida['horaentrada'] == "00:00:00" && $HentradaHsalida['horasalida'] == "00:00:00"){
$SueldoDia = 0;  
}else{
$SueldoDia = $_POST['SueldoDiaI'];    
}

 $sql_insert = "INSERT INTO op_rh_personal_asistencia (
 id,
 id_estacion,
 id_personal,
 fecha,
 hora_entrada,
 hora_salida,
 hora_entrada_sensor,
 hora_salida_sensor,
 retardo_minutos,
 incidencia_dias,
 incidencia,
 sd) 
 VALUES (
 '".$idAsistencia."',
 '".$idEstacion."',
 '".$idPersonal."', 
 '".$fecha."', 
 '".$HentradaHsalida['horaentrada']."', 
 '".$HentradaHsalida['horasalida']."', 
 '',
 '',
 '".$retardo."',
 '".$incidencias."',
 '".$SueldoDia."',
 '".$Salario."')";
 if(mysqli_query($con, $sql_insert)){
 
}else{
$resultado = 0;
}     
}

}

 if(move_uploaded_file($_FILES['Documento_file']['tmp_name'], $upload_folder)){

$sql_edit = "UPDATE op_rh_personal_asistencia_incidencia SET 
documento = '".$NombreDoc."'
WHERE id_asistencia = '".$_POST['idAsistencia']."' ";

if(mysqli_query($con, $sql_edit)) {

$sql_edit1 = "UPDATE op_rh_personal_asistencia SET 
incidencia = '".$_POST['SueldoDiaI']."'
WHERE id = '".$idIncidencia."' ";


if(mysqli_query($con, $sql_edit1)) {
$result = 1;
}else{
$result = 0;
}


}else{
$result = 0;
}

echo $result;

}

//------------------
mysqli_close($con);
//------------------