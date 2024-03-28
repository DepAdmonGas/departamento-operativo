<?php
require('../../../app/help.php');

$idFalla = $_GET['idFalla'];
$idEstacion = $_GET['idEstacion'];
$idTPV = $_GET['idTPV'];

$sql_lista = "SELECT tpv, no_serie FROM op_terminales_tpv WHERE id = '".$idTPV."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$tpv = $row_lista['tpv'];
$noserie = $row_lista['no_serie'];
}

$sql = "SELECT * FROM op_terminales_tpv_reporte WHERE id = '".$idFalla."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

$explode = explode(" ", $row['fechacreacion']);
$Fecha = FormatoFecha($explode[0]);
$falla = $row['falla'];
$atiende = $row['atiende'];

$noreporte = $row['no_reporte'];
$diareporte = $row['dia_reporte'];
$diasolucion = $row['dia_solucion'];
$costo = $row['costo'];
$serie = $row['serie'];
$modelo = $row['modelo'];
$conexion = $row['conexion'];
$observaciones = $row['observaciones'];
$status = $row['status'];
$factura = $row['factura'];
}
?>


<div class="modal-header">
<h5 class="modal-title">Falla TPV: <?=$tpv;?>, No DE SERIE: <?=$noserie;?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">


<div class="mb-1 text-secondary">Falla:</div>
<textarea class="form-control rounded-0" id="Falla"><?=$falla;?></textarea>

<div class="row">


    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
          <div class="mb-1 text-secondary">Atiende:</div>
          <input type="text" class="form-control rounded-0" id="Atiende" value="<?=$atiende;?>">  
          </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
          <div class="mb-1 text-secondary">No. Reporte:</div>
          <input type="text" class="form-control rounded-0" id="NoReporte" value="<?=$noreporte;?>">
          </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
          <div class="mb-1 text-secondary">Día reporte:</div>
          <input type="date" class="form-control rounded-0" id="DiaReporte" value="<?=$diareporte;?>">
          </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
          <div class="mb-1 text-secondary">Día solución:</div>
          <input type="date" class="form-control rounded-0" id="DiaSolucion" value="<?=$diasolucion;?>">
          </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
          <div class="mb-1 text-secondary">Costo:</div>
          <input type="number" step="any" class="form-control rounded-0" id="Costo" value="<?=$costo;?>">
          </div>

              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
          <div class="mb-1 text-secondary">Factura:</div>
          <?php 
          if($status == 1){
          if($factura == ""){
          echo "S/I";
          }else{
          echo '<a href="../archivos/'.$factura.'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a>';
          }
          }else{
          echo '<input class="form-control" type="file" id="Factura">';
          }
          ?>
          
          </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
        <div class="mb-1 text-secondary">Serie que se queda:</div>
        <input type="text" class="form-control rounded-0" id="NuevaSerie" value="<?=$serie;?>">
        </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
        <div class="mb-1 text-secondary">Modelo TPV:</div>
        <input type="text" class="form-control rounded-0" id="ModeloTPV" value="<?=$modelo;?>">
        </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
        <div class="mb-1 text-secondary">Conexión:</div>
        <input type="text" class="form-control rounded-0" id="Conexion" value="<?=$conexion;?>">
        </div>

        </div>
        <div class="mb-1 text-secondary">Observaciones:</div>
        <textarea class="form-control rounded-0" id="Observaciones"><?=$observaciones;?></textarea>


      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-danger" onclick="ModalFalla(<?=$idEstacion;?>,<?=$idTPV;?>)">Cancelar</button>
      	<?php if($status == 0){ ?>
        <button type="button" class="btn btn-primary" onclick="FinalizarFalla(<?=$idFalla;?>,<?=$idTPV;?>,<?=$idEstacion;?>)">Finalizar</button>
    	<?php } ?>
      </div>



