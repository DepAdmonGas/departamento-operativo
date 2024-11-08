<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idEditar = $_GET['idEditar'];

$sql_lista = "SELECT * FROM op_terminales_tpv WHERE id = '".$idEditar."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
 
$tpv = $row_lista['tpv'];
$noserie = $row_lista['no_serie'];
$modelo = $row_lista['modelo'];
$lote = $row_lista['no_lote'];
$tipoconexion = $row_lista['tipo_conexion'];
$noafiliacion = $row_lista['no_afiliacion'];
$telefono = $row_lista['telefono'];
$estado = $row_lista['estado'];
$rollos = $row_lista['rollos'];
$cargadores = $row_lista['cargadores'];
$pedestales = $row_lista['pedestales'];

$estatusTPV = $row_lista['estatus_tpv'];
$impresiones = $row_lista['no_impresiones'];
$tipoTpv = $row_lista['tipo_tpv'];


if($estatusTPV == "Nuevo"){
$ocultar1 = "d-none";

}else if($estatusTPV == "Usado"){
$ocultar2 = "d-none";    

}else if($estatusTPV == "Reparacion"){
$ocultar23= "d-none";    
}


if($tipoTpv == "Tecla"){
 $ocultarT1 = "d-none";   
}else if($tipoTpv == "Touch"){
 $ocultarT2 = "d-none";  
}


}

?>
<div class="modal-header">
<h5 class="modal-title">Editar terminal punto de venta</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
      <div class="modal-body">


       <div class="row">
         
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
          <div class="mb-2 text-secondary fw-bold">TPV:</div>
          <input type="text" class="form-control rounded-0" value="<?=$tpv;?>" id="Tpv">
          </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
          <div class="mb-2 text-secondary fw-bold">NO. SERIE:</div>
          <input type="text" class="form-control rounded-0" value="<?=$noserie;?>" id="Serie">
          </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
          <div class="mb-2 text-secondary fw-bold">MODELO/MARCA:</div>
          <input type="text" class="form-control rounded-0" value="<?=$modelo;?>" id="Modelomarca">
          </div>
     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
          <div class="mb-2 text-secondary fw-bold">NO. LOTE:</div>
          <input type="text" class="form-control rounded-0" value="<?=$lote;?>" id="NoLote">
          </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
          <div class="mb-2 text-secondary fw-bold">TIPO CONEXIÓN:</div>
          <input type="text" class="form-control rounded-0" value="<?=$tipoconexion;?>" id="TipoC">
          </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
        <div class="mb-2 text-secondary fw-bold">NUMERO AFILIACIÓN:</div>
        <input type="text" class="form-control rounded-0" value="<?=$noafiliacion;?>" id="Afiliado">
        </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
        <div class="mb-2 text-secondary fw-bold">TELEFONO ATENCIÓN:</div>
        <input type="text" class="form-control rounded-0" value="<?=$telefono;?>" id="Telefono">
        </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
        <div class="mb-2 text-secondary fw-bold">ACTIVAS:</div>
        <input type="text" class="form-control rounded-0" value="<?=$estado;?>" id="Estado">
        </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
        <div class="mb-2 text-secondary fw-bold">ROLLOS:</div>
        <input type="text" class="form-control rounded-0" value="<?=$rollos;?>" id="Rollos">
        </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
        <div class="mb-2 text-secondary fw-bold">CARGADORES:</div>
        <input type="text" class="form-control rounded-0" value="<?=$cargadores;?>" id="Cargadores">
        </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
        <div class="mb-2 text-secondary fw-bold">PEDESTALES EN BUEN ESTADO:</div>
        <input type="text" class="form-control rounded-0" value="<?=$pedestales;?>" id="Pedestales">
        </div>



     
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary fw-bold">ESTADO TPV'S:</div>    
          <select class="form-select" id="EstadoTPV">
            <option><?=$estatusTPV;?></option>
            <option class="<?=$ocultar1;?>">Nuevo</option>
            <option class="<?=$ocultar2;?>">Usado</option>
            <option class="<?=$ocultar3;?>">Reparacion</option>
          </select>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary fw-bold">NO. DE IMPRESIONES:</div>
        <input type="number" class="form-control rounded-0" id="NoImpresiones" value="<?=$impresiones;?>">
        </div>


        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary fw-bold">TIPO TPV'S:</div>
          <select class="form-select" id="TipoTPV">
            <option><?=$tipoTpv;?></option>
            <option class="<?=$ocultarT1;?>">Tecla</option>
            <option class="<?=$ocultarT2;?>">Touch</option>
          </select>
        </div>   

        </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-labeled2 btn-success" onclick="Editar(<?=$idEstacion;?>, <?=$idEditar;?>)">
      <span class="btn-label2"><i class="fa fa-check"></i></span>Editar</button>

      </div>