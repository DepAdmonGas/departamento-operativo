<?php 
require('../../../app/help.php');

$sql_lista = "SELECT * FROM op_lista_formatos";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>


<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Recursos Humanos</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Formatos</li>
</ol>
</div>

<div class="row">

<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
<h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Formatos</h3>
</div>

<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
<?php if($session_idpuesto == 13){ ?>
<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Mas()">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
<?php } ?>
</div>

</div>

<hr>      
</div>


<div class="table-responsive">
<table class="custom-table" style="font-size: .9em;" width="100%">
<thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center">#</th>
  <th class="align-middle text-center">Clave del formato</th>
  <th class="align-middle text-center">Nombre del formato</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>word.png" data-toggle="tooltip" data-placement="top" title="Descargar"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  </tr>
</thead> 
<tbody class="bg-white">
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    $id = $row_lista['id'];
    $formato = $row_lista['formato'];
    $nombre = $row_lista['nombre'];
    $archivo = $row_lista['archivo'];

echo '<tr>';
echo '<th class="align-middle text-center">'.$num.'</th>';
echo '<td class="align-middle text-center">'.$formato.'</td>';
echo '<td class="align-middle text-center">'.$nombre.'</td>';
echo '<td class="align-middle text-center"><a href="'.RUTA_ARCHIVOS.'lista-formatos/'.$archivo.'" download><img src="'.RUTA_IMG_ICONOS.'word.png" data-toggle="tooltip" data-placement="top" title="Descargar"></a></td>';
echo '<td class="text-center align-middle"><a onclick="ModalEditar('.$id.')"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png"></a></td>';
echo '</tr>';

$num++;
}
}else{
echo "<tr><td colspan='7'><div class='text-secondary text-center p-2 fs-6 fw-light'>No se encontró información para mostrar </div></td></tr>";	
}
?>
</tbody>
</table>
</div>