<?php
require('../../../app/help.php');

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

}

?>
<div class="modal-header">
<h5 class="modal-title">Editar terminal punto de venta</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div> 
      
<div class="modal-body">

       <div class="row">
          
          <div class="col-xl-6 xol-lg-6 col-md-6 col-sm-12 mb-2">
          <div class="mb-1 text-secondary">TPV:</div>
          <input type="text" class="form-control rounded-0" value="<?=$tpv;?>" id="Tpv">
          </div>

          <div class="col-xl-6 xol-lg-6 col-md-6 col-sm-12 mb-2">
          <div class="mb-1 text-secondary">No. Serie:</div>
          <input type="text" class="form-control rounded-0" value="<?=$noserie;?>" id="Serie">
          </div>

          <div class="col-xl-6 xol-lg-6 col-md-6 col-sm-12 mb-2">
          <div class="mb-1 text-secondary">Modelo/Marca:</div>
          <input type="text" class="form-control rounded-0" value="<?=$modelo;?>" id="Modelomarca">
          </div>

           <div class="col-xl-6 xol-lg-6 col-md-6 col-sm-12 mb-2">
          <div class="mb-1 text-secondary">No. Lote:</div>
          <input type="text" class="form-control rounded-0" value="<?=$lote;?>" id="NoLote">
          </div>

          <div class="col-xl-6 xol-lg-6 col-md-6 col-sm-12 mb-2">
          <div class="mb-1 text-secondary">Tipo Conexión:</div>
          <input type="text" class="form-control rounded-0" value="<?=$tipoconexion;?>" id="TipoC">
          </div>
          
        <div class="col-xl-6 xol-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary">Numero afiliación:</div>
        <input type="text" class="form-control rounded-0" value="<?=$noafiliacion;?>" id="Afiliado">
        </div>

        <div class="col-xl-6 xol-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary">Telefono atención:</div>
        <input type="text" class="form-control rounded-0" value="<?=$telefono;?>" id="Telefono">
        </div>

        <div class="col-xl-6 xol-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary">Activas:</div>
        <input type="text" class="form-control rounded-0" value="<?=$estado;?>" id="Estado">
        </div>

        <div class="col-xl-6 xol-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary">Rollos:</div>
        <input type="text" class="form-control rounded-0" value="<?=$rollos;?>" id="Rollos">
        </div>

        <div class="col-xl-6 xol-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary">Cargadores:</div>
        <input type="text" class="form-control rounded-0" value="<?=$cargadores;?>" id="Cargadores">
        </div>

        <div class="col-xl-6 xol-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="mb-1 text-secondary">Pedestales en buen estado:</div>
        <input type="text" class="form-control rounded-0" value="<?=$pedestales;?>" id="Pedestales">
        </div>
        </div>
        
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="Editar(<?=$idEditar;?>)">Editar</button>
      </div>