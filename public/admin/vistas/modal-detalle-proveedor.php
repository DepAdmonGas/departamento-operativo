 <?php
require('../../../app/help.php');

$idProveedor = $_GET['idProveedor'];

$sql_lista = "SELECT * FROM op_almacen_proveedores WHERE id = '".$idProveedor."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$folio = $row_lista['folio'];
$fecha = FormatoFecha($row_lista['fecha']);
$razon_social = $row_lista['razon_social'];
$actividad_economica = $row_lista['actividad_economica'];
$email = $row_lista['email'];
$rfc = $row_lista['rfc'];
$ciudad = $row_lista['ciudad'];

$telefono_1 = $row_lista['telefono_1'];
$telefono_2 = $row_lista['telefono_2'];
$direccion = $row_lista['direccion'];
$beneficiario = $row_lista['beneficiario'];
$banco = $row_lista['banco'];

$metodo_pago = $row_lista['metodo_pago'];
$cfdi = $row_lista['cfdi'];
$moneda = $row_lista['moneda'];
$forma_pago = $row_lista['forma_pago'];
$descripcion = $row_lista['descripcion'];

}

?> 

 
<div class="modal-header">
<h5 class="modal-title">Detalle del Proveedor</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">
<div class="col-12 mb-2" > 
<span class="badge bg-primary" style="font-size:0.9em">Información General:</span>
</div>

<div class="row">

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="border p-2">
<div class="font-weight-bold"><b>Folio:</b></div>
00<?=$folio;?>
</div>  
</div> 

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
<div class="border p-2"> 
<div class="font-weight-bold"><b>Fecha:</b></div>
<?=$fecha;?>
</div>
</div>

<div class="col-12 mb-2"> 
<div class="border p-2">
<div class="font-weight-bold"><b>Razon Social:</b></div>
<?=$razon_social;?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="border p-2">
<div class="font-weight-bold"><b>Actividad Economica:</b></div>
<?=$actividad_economica;?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="border p-2">
<div class="font-weight-bold"><b>E-mail:</b></div>
<?=$email;?>
</div>
</div>

<div class="col-12 mb-2"> 
<div class="border p-2">
<div class="font-weight-bold"><b>Razon Social:</b></div>
<?=$rfc;?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="border p-2">
<div class="font-weight-bold"><b>Ciudad:</b></div>
<?=$ciudad;?>
</div>
</div>

<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-2">
<div class="border p-2">
<div class="font-weight-bold"><b>Telefono 1:</b></div>
<?=$telefono_1;?>
</div>
</div>

<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-2">
<div class="border p-2"> 
<div class="font-weight-bold"><b>Telefono 2:</b></div>
<?=$telefono_2;?>
</div>
</div>

<div class="col-12 mb-2"> 
<div class="border p-2"> 
<div class="font-weight-bold"><b>Nombre del Beneficiario:</b></div>
<?=$beneficiario;?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
<div class="border p-2">  
<div class="font-weight-bold"><b>Banco:</b></div>
<?=$banco;?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="border p-2">  
<div class="font-weight-bold"><b>Metodo de Pago:</b></div>
<?=$metodo_pago;?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="border p-2">  
<div class="font-weight-bold"><b>Uso del CDFI:</b></div>
<?=$cfdi;?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2"> 
<div class="border p-2">  
<div class="font-weight-bold"><b>Moneda:</b></div>
<?=$moneda;?>
</div>
</div>

<div class="col-12 mb-2"> 
<div class="border p-2"> 
<div class="font-weight-bold"><b>Forma de Pago:</b></div>
<?=$forma_pago;?>
</div>
</div>

<div class="col-12 mt-3 mb-2" > 
<span class="badge bg-primary" style="font-size:0.9em">Productos o Servicios Ofrecidos:</span>
</div>

<div class="col-12 mb-2"> 
<div class="border p-2">
<div class="font-weight-bold"><b>Descripción:</b></div>
<?=$descripcion;?>
</div>  
</div> 

<div class="col-12 mt-3 mb-2" > 
<span class="badge bg-primary" style="font-size:0.9em">Documentación:</span>
</div>

<div class="col-12 mb-2"> 
<div class="border p-3">
<div class="row">

<?php
$sql_listArchivo = "SELECT nombre, fecha, archivo FROM op_almacen_proveedores_documentos WHERE id_proveedor = ".$idProveedor." "; 

$result_listArchivo = mysqli_query($con, $sql_listArchivo);
$numero_listArchivo = mysqli_num_rows($result_listArchivo);

while($row_listArchivo = mysqli_fetch_array($result_listArchivo, MYSQLI_ASSOC)){

$nombre = $row_listArchivo['nombre'];
$fechaArchivo = $row_listArchivo['fecha'];
$archivo = $row_listArchivo['archivo'];

echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-2 mb-1 text-center">
<a href="'.RUTA_ARCHIVOS.'/proveedores/'.$archivo.'" download>
<span class="badge rounded-pill tables-bg" style="font-size:14px">'.$nombre.' <i class="fa-solid fa-circle-down ms-1"></i></span>
</a>
</div>';

}

?>

</div>
</div>
</div>



</div>
</div>


</div>