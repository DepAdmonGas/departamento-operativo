<?php
require('../../../app/help.php');

$sql_listComunicados = "SELECT * FROM tb_comunicados_do ORDER BY fecha DESC";  
$result_listComunicados = mysqli_query($con, $sql_listComunicados);
$numero_listComunicados = mysqli_num_rows($result_listComunicados);


?>
<div class="row">
 
<?php

if($numero_listComunicados > 0){
  
while($row_listComunicados = mysqli_fetch_array($result_listComunicados, MYSQLI_ASSOC)){
$GET_idComunicado = $row_listComunicados['id_comunicado'];

$titulo = $row_listComunicados['titulo'];
$archivo = $row_listComunicados['archivo'];

$explode = explode(' ', $row_listComunicados['fecha']);
$fecha_dia = FormatoFecha($explode[0]);

?>

<div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mt-1 mb-2">

<?php
$sql_lista = "SELECT * FROM tb_comunicados_grte
WHERE id_comunicado = ".$GET_idComunicado." AND id_gerente = ".$Session_IDUsuarioBD."";

$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {

$bgAlert = "bg-success";
$bgAlertImg = 'cheque.png';
$bgAlertCard = "card-menuB";

}else{

$bgAlert = "bg-danger";
$bgAlertImg = 'cheque_X.png';
$bgAlertCard = "card-menuB-disabled";


}
?>


  <div class="card <?=$bgAlertCard;?> rounded shadow-sm p-3 mb-2 pointer" onclick="gerenteComunicado(<?=$GET_idComunicado;?>,<?=$Session_IDUsuarioBD;?>)">
    
    <div class="row">

  <div class="col-12">
    <span class="badge <?=$bgAlert;?> rounded-circle float-end p-1">    
    <img class="float-start" src="<?=RUTA_IMG_ICONOS;?><?=$bgAlertImg;?>" onclick="Regresar()">
  </span>
  </div>

    <div class="col-12 text-center">
      <h6><?=$titulo;?></h6>
      <img class="img-logo mt-2" src="<?php echo RUTA_IMG_ICONOS?>comunicado.png" style="width: 25%;">
    </div>

  </div>

<p class="card-text text-center mt-3 text-secondary"><small class="text-secondary"><?=$fecha_dia;?></small></p>

  </div>

</div>

 <?php
 }

 }else{
echo '
<div class="col-12 mt-2">
<div class="alert alert-secondary text-center" role="alert">
  No se encontró información para mostrar.
</div>
</div>';
}
 ?>
         



</div>
  

  