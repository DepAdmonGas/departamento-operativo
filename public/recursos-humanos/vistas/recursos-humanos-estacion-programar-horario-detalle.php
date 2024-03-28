<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$idEstacion = $Session_IDEstacion;
$idReporte = $GET_idReporte;

$sql_empresa = "SELECT * FROM op_rh_personal_horario_programar WHERE id = '".$idReporte."' AND estado >= 1 ";
$result_empresa = mysqli_query($con, $sql_empresa);
$numero_empresa = mysqli_num_rows($result_empresa);
while($row_empresa = mysqli_fetch_array($result_empresa, MYSQLI_ASSOC)){
$fecha = $row_empresa['fecha'];
}


$sql_personal = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_personal.curp,
op_rh_personal.sd,
op_rh_puestos.puesto,
op_rh_personal.estado
FROM op_rh_personal
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.id ASC ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);

function Horarios($idEstacion,$con){
if($idEstacion == 9){
$idEstacion = 2;  
}else{
$idEstacion = $idEstacion;  
}
$sql_horario = "SELECT *
FROM op_rh_localidades_horario WHERE id_estacion = '".$idEstacion."' ";
$result_horario = mysqli_query($con, $sql_horario);
$numero_horario = mysqli_num_rows($result_horario);
while($row_horario = mysqli_fetch_array($result_horario, MYSQLI_ASSOC)){
$array1[] = $row_horario['titulo'];
}
return $array1;
}

$Horarios = Horarios($idEstacion,$con);

function BuscarHorario($dia,$idPersonal,$idReporte,$con){
$NomDia = NomDia($dia);
$sql_horario = "SELECT *
FROM op_rh_personal_horario_programar_detalle
WHERE id_reporte = '".$idReporte."' AND id_personal = '".$idPersonal."' AND dia = '".$NomDia."' ";
$result_horario = mysqli_query($con, $sql_horario);
$numero_horario = mysqli_num_rows($result_horario);
while($row_horario = mysqli_fetch_array($result_horario, MYSQLI_ASSOC)){
$resultado = $row_horario['horario'];
}
return $resultado;
}

function BuscarHorarioFormato($dia,$idPersonal,$idReporte,$con){
$NomDia = NomDia($dia);
$sql_horario = "SELECT *
FROM op_rh_personal_horario_programar_detalle
WHERE id_reporte = '".$idReporte."' AND id_personal = '".$idPersonal."' AND dia = '".$NomDia."' ";
$result_horario = mysqli_query($con, $sql_horario);
$numero_horario = mysqli_num_rows($result_horario);
if($numero_horario > 0){
while($row_horario = mysqli_fetch_array($result_horario, MYSQLI_ASSOC)){
if($row_horario['hora_entrada'] == "00:00:00" && $row_horario['hora_salida'] == "00:00:00"){
$resultado = "Descanso";
}else{
$resultado = date("g:i a",strtotime($row_horario['hora_entrada'])).' a '.date("g:i a",strtotime($row_horario['hora_salida']));
}
}
}else{
$resultado = "S/I";  
}
return $resultado;
}

function NomDia($dia){
if ($dia=="1") $dia="Lunes";
if ($dia=="2") $dia="Martes";
if ($dia=="3") $dia="Miércoles";
if ($dia=="4") $dia="Jueves";
if ($dia=="5") $dia="Viernes";
if ($dia=="6") $dia="Sábado";
if ($dia=="7") $dia="Domingo";
return $dia;
}
?>
<html lang="es">
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
  <link href="<?=RUTA_CSS2;?>navbar-general.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
 
  <style media="screen">
    .sel-text{
    font-size: .9em;
  }
  </style>

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

    });

    function Regresar(){
    window.history.back();
    }

  </script>
  </head>
 
  <body>
  <div class="LoaderPage"></div>


    <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <?php include_once "public/navbar/navbar-perfil.php";?>
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">

  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3">

    <div class="row">
    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

     <h5>Recursos humanos programar horario</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

  <div class="row">
    <div class="col-sm-2 col-12 mb-3">
    <label class="mb-1"><b class="text-secondary">Fecha programada:</b> <div><?=FormatoFecha($fecha);?></div></label>
    </div>
  </div>

<div class=" table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle">#</th>
  <th class="align-middle">Nombre completo</th>
  <th class="align-middle" width="170">Lunes</th>
  <th class="align-middle" width="170">Martes</th>
  <th class="align-middle" width="170">Miercoles</th>
  <th class="align-middle" width="170">Jueves</th>
  <th class="align-middle" width="170">Viernes</th>
  <th class="align-middle" width="170">Sabado</th>
  <th class="align-middle" width="170">Domingo</th>
  </tr>
