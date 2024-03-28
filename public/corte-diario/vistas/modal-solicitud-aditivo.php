 <?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_solicitud_aditivo WHERE id = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$ordencompra = $row_lista['orden_compra'];
$para = $row_lista['para'];
$fecha = $row_lista['fecha'];
$idpersonal = $row_lista['id_personal'];
$fechaentrega = $row_lista['fecha_entrega'];
$fechapedido = $row_lista['fecha_pedido'];
$comentarios = $row_lista['comentarios'];
$idestacion = $row_lista['id_estacion'];

}

function Personal($idusuario,$con){
  $sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  $nombre = $row['nombre'];
  }
  return $nombre;
  }
?>
 <div class="modal-header">
 <h5 class="modal-title">Solicitud de aditivo</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>

   <div class="modal-body">

  <div class="row">

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1 mt-1">
    <span class="badge rounded-pill tables-bg float-start" style="font-size:14px">Fecha: <?=FormatoFecha($fecha);?></span>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1 mt-1">
    <span class="badge rounded-pill tables-bg float-end" style="font-size:14px">No. Orden de Compra: <?=$ordencompra;?></span>
  </div>

  </div>

    <hr>

  <div class="row">

  <div class="col-12 mb-3">
  <div class="border p-3">
      <h6>Para:</h6>
      <hr>
      <?=$para;?>
  </div>
  </div>


<div class="col-12 mb-3">
<div class="border p-3">
    <h6>Comentarios o instrucciones especiales:</h6>
    <hr>
    <textarea class="form-control rounded-0 p-1" rows="2" id="comentarios" style="font-size: 1em;" oninput="EditarSolicitud(this,<?=$idReporte;?>,2)"><?=$comentarios;?></textarea>
</div>
</div>

</div>

 
<div class="table-responsive">
<table class="table table-sm table-bordered mb-3" style="font-size: .9em;">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">FECHA DE ENTREGA REQUERIDA</th>
  <th class="text-center align-middle tableStyle font-weight-bold">SOLICITADO POR</th>
  </tr>
</thead> 
<tbody>
  <tr>
    <td class="p-0 m-0 text-center align-middle">
      <input type="date" class="form-control border-0 rounded-0 p-1" style="font-size: 1.1em;" id="FechaEntrega" oninput="EditarSolicitud(this,<?=$idReporte;?>,4)" value="<?=$fechaentrega;?>">
    </td>
    <td class="text-center align-middle">
     <?=Personal($idpersonal,$con);?>
    </td>

  </tr>
  </tbody>
  </table>
</div>




  <div class="row">
    

<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3"> 
      <h6>Cantidad</h6>
      <input type="number" class="form-control rounded-0" id="Cantidad" style="">
    </div>
    

<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-3"> 
      
      <h6>Producto</h6>
      <div class="input-group">
  <select id="Aditivo" class="form-select rounded-0" aria-describedby="button-addon2" style="font-size: .9em;">
    <option></option>
    <option>GASOLINA</option>
    <option>DIESEL</option>
  </select>
  <div class="input-group-append">
    <button class="btn btn-outline-secondary rounded-0" type="button" id="button-addon2" style="font-size: .9em;" onclick="AgregarAditivo(<?=$idReporte;?>)">Agregar</button>
  </div>
</div>

    </div>
  </div>


 <div class="table-responsive">
  <table class="table table-sm table-bordered mb-0" style="font-size: .8em;">
  <thead class="tables-bg">
    <tr>
    <th class="text-center align-middle tableStyle font-weight-bold">CANTIDAD DE TAMBORES</th>
    <th class="text-center align-middle tableStyle font-weight-bold">NOMBRE DEL PRODUCTO</th>
    <th class="text-center align-middle tableStyle font-weight-bold">NOMBRE DEL ADITIVO</th>
    <th class="text-center align-middle tableStyle font-weight-bold">KILOGRAMOS POR TAMBOR</th>
    <th class="text-center align-middle tableStyle font-weight-bold">TOTAL KILOS</th>
    <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
    </tr>
  </thead> 
  <tbody>
  <?php 
  $sql_aditivo = "SELECT * FROM op_solicitud_aditivo_tambo WHERE id_reporte = '".$idReporte."' ";
  $result_aditivo = mysqli_query($con, $sql_aditivo);
  $numero_aditivo = mysqli_num_rows($result_aditivo);
  if ($numero_aditivo > 0) {
  while($row_aditivo = mysqli_fetch_array($result_aditivo, MYSQLI_ASSOC)){
  $id = $row_aditivo['id'];

  $totalkilogramos = $row_aditivo['cantidad'] * $row_aditivo['kilogramo'];
  $totaldolares = $totalkilogramos * $row_aditivo['precio_kilogramo'];

  echo '<tr>
  <td class="text-center align-middle">'.$row_aditivo['cantidad'].'</td>
  <td class="text-center align-middle">'.$row_aditivo['producto'].'</td>
  <td class="text-center align-middle">'.$row_aditivo['aditivo'].'</td>
  <td class="text-center align-middle">'.$row_aditivo['kilogramo'].'</td>
  <td class="text-center align-middle" id="TK'.$id.'">'.$totalkilogramos.'</td>
  <td class="align-middle text-center" width="20"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarTambo('.$idReporte.','.$id.')"></td>
  </tr>';

  $SubtotalDolares = $SubtotalDolares + $totaldolares;
  }
  }else{
  echo "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";  
  }

   ?>
  </tbody> 
  </table>  
</div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-danger" onclick="Eliminar(<?=$idestacion;?>,<?=$idReporte;?>)">Cancelar</button>
<button type="button" class="btn btn-primary" onclick="Finalizar(<?=$idReporte;?>)">Finalizar</button>
</div>