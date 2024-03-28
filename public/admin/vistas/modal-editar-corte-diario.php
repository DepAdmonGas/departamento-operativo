<?php
require('../../../app/help.php');

$year = $_GET['year'];
$mes = $_GET['mes'];
$idDias = $_GET['idDias'];
$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_corte_dia_hist WHERE id_corte = '".$idDias."' ORDER BY id ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function Responsable($id, $con){

$sql_resp = "SELECT * FROM tb_usuarios WHERE id = '".$id."'  ";
         $result_resp = mysqli_query($con, $sql_resp);
         $numero_resp = mysqli_num_rows($result_resp);
         while($row_resp = mysqli_fetch_array($result_resp, MYSQLI_ASSOC)){
          $Usuario = $row_resp['nombre'];
          
         }
         return $Usuario;

}
?>

<div class="modal-header">
<h5 class="modal-title">Activar corte</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<?php if ($session_nompuesto != "Contabilidad") { ?> 
<div class="row">
<div class="col-12">
<img class="pointer float-end" onclick="NuevoReg(<?=$idEstacion;?>,<?=$year;?>,<?=$mes;?>,<?=$idDias;?>)" src="<?=RUTA_IMG_ICONOS;?>agregar.png">
<br><hr>
</div>
</div>
<?php } ?>
 
 <div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .8em;">
<thead class="tables-bg">
  <th class="text-center align-middle font-weight-bold">#</th>
  <th class="text-center align-middle font-weight-bold">Fecha</th>
  <th class="text-center align-middle font-weight-bold">Usuario</th>
  <th class="text-center align-middle font-weight-bold">Motivo</th>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$NomUsuario = Responsable($row_lista['id_usuario'], $con);

$fechaExplode = explode(" ", $row_lista['fecha']);
$FechaFormato = FormatoFecha($fechaExplode[0]);
$HoraFormato = date("g:i a",strtotime($fechaExplode[1]));

echo '<tr>';
echo '<td class="align-middle text-center">'.$num.'</td>';
echo '<td class="align-middle text-center"><b>'.$FechaFormato.', '.$HoraFormato.'</b></td>';
echo '<td class="align-middle text-center">'.$NomUsuario.'</td>';
echo '<td class="align-middle text-center">'.$row_lista['detalle'].'</td>';
echo '</tr>';

$num++;
}
}else{
echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

</div>



