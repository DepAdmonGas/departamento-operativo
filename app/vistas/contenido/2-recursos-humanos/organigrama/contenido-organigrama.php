<?php
require ('../../../../help.php');
$idOrganigrama = $_GET['idOrganigrama'];
$idEstacion = $_GET['idEstacion'];
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);


if ($idOrganigrama == 0) {
$sql_organigrama = "SELECT * FROM op_rh_organigrama_estacion WHERE id_estacion = '" . $idEstacion . "' ORDER BY version DESC LIMIT 1";
} else {
$sql_organigrama = "SELECT * FROM op_rh_organigrama_estacion WHERE id = '" . $idOrganigrama . "' ";
}

$result_organigrama = mysqli_query($con, $sql_organigrama);
$numero_organigrama = mysqli_num_rows($result_organigrama);
if ($numero_organigrama > 0) {
while ($row_organigrama = mysqli_fetch_array($result_organigrama, MYSQLI_ASSOC)) {
$archivo = '<img style="width: 100%" src="archivos/organigrama/' . $row_organigrama['archivo'] . '">';
}
} else {
$archivo = '';
}
 
$sql_lista = "SELECT * FROM op_rh_organigrama_estacion WHERE id_estacion = '" . $idEstacion . "' ORDER BY version DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

$tablaAL = "";
$ColorTB = "tables-bg";
$tablaDesc1 = '<th class="text-center align-middle">Versión</th>';
$tablaDesc2 = '<th class="align-middle text-center" width="20"><img src="'.RUTA_IMG_ICONOS.'eliminar.png"></th>';
$Div2 = '';
$ocultarTitle = "";


if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$Estacion = "";
if($idEstacion == 9){
$Div2 = '<hr>';
$tablaAL = '<tr class="tables-bg">
<th class="text-center align-middle tableStyle fw-bold" colspan="4">Autolavado</th>
</tr>';
$tablaDesc = "td";
$tablaDesc1 = '<td class="text-center align-middle tableStyle fw-bold">Versión</td>';
$tablaDesc2 = '<td class="align-middle text-center" width="20"><img src="'.RUTA_IMG_ICONOS.'eliminar.png"></td>';
$ColorTB = "title-table-bg";
$ocultarTitle = "d-none";

}

}else{
$ColorTB = "tables-bg";
$Estacion = '('.$datosEstacion['localidad'].')';

}

  

?>

<?=$Div2 ?>

<div class="col-12 <?=$ocultarTitle?>">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Recursos Humanos</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Organigrama <?=$Estacion?></li>
</ol>
</div>

<div class="row">
<div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
<h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Organigrama <?=$Estacion?></h3>
</div>

<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
<div class="text-end">


<?php 
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
if ($idEstacion == 2) { 
?>

<div class="dropdown d-inline ms-2">
<button type="button" class="btn btn-primary btn-labeled2" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
<span class="btn-label2"> <i class="fa-solid fa-plus"></i></span>Agregar
</button>

<ul class="dropdown-menu">
<li onclick="Mas(<?= $idEstacion ?>)"><a class="dropdown-item pointer"> <i class="fa-solid fa-gas-pump"></i> Palo Solo</a></li>
<li onclick="Mas(9)"><a class="dropdown-item pointer"> <i class="fa-solid fa-car"></i> Autolavado</a></li>
</ul>
</div>

<?php } else { ?>
<button type="button" class="btn btn-labeled2 btn-primary" onclick="Mas(<?=$idEstacion?>)"> <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
<?php }
}else{
?>
<button type="button" class="btn btn-labeled2 btn-primary" onclick="Mas(<?=$idEstacion?>)"> <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
<?php }  ?>

</div>

</div>
</div>

<hr>
          
</div>


<div class="row">

<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-3">
<?= $archivo; ?>
</div>

<div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">

<div class="row">

<div class="col-12">
<div class="table-responsive">
<table id="tabla_organigrama" class="custom-table " style="font-size: .8em;" width="100%">
<thead class="<?=$ColorTB?>">
<?=$tablaAL?>
<tr>
<?=$tablaDesc1?>                            
<th class="text-center align-middle tableStyle font-weight-bold">Fecha y hora</th>
<th class="text-center align-middle tableStyle font-weight-bold">Observaciones</th>
<?=$tablaDesc2?>                            
</tr>
</thead>

<tbody class="bg-white">
<?php
if ($numero_lista > 0) {
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
$id = $row_lista['id'];
$explode = explode(' ', $row_lista['fechacreacion']);

echo '<tr class="pointer" onclick="SelEstacion(' . $idEstacion . ',' . $id . ')">
<th class="align-middle text-center"><b>' . $row_lista['version'] . '</b></th>
<td class="align-middle">' . $ClassHerramientasDptoOperativo->FormatoFecha($explode[0]) . ', ' . date("g:i a", strtotime($explode[1])) . '</td>
<td class="text-center align-middle"><small>' . $row_lista['observaciones'] . '</small></td>
<td class="align-middle text-center pointer" width="20" onclick="Eliminar(' . $idEstacion . ',' . $id . ')"><img src="' . RUTA_IMG_ICONOS . 'eliminar.png"></td>
</tr>';
}

} else {
echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}

