<?php
require ('../../../../help.php');
$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_mediciones WHERE id_estacion = '" . $idEstacion . "' ORDER BY id ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
 
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$ocultarOp = "";
}else{
$ocultarOp = "d-none";
}

?> 



<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Importacion</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Mediciones</li>
</ol>
</div>

<div class="row">
<div class="col-9"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Mediciones</h3></div>
<div class="col-3 <?=$ocultarOp?>"><button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Modal(<?=$idEstacion?>)">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
</div>
</div>
<hr>
</div>

<div class="table-responsive">
<table id="tabla_mediciones" class="custom-table" style="font-size: .8em;" width="100%">

<thead class="tables-bg">
<th class="align-middle text-center">#</th>
<th class="align-middle text-center">FECHA</th>
<th class="align-middle text-center">FACTURA</th>
<th class="align-middle text-center">NETO</th>
<th class="align-middle text-center">BRUTO</th>
<th class="align-middle text-center">CUENTA LITROS</th>
<th class="align-middle text-center">PROVEEDOR</th>

<?php
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
echo '<th class="align-middle text-center" width="20"><img src="'.RUTA_IMG_ICONOS.'eliminar.png"></th>';   
}
?>

</thead>

<tbody class="bg-white">
<?php
 if ($numero_lista > 0) {
$num = 1;
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {

echo '<tr>';
echo '<th class="align-middle text-center">' . $num . '</th>';
echo '<td class="align-middle">' . $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha']) . '</td>';
echo '<td class="align-middle text-center">' . $row_lista['factura'] . '</td>';
echo '<td class="align-middle text-center">' . $row_lista['neto'] . '</td>';
echo '<td class="align-middle text-center">' . $row_lista['bruto'] . '</td>';
echo '<td class="align-middle text-center">' . $row_lista['cuenta_litros'] . '</td>';
echo '<td class="align-middle text-center">' . $row_lista['proveedor'] . '</td>';
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
echo '<td class="text-center align-middle" width="20"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="Eliminar('.$row_lista['id'].','.$idEstacion.')"></td>';
}
echo '</tr>';
$num++;
}
} 
?>

</tbody>
</table>

</div>