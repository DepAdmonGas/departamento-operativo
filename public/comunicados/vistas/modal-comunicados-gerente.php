<?php
require('../../../app/help.php');
$idComunicado = $_GET['idComunicado'];
$idGerente = $_GET['idGerente'];

$sql_listComunicados = "SELECT titulo, fecha, archivo FROM tb_comunicados_do WHERE id_comunicado = ".$idComunicado." "; 

$result_listComunicados = mysqli_query($con, $sql_listComunicados);
$numero_listComunicados = mysqli_num_rows($result_listComunicados);

while($row_listComunicados = mysqli_fetch_array($result_listComunicados, MYSQLI_ASSOC)){


$titulo = $row_listComunicados['titulo'];
$archivo = $row_listComunicados['archivo'];

$explode = explode(' ', $row_listComunicados['fecha']);
$fecha_dia = FormatoFecha($explode[0]);
}

?>


<div class="modal-header">
<h5 class="modal-title">Detalle comunicado</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
 
 
<div class="modal-body">
	
<div class="row">

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2" style="font-size:0.9em"> 
<div class="font-weight-bold">Titulo:</div>
<?=$titulo;?>
</div>  


<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2" style="font-size:0.9em"> 
<div class="font-weight-bold">Fecha:</div>
<?=$fecha_dia;?>
</div> 
 

<div class="col-12 mb-2"> 
<iframe class="border-0 mt-2 mb-3" src="<?php echo RUTA_ARCHIVOS?>/comunicados/<?=$archivo;?>" width="100%" height="600px">
</iframe>

</div> 
</div>

</div>
    




<?php
$sql_lista = "SELECT * FROM tb_comunicados_grte
WHERE id_comunicado = ".$idComunicado." AND id_gerente = ".$idGerente."";

$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {

}else{

echo '<div class="modal-footer">';
echo '<button type="button" class="btn btn-labeled2 btn-primary float-end m-2"
    onclick="deacuerdoComunicado('.$idComunicado.','.$idGerente.')">
    <span class="btn-label2"><i class="fa fa-check"></i></span>De Acuerdo</button>';
echo '</div>';

}
?>



