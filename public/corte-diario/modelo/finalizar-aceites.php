<?php
require ('../../../app/help.php');

$idreporte = $_POST['IdReporte'];

function toquenUser($id, $con)
{

  $sql_firma = "SELECT * FROM tb_usuarios_token WHERE id_usuario = '" . $id . "' AND herramienta = 'token-web' ";
  $result_firma = mysqli_query($con, $sql_firma);
  while ($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)) {
    $token = $row_firma['token'];
  }

  return $token;
}

function Mes($id, $con)
{
  $sql_mes = "SELECT id_year, mes FROM op_corte_mes WHERE id = '" . $id . "' LIMIT 1 ";
  $result_mes = mysqli_query($con, $sql_mes);
  while ($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)) {
    $mes = $row_mes['mes'];
    $idyear = $row_mes['id_year'];
  }
  $array = array("mes" => $mes, "idyear" => $idyear);
  return $array;
}

function NewAlmacen($IDEstacion, $idreporte, $con)
{

  date_default_timezone_set('America/Mexico_City');
  $year = date("Y");

  $mes = Mes($idreporte, $con);
  if ($mes['mes'] == 12) {

    $newmes = 1;
    $newyear = $year;
    $IdYear = ValidaYearReporte($IDEstacion, $newyear, $con);
    $IdMes = ValidaMesReporte($IdYear, $newmes, $con);
    AgregarAlmacen($IDEstacion, $IdMes, $idreporte, $con);

  } else {

    $newmes = $mes['mes'] + 1;
    $idyear = $mes['idyear'];
    $IdMes = ValidaMesReporte($idyear, $newmes, $con);
    AgregarAlmacen($IDEstacion, $IdMes, $idreporte, $con);


  }
}

function IdYear($con)
{

  $sql_reporte = "SELECT id FROM op_corte_year ORDER BY id desc LIMIT 1 ";
  $result_reporte = mysqli_query($con, $sql_reporte);
  $numero_reporte = mysqli_num_rows($result_reporte);
  while ($row_mes = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {
    $id = $row_mes['id'] + 1;
  }
  return $id;
}

function IdMes($con)
{

  $sql_reporte = "SELECT id FROM op_corte_mes ORDER BY id desc LIMIT 1 ";
  $result_reporte = mysqli_query($con, $sql_reporte);
  $numero_reporte = mysqli_num_rows($result_reporte);
  while ($row_mes = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {
    $id = $row_mes['id'] + 1;
  }
  return $id;
}

function ValidaYearReporte($Session_IDEstacion, $fecha_year, $con)
{

  $sql_reporte = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '" . $Session_IDEstacion . "' AND year = '" . $fecha_year . "' ";
  $result_reporte = mysqli_query($con, $sql_reporte);
  $numero_reporte = mysqli_num_rows($result_reporte);

  if ($numero_reporte == 0) {
    $IdYear = IdYear($con);
    $sql_insert = "INSERT INTO op_corte_year (
    id,
    id_estacion,
    year
    )
    VALUES 
    (
    '" . $IdYear . "',
    '" . $Session_IDEstacion . "',
    '" . $fecha_year . "'
    )";
    mysqli_query($con, $sql_insert);
  } else {
    while ($row_mes = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {
      $IdYear = $row_mes['id'];
    }
  }

  return $IdYear;
}

function ValidaMesReporte($IdReporte, $fecha_mes, $con)
{

  $sql_reporte = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '" . $IdReporte . "' AND mes = '" . $fecha_mes . "' ";
  $result_reporte = mysqli_query($con, $sql_reporte);
  $numero_reporte = mysqli_num_rows($result_reporte);

  if ($numero_reporte == 0) {

    $IdMes = IdMes($con);

    $sql_insert = "INSERT INTO op_corte_mes (
    id,
    id_year,
    mes
    )
    VALUES 
    (
    '" . $IdMes . "',
    '" . $IdReporte . "',
    '" . $fecha_mes . "'
    )";
    mysqli_query($con, $sql_insert);
  } else {
    while ($row_mes = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {
      $IdMes = $row_mes['id'];
    }

  }

  return $IdMes;
}

function AgregarAlmacen($IDEstacion, $IdMes, $idreporte, $con)
{

  $sql1 = "DELETE FROM op_inventario_aceites WHERE id_mes = '" . $IdMes . "' AND id_estacion = '" . $IDEstacion . "' ";
  if (mysqli_query($con, $sql1)) {


    $sql_reporte = "SELECT id_aceite, inventario_exibidores, inventario_bodega FROM op_aceites_lubricantes_reporte WHERE id_mes = '" . $idreporte . "' ";
    $result_reporte = mysqli_query($con, $sql_reporte);
    $numero_reporte = mysqli_num_rows($result_reporte);
    while ($row_mes = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {

      $idAeite = idAeite($row_mes['id_aceite'], $con);

      $sql_insert = "INSERT INTO op_inventario_aceites (
    id_mes,
    id_estacion,
    id_aceite,
    exhibidores,
    bodega
    )
    VALUES 
    (
    '" . $IdMes . "',
    '" . $IDEstacion . "',
    '" . $idAeite . "',
    '" . $row_mes['inventario_exibidores'] . "',
    '" . $row_mes['inventario_bodega'] . "'
    )";

      if (mysqli_query($con, $sql_insert)) {

      } else {

      }

    }

  }

}

function idAeite($idaceite, $con)
{

  $sql_reporte = "SELECT id FROM op_aceites WHERE id_aceite = '" . $idaceite . "' LIMIT 1 ";
  $result_reporte = mysqli_query($con, $sql_reporte);
  $numero_reporte = mysqli_num_rows($result_reporte);
  while ($row_mes = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {
    $return = $row_mes['id'];
  }

  return $return;
}

$sql_insert = "INSERT INTO op_aceites_lubricantes_reporte_finalizar (
   id_mes
    )
    VALUES 
    (
    '" . $idreporte . "'
    )";

$nomMes = Mes($idreporte, $con);

if (mysqli_query($con, $sql_insert)) {

  NewAlmacen($Session_IDEstacion, $idreporte, $con);

  $token = toquenUser(19, $con);
  $detalle = 'Se finalizo el inventario de ' . nombremes($nomMes['mes']) . ', de la estación ' . $session_nomestacion;
  sendNotification($token, $detalle);

  echo 1;
} else {
  echo 0;
}

function sendNotification($token, $detalle)
{
  $url = "https://fcm.googleapis.com/fcm/send";
  $fields = array(
    "to" => $token,
    "notification" => array(
      "body" => $detalle,
      "title" => "Portal AdmonGas",
      "icon" => "",
      "click_action" => "https://asuntoslegales.tmfsmexico.com/asuntos-legales/"
    )
  );
  $headers = array(
    'Authorization: key=AAAAccs8Ry4:APA91bFc3rlPHpHHyABA01dZPc4J9ZChulB2nmBZp0VW5ODR-uDq2Lnz0YvlpROjZrFgIl2UBFHqOPhPM8c5ho-8IR6XuFpwv8_WT_Y-av9vXav4_6eGsZrUdtrMl9GwDWDNZee0Ppli',
    'Content-Type:application/json'
  );
  $ch = curl_init();
  // Set the url, number of POST vars, POST data
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  // Disabling SSL Certificate support temporarily
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
  $result = curl_exec($ch);
  curl_close($ch);
}

//------------------
mysqli_close($con);
//------------------