<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idYear = $_GET['idYear'];

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

function Total($idDocumento,$idEstacion,$idYear,$con){

$sql_lista = "SELECT * FROM op_miselanea_documentos_archivo WHERE id_estacion = '".$idEstacion."' AND year = '".$idYear."' AND id_documento = '".$idDocumento."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

return $numero_lista;
}
?>


<div class="border-0 p-3"> 

  <div class="row"> 
  <div class="col-12">
  <h5 class="mb-2"><?=$estacion;?> (Certificación <?=$idYear;?>)</h5>
  <hr>
  </div>
  </div> 


<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0">
<thead class="tables-bg">
  <tr>
  <th class="align-middle text-center">#</th>
  <th class="align-middle">Documento</th>
  <th class="text-center align-middle" width="24">
  <img src="<?=RUTA_IMG_ICONOS?>archivo-tb.png">
  </th>
  </tr>
</thead> 
<body>

<?php
$sql_lista = "SELECT * FROM op_miselanea_documentos WHERE categoria = 2 ORDER BY id_lista ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$Total = Total($id,$idEstacion,$idYear,$con);
if($Total != 0){
$DocT = '<span class="badge rounded-pill bg-primary" style="margin-left: 15px;margin-top: -3px;padding: 4px;font-size: .6em;"><small>'.$Total.'</small></span>';  
}else{
$DocT = '';	
}

echo '<tr>';
echo '<td class="align-middle text-center"><b>'.$row_lista['id_lista'].'</b></td>';
echo '<td class="align-middle p-2">'.$row_lista['documento'].'</td>';
echo '<td class="align-middle text-center p-2">
<img class="pointer" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" onclick="Modal('.$id.','.$idEstacion.','.$idYear.')">
'.$DocT.'</td>';
echo '</tr>';

}
?>

</body>
</table>
</div>

</div>