?>
</tbody>
</table>
</div>
</div>


<div class="col-12">
<hr>

<div class="row">
<div class="col-12">
<button type="button" class="btn btn-labeled2 btn-primary float-end mb-3" onclick="MasPlantilla(<?=$idEstacion?>)"> <span class="btn-label2"><i class="fa-solid fa-sitemap"></i></span>Agregar plantilla</button>
</div>

<div class="col-12" id="tabla_plantilla"></div>
</div>

</div>

<?php

if($idEstacion == 1 || $idEstacion == 2 || $idEstacion == 3 || $idEstacion == 4 || $idEstacion == 5 || $idEstacion == 6 || $idEstacion == 7 || $idEstacion == 14){
echo '<div class="col-12">';
echo '<hr>';
$sql_registro = "SELECT 
tb_organigrama_estaciones.id,
tb_estaciones.razonsocial,
tb_organigrama_estaciones.registro_patronal,
tb_organigrama_estaciones.calle,
tb_organigrama_estaciones.numero_exterior,
tb_organigrama_estaciones.numero_interior,
tb_organigrama_estaciones.colonia,
tb_organigrama_estaciones.codigo_postal,
tb_organigrama_estaciones.estado,
tb_organigrama_estaciones.municipio,
tb_organigrama_estaciones.numero_telefono
FROM tb_organigrama_estaciones 
INNER JOIN tb_estaciones ON tb_organigrama_estaciones.id_estacion = tb_estaciones.id
WHERE tb_organigrama_estaciones.id_estacion = '" . $idEstacion . "'";
$result_registro = mysqli_query($con, $sql_registro);
$numero_registro = mysqli_num_rows($result_registro);

while ($row_registro = mysqli_fetch_array($result_registro, MYSQLI_ASSOC)) {
$id = $row_registro['id'];
$nombre = $row_registro['razonsocial'];
$registro = $row_registro['registro_patronal'];
$calle = $row_registro['calle'];
$exterior = $row_registro['numero_exterior'];
$interior = $row_registro['numero_interior'];
$colonia = $row_registro['colonia'];
$cp = $row_registro['codigo_postal'];
$estado = $row_registro['estado'];
$municipio = $row_registro['municipio'];
$telefono = $row_registro['numero_telefono'];


echo '
<div class="table-responsive">
<table class="custom-table" style="font-size: .8em;" width="100%">
<thead class="tables-bg">
<th>Nombre de la empresa</th>
<th>'.$nombre.'</th>
</thead>
<tbody class="bg-white">
  
<tr>
<th class="no-hover">Registro Patronal</th>
<td class="no-hover p-0"><input onchange="datosRazonSocial(this,'.$id.',1)" class="form-control border-0 text-center" type="text" value="'.$registro.'" style="font-size: 1em;"></td>
</tr>
 
<tr>
<th class="no-hover">Calle</th>
<td class="no-hover p-0"><input onchange="datosRazonSocial(this,'.$id.',2)" class="form-control border-0 text-center" type="text" value="'.$calle.'" style="font-size: 1em;"></td>
</tr>

<tr>
<th class="no-hover">Numero Ext.</th>
<td class="no-hover p-0"><input onchange="datosRazonSocial(this,'.$id.',3)" class="form-control border-0 text-center" type="text" value="'.$exterior.'" style="font-size: 1em;"></td>
</tr>

<tr>
<th class="no-hover">Numero Int. </th>
<td class="no-hover p-0"><input onchange="datosRazonSocial(this,'.$id.',4)" class="form-control border-0 text-center" type="text" value="'.$interior.'" style="font-size: 1em;"></td>
</tr>

<tr>
<th class="no-hover">Colonia</th>
<td class="no-hover p-0"><input onchange="datosRazonSocial(this,'.$id.',5)" class="form-control border-0 text-center" type="text" value="'.$colonia.'" style="font-size: 1em;"></td>
</tr>

<tr>
<th class="no-hover">Codigo Postal</th>
<td class="no-hover p-0"><input onchange="datosRazonSocial(this,'.$id.',6)" class="form-control border-0 text-center" type="text" value="'.$cp.'" style="font-size: 1em;"></td>
</tr>

<tr>
<th class="no-hover">Estado</th>
<td class="no-hover p-0"><input onchange="datosRazonSocial(this,'.$id.',7)" class="form-control border-0 text-center" type="text" value="'.$estado.'" style="font-size: 1em;"></td>
</tr>

<tr>
<th class="no-hover">Municipio</th>
<td class="no-hover p-0"><input onchange="datosRazonSocial(this,'.$id.',8)" class="form-control border-0 text-center" type="text" value="'.$municipio.'" style="font-size: 1em;"></td>
</tr>

<tr>
<th class="no-hover">Numero de telefono</th>
<td class="no-hover p-0"><input onchange="datosRazonSocial(this,'.$id.',9)" class="form-control border-0 text-center" type="text" value="'.$telefono.'" style="font-size: 1em;"></td>
</tr>


</tbody>
</table>
</div>';


}

echo '</div>';
}

?>

</div>
</div>

</div>
</div>