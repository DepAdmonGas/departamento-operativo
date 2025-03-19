<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];
$mes = $_GET['mes'];
$SemQui = $_GET['SemQui'];
$descripcion = $_GET['descripcion'];
$last = $_GET['last'];

$sql_comen = "SELECT * FROM op_recibo_nomina_v2 ORDER BY id DESC ";
$result_comen = mysqli_query($con, $sql_comen);
$numero_comen = mysqli_num_rows($result_comen);

?>


<div class="modal-header">
<h5 class="modal-title">Agregar Personal</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<div class="border-bottom" style="height: 300px;overflow: auto;">


<?php
if ($numero_comen > 0) {
while($row_comen = mysqli_fetch_array($result_comen, MYSQLI_ASSOC)){
$idUsuario = $row_comen['id_usuario'];
    
$datosUsuario = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($idUsuario);
$NomUsuario = $datosUsuario['nombre'];
    
$FechaFormato = $ClassHerramientasDptoOperativo->FormatoFecha($fechaExplode[0]);
$HoraFormato = date("g:i a",strtotime($fechaExplode[1]));
?>

<div class="mt-1" style="<?=$margin;?>">
<div style="font-size: .7em;" class="mb-1"><?=$NomUsuario;?></div>
<div class="title-table-bg text-white" style="border-radius: 30px;">
<p class="p-2 pb-0"><?=$comentario;?></p>
</div>
<div class="text-end" style="font-size: .7em;margin-top: -10px"><?=$FechaFormato;?>, <?=$HoraFormato;?></div>
    
</div>
<?php
}

}else{
echo "<div class='text-center' style='margin-top: 150px;'><small>No se encontraron comentarios</small></div>";
}

?>

</div>


</div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="GuardarComentario(<?=$idReporte?>,<?=$idEstacion?>,<?=$year?>,<?=$mes?>,<?=$SemQui?>,'<?=$descripcion?>',<?=$last?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Agregar</button>

</div>