</thead> 
<tbody>
<?php 
if ($numero_personal > 0) {
while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$id = $row_personal['id'];

$Dia1 = BuscarHorarioFormato(1,$id,$idReporte,$con);
$Dia2 = BuscarHorarioFormato(2,$id,$idReporte,$con);
$Dia3 = BuscarHorarioFormato(3,$id,$idReporte,$con);
$Dia4 = BuscarHorarioFormato(4,$id,$idReporte,$con);
$Dia5 = BuscarHorarioFormato(5,$id,$idReporte,$con);
$Dia6 = BuscarHorarioFormato(6,$id,$idReporte,$con);
$Dia7 = BuscarHorarioFormato(7,$id,$idReporte,$con);

if($Dia1 != "S/I" || $Dia2 != "S/I" || $Dia3 != "S/I" || $Dia4 != "S/I" || $Dia5 != "S/I" || $Dia6 != "S/I" || $Dia7 != "S/I"){

echo '<tr>';
echo '<td class="text-center align-middle">'.$row_personal['id'].'</td>';
echo '<td class="align-middle"><b>'.$row_personal['nombre_completo'].'</b></td>';

echo '<td class="align-middle">'.$Dia1.'</td>';
echo '<td class="align-middle">'.$Dia2.'</td>';
echo '<td class="align-middle">'.$Dia3.'</td>';
echo '<td class="align-middle">'.$Dia4.'</td>';
echo '<td class="align-middle">'.$Dia5.'</td>';
echo '<td class="align-middle">'.$Dia6.'</td>';
echo '<td class="align-middle">'.$Dia7.'</td>';
echo '</tr>';  
}
}
}else{
echo "<tr><td colspan='10' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table> 
</div>
<?php
if($idEstacion == 2){

$sql = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_personal.curp,
op_rh_personal.sd,
op_rh_puestos.puesto,
op_rh_personal.estado
FROM op_rh_personal
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id_estacion = 9 AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.id ASC ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
?>
<div class=" table-responsive">
<table class="table table-sm table-bordered table-hover mt-4 mb-0" style="font-size: .9em;">
<thead class="bg-light">
<th class="text-center align-middle" colspan="9">Autolavado</th>
</thead>

<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle">#</th>
  <th class="align-middle">Nombre completo</th>
  <th class="align-middle" width="170">Lunes</th>
  <th class="align-middle" width="170">Martes</th>
  <th class="align-middle" width="170">Miercoles</th>
  <th class="align-middle" width="170">Jueves</th>
  <th class="align-middle" width="170">Viernes</th>
  <th class="align-middle" width="170">Sabado</th>
  <th class="align-middle" width="170">Domingo</th>
  </tr>
</thead> 
<tbody>
<?php 
if ($numero > 0) {
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$id = $row['id'];

$DiaA1 = BuscarHorarioFormato(1,$id,$idReporte,$con);
$DiaA2 = BuscarHorarioFormato(2,$id,$idReporte,$con);
$DiaA3 = BuscarHorarioFormato(3,$id,$idReporte,$con);
$DiaA4 = BuscarHorarioFormato(4,$id,$idReporte,$con);
$DiaA5 = BuscarHorarioFormato(5,$id,$idReporte,$con);
$DiaA6 = BuscarHorarioFormato(6,$id,$idReporte,$con);
$DiaA7 = BuscarHorarioFormato(7,$id,$idReporte,$con);

if($DiaA1 != "S/I" || $DiaA2 != "S/I" || $DiaA3 != "S/I" || $DiaA4 != "S/I" || $DiaA5 != "S/I" || $DiaA6 != "S/I" || $DiaA7 != "S/I"){
echo '<tr>';
echo '<td class="text-center">'.$row['id'].'</td>';
echo '<td class="align-middle"><b>'.$row['nombre_completo'].'</b></td>';
echo '<td class="align-middle">'.$DiaA1.'</td>';
echo '<td class="align-middle">'.$DiaA2.'</td>';
echo '<td class="align-middle">'.$DiaA3.'</td>';
echo '<td class="align-middle">'.$DiaA4.'</td>';
echo '<td class="align-middle">'.$DiaA5.'</td>';
echo '<td class="align-middle">'.$DiaA6.'</td>';
echo '<td class="align-middle">'.$DiaA7.'</td>';
echo '</tr>';
}

}
}else{
echo "<tr><td colspan='10' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table> 
<?php
}
?>

  

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>