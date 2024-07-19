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
 

<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.go(-3)"  class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> <?=$Cate?></a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase"> Contratos (<?=$estacion;?>) </li>
</ol>
</div>
 
<div class="row"> 
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 mb-1"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Contratos (<?=$estacion;?>)</h3> </div>

<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mt-1"> 
<button type="button" class="btn btn-labeled2 btn-primary float-end"  onclick="ModalAgregarContrato(<?=$idEstacion;?>,'<?=$Cate;?>')">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
</div>

</div>

<hr>
</div>



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


<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-1 mb-2" onclick="ModalDetalleContrato(<?=$GET_idContratos;?>)">
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>contrato.png" draggable="false"/></div>
  
<div class="product-info">
<p class="mb-0 pb-0"><?=$fecha_dia;?></p>
<h2><?=$descripcion;?></h2>
</div>

</div>
</section>
</div>



 <?php
 }

  }else{

    echo '
    <div class="col-12">
    <header class="bg-light py-5">
    <div class="container px-5">
    <div class="row gx-5 align-items-center justify-content-center">
  
    <div class="col-xl-5 col-xxl-6 d-xl-block text-center">
    <img class="my-2" style="width: 100%" src="'.RUTA_IMG_ICONOS.'no-busqueda.png" width="50%">
    </div>
   
    <div class="col-lg-8 col-xl-7 col-xxl-6">
    <div class="my-2 text-center"> <h1 class="display-3 fw-bolder text-dark">No se encontró la información</h1> </div>
    </div>
    
    </div>
    </div>
    </header>
    </div>';


 }

 ?>
  
  </div>


