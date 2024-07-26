<?php 
require('../../../app/help.php');
 
$sql_empresa = "SELECT * FROM op_rh_puestos WHERE status = 1 ";
$result_empresa = mysqli_query($con, $sql_empresa);
$numero_empresa = mysqli_num_rows($result_empresa);
?>

<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Configuración</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Puestos</li>
</ol>
</div>

<div class="row">
<div class="col-9">
<h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Puestos</h3>
</div>

<div class="col-3">
<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Nuevo()">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
</div>

</div>

<hr>
</div>

 

<div class="table-responsive">
<table id="tabla_puestos" class="custom-table" style="font-size: 12.5px;" width="100%">
<thead class="tables-bg">
<tr>
<th class="text-center align-middle" width="64px">#</th>
<th class="align-middle">Puesto</th>
<th class="text-center align-middle" width="32px"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png" /></th>
<th class="text-center align-middle" width="32px"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png" /></th>
</thead>
</tr>

<tbody class="bg-white">
<?php
if($numero_empresa > 0){
while($row_empresa = mysqli_fetch_array($result_empresa, MYSQLI_ASSOC)){

$id = $row_empresa['id'];

echo '<tr>';
echo '<th class="text-center align-middle">'.$row_empresa['id'].'</th>';
echo '<td class="align-middle">'.$row_empresa['puesto'].'</td>';
echo '<td class="text-center align-middle"> <img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" class="pointer" 
onclick="editarPuesto('.$id.')"> </td>';
echo '<td class="text-center align-middle"> <img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" class="pointer"
onclick="eliminarPuesto('.$id.')"/> </td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='5' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";	
}
 
?>
</tbody>
</table>
</thead>

