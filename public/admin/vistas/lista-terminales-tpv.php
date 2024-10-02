<?php 
require('../../../app/help.php'); 
$idEstacion = $_GET['idEstacion'];
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($idEstacion);

$sql_lista = "SELECT * FROM op_terminales_tpv WHERE id_estacion = '".$idEstacion."' AND status = 1 ORDER BY tpv ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

function Reporte($id,$con){

$sql = "SELECT * FROM op_terminales_tpv_reporte WHERE id_tpv = '".$id."' AND status = 0 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

return $numero;
}
 

//---------- Configuracion personal ----------//
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$titleMenu = '<i class="fa-solid fa-house"></i> Almacén';
$Estacion = '';
$ocultarTB = "d-none";

}else{ 
$titleMenu = '<i class="fa-solid fa-chevron-left"></i> Mantenimiento';
$Estacion = '('.$datosEstacion['nombre'].')';
$ocultarTB = "";
  
} 

?> 


<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"> <?=$titleMenu?></a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Terminales Punto de Venta <?=$Estacion?></li>
</ol>
</div>

<div class="row">
<div class="col-xl-9 col-lg-9 col-md-6 col-sm-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Terminales Punto de Venta <?=$Estacion?></h3></div>
<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Agregar(<?=$idEstacion;?>)">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
</div>

</div>
<hr>
</div>

<div class="table-responsive">
<table id="tabla_tpv_<?=$idEstacion?>" class="custom-table" style="font-size: .8em;" width="100%">

<thead class="tables-bg">
<tr>
<th class="align-middle text-center">#</th>
<th class="align-middle text-center">TPV'S</th>
<th class="align-middle text-center">No DE SERIE</th>
<th class="align-middle text-center">MODELO/MARCA</th>
<th class="align-middle text-center">No LOTE</th>
<th class="align-middle text-center">TIPO DE CONEXIÓN</th>
<th class="align-middle text-center">NUMERO DE AFILIACION</th>
<th class="align-middle text-center">TELEFONO ATENCION A CLIENTES</th>
<th class="align-middle text-center">ACTIVAS</th>
<th class="align-middle text-center">ROLLOS</th>
<th class="align-middle text-center">CARGADORES</th>
<th class="align-middle text-center">PEDESTALES EN BUEN ESTADO</th>
<th class="align-middle text-center">ESTADO TPV'S</th>
<th class="align-middle text-center">NO. DE IMPRESIONES</th>
<th class="align-middle text-center">TIPO DE TPV'S</th>
<th class="align-middle text-center" width="40"><i class="fas fa-ellipsis-v text-white"></i> </th>
</tr>
</thead>

<tbody class="bg-white">
    
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

if(Reporte($id,$con) == 1){
$fondo = 'style="background-color: #ffb6af"'; 
}else{
$fondo = "";	
}

echo '<tr '.$fondo.'>';
echo '<th class="align-middle text-center">'.$num.'</th>';
echo '<td class="align-middle text-center">'.$row_lista['tpv'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['no_serie'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['modelo'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['no_lote'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['tipo_conexion'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['no_afiliacion'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['telefono'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['estado'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['rollos'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['cargadores'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['pedestales'].'</td>';

echo '<td class="align-middle text-center">'.$row_lista['estatus_tpv'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['no_impresiones'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['tipo_tpv'].'</td>';

echo '<td class="align-middle text-center"> 
<div class="dropdown">

<a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>

<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
<a class="dropdown-item" onclick="ModalDetalle('.$idEstacion.','.$id.')"><i class="fa-regular fa-eye"></i> Detalle</a>
<a class="dropdown-item" onclick="ModalEditar('.$idEstacion.','.$id.')"><i class="fa-solid fa-pencil"></i> Editar</a>
<a class="dropdown-item" onclick="ModalFalla('.$idEstacion.','.$id.')"><i class="fa-solid fa-triangle-exclamation"></i> Falla TPV</a>
<a class="dropdown-item '.$ocultarTB.'" onclick="Eliminar('.$idEstacion.','.$id.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>
</div>

</div>

</td>';

echo '</tr>';

$num++;
}

}

if ($idEstacion == 1) {
echo '<tr class="ultima-fila">
<th class="text-center bg-white" colspan="16">BOULEVARD MAGNO CENTRO No 8 BOSQUES DE LAS PALMAS HUIXQUILUCAN EDO DE MEX C.P. 52787 MEXICO RFC: AGI990422EL7 MAIL: g500interlomas@admongas.com.mx TELF: 5552907260 </th>
</tr>
<tr class="ultima-fila">
<th class="text-center bg-warning" colspan="16">CODIGO POSTAL PARA BANCOMER ES: 52760</th>
</tr>';

} else if ($idEstacion == 2) {
echo '<tr class="ultima-fila">
<th class="text-center bg-white" colspan="16">AV. PALO SOLO 3515 PALO SOLO  C.P. 52778 HUIXQUILUCAN ESTADO DE MEXICO RFC AGA960830CW6 TELF: 5550490431</th>
</tr>';

} else if ($idEstacion == 3) {
echo '<tr class="ultima-fila">
<th class="text-center bg-white" colspan="16">CALZADA SAN AGUSTIN No 1 COLONIA 10 DE ABRIL  C. P. 53320  NAUCALPAN DE JUAREZ EDO DE MEXICO  RFC AGS9904221T6  TELF: 5553600789 </th>
</tr>';
} else if ($idEstacion == 4) {
echo '<tr class="ultima-fila">
<th class="text-center bg-white" colspan="16">CARR RIO HONDO HUIXQUILUCAN No 401 SAN BARTOLOME COATEPEC C.P. 52796  MEXICO  HUIXQUILUCAN EDO DE MEX  C.P para bancomer(52773) MAIL: gasomira@hotmail.com Telf: 5582889447 (G500) </th>
</tr>';

} else if ($idEstacion == 5) {
echo '<tr class="ultima-fila">
<th class="text-center bg-white" colspan="16"> CARRETERA LAGO DE GAUDALUPE KM 5.5 COL VILLAS DE LAS HACIENDA C.P. 52929 ATIZAPAN DE ZARAGOZA  EDO. DE MEXICO RFC:GVG310114GU6 TELF: 5558195682 </th>
</tr>';

} else if ($idEstacion == 6) {
echo '<tr class="ultima-fila">
<th class="text-center bg-white" colspan="16">AV. JORGE JIMENEZ CANTU 30 MZ. 1 LT .2  BOSQUE ESMERALDA, ATIZAPAN DE ZARAGOZA CP52930 MAIL: esmegas@admongas.com.mx</th>
</tr>';

} else if ($idEstacion == 7) {
echo '<tr class="ultima-fila">
<th class="text-center bg-white" colspan="16">AV PROLONGACION DIVISION DEL NORTE 5322 COL AMPLIACION SAN MARCOS NORTE C. P. 16050 XOCHIMILCO CDMX MAIL. admongasxochimilco5679@hotmail.com telf: 5553349220 RFC: AGX151117TQ8 </th>
</tr>';
}

?>

</tbody>
</table>
</div>

