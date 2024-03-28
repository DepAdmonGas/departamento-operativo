  <?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$Cate = $_GET['Cate'];

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

$sql_listContratos = "SELECT * FROM op_contratos WHERE id_estacion = '".$idEstacion."' AND categoria = '".$Cate."' ORDER BY fecha DESC";  
$result_listContratos = mysqli_query($con, $sql_listContratos);
$numero_listContratos = mysqli_num_rows($result_listContratos);

?>


 <div class="border-0 p-3"> 

<div class="row">

<div class="col-11 mb-0">
<h5><?=$estacion;?></h5>
</div> 

<div class="col-1 mb-0">
  <img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="float-end pointer ms-2" onclick="ModalAgregarContrato(<?=$idEstacion;?>,'<?=$Cate;?>')">
</div> 

</div> 

<hr> 


<div class="row">

<?php
if ($numero_listContratos > 0) {
while($row_listContratos = mysqli_fetch_array($result_listContratos, MYSQLI_ASSOC)){
$GET_idContratos = $row_listContratos['id_contratos'];

$descripcion = $row_listContratos['descripcion'];
$archivo = $row_listContratos['archivo'];

$explode = explode(' ', $row_listContratos['fecha']);
$fecha_dia = FormatoFecha($explode[0]); 

?>

	<div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mt-2 mb-1">
  	<div class="card card-menuB rounded shadow-sm p-3 mb-2 pointer" onclick="ModalDetalleContrato(<?=$GET_idContratos;?>)">
                
    <div class="col-12 text-center">
      <h6><?=$descripcion;?></h6>
      <img class="img-logo mt-2" src="<?php echo RUTA_IMG_ICONOS?>contrato.png" style="width: 30%;">
    </div>

	<p class="card-text text-center mt-3 text-secondary"><small class="text-secondary"><?=$fecha_dia;?></small></p>

  </div>
  </div>

 <?php
 }

  }else{

  echo '<div class="col-12">
  <div class="alert alert-secondary mb-0 text-center" role="alert">
    No se encontró información para mostrar
  </div>
  </div>'; 

 }

 ?>
  

</div>


</div>