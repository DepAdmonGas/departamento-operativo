<?php
require('../../../app/help.php');

$sql_menu = "SELECT tb_menu_puestos_do.id_menu_do, 
tb_menu_do.elemento_menu_do, 
tb_menu_do.ruta_menu_do, 
tb_menu_do.icono, 
tb_menu_puestos_do.id_puesto 
FROM tb_menu_puestos_do 
INNER JOIN tb_menu_do ON tb_menu_puestos_do.id_menu_do = tb_menu_do.id_menu_do 
INNER JOIN tb_puestos on tb_menu_puestos_do.id_puesto = tb_puestos.id 
WHERE tb_menu_puestos_do.id_puesto = '".$_SESSION["id_puesto_usuario"]."' ORDER BY tb_menu_puestos_do.id_menu_do ASC"; 

$result_menu = mysqli_query($con, $sql_menu );
$numero_menu  = mysqli_num_rows($result_menu);

?>  

<div class="row">

<?php
$num = 1;
while($row_menu = mysqli_fetch_array($result_menu, MYSQLI_ASSOC)){
$elemento_menu_do = $row_menu['elemento_menu_do'];
$ruta_menu_do = $row_menu['ruta_menu_do'];
$icono = $row_menu['icono'];
?>
 
<div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
<div class="card card-menuB rounded shadow-sm p-3 pointer" onclick="rutaMenuDO('<?=$ruta_menu_do;?>')">
                  
<div class="d-flex justify-content-between">
<div class="d-flex flex-row align-items-center">
<div class="icon"> 
<i class="fa-solid fa-<?=$num?> color-CB"></i>
</div>
  <div class="m-details ms-2"> 
<h7><?=$elemento_menu_do;?></h7> 
</div>

</div>
</div>

</div>
</div>


<?php
$num++;
}
?>
 
 
  <?php if($session_nompuesto == "Sistemas" || $session_nompuesto == "Gestoria" || $session_nompuesto == "Mantenimiento" || $session_nompuesto == "Departamento Jurídico"){ ?>

  <!----- RECIBOS DE NOMINA----->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm p-3 pointer" onclick="ReciboNominaV2()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-file-invoice color-CB"></i>

  </div>

  <div class="m-details ms-2" style="padding-top: 10px">  
  <h6>Recibos de nomina</h6> 
  </div>
  </div>

  </div>
  </div>

  <?php } ?>

  <?php if($session_nompuesto == "Mantenimiento"){ ?>
 
  <!----- ALMACEN ----->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm p-3 pointer" onclick="Almacen()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-store color-CB"></i>
  </div>

  <div class="m-details ms-2" style="padding-top: 10px">  
  <h6>Almacen</h6> 
  </div>
  </div>

  </div>
  </div>

  <?php } ?>

  <?php if($session_nompuesto == "Gestoria"){ ?>

  <!----- SOLICITUD DE CHEQUE ----->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm p-3 pointer" onclick="SolicitudCheque()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon">
  <i class="fa-solid fa-money-check-dollar color-CB"></i> 
  </div>

  <div class="m-details ms-2" style="padding-top: 10px">  
  <h6>Solicitud de cheques</h6> 
  </div>
  </div>

  </div>
  </div>

  <!----- EMBARQUES ----->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm p-3 pointer" onclick="Embarques()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-truck-ramp-box color-CB"></i>
  </div>

  <div class="m-details ms-2" style="padding-top: 10px">  
  <h6>Embarques</h6> 
  </div>
  </div>

  </div>
  </div>

  <!----- PAPELERIA ----->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm p-3 pointer" onclick="Papeleria()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-folder-plus color-CB"></i>
  </div>

  <div class="m-details ms-2" style="padding-top: 10px">  
  <h6>Pedido de papeleria</h6> 
  </div>
  </div>

  </div>
  </div>
  <?php } ?>



  <?php if($session_nompuesto == "Gestoria"){ ?>

  <!----- SOLICITUD DE VALES ----->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm p-3 pointer" onclick="SolicitudVales()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon">
  <i class="fa-solid fa-money-check color-CB"></i>
  </div>

  <div class="m-details ms-2" style="padding-top: 10px">  
  <h6>Solicitud de vales</h6> 
  </div>
  </div>

  </div>
  </div>

  <?php } ?>
 
  <?php if($Session_IDUsuarioBD == 346){ ?>

<div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
<div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="AcuseRecepcionAuditor()">                    
<div class="d-flex flex-row align-items-center">
<div class="icon"> 
<i class="fa-solid fa-file color-CB"></i>
</div> 
<div class="m-details ms-2" style="padding-top: 10px"> 
<h5>Acuses de Recepcion</h5> 
</div>
</div>
</div>
</div>


<div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
<div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="DescargaTuxpanAuditor()">                    
<div class="d-flex flex-row align-items-center">
<div class="icon"> 
<i class="fa-solid fa-truck-ramp-box color-CB"></i>
</div> 
<div class="m-details ms-2" style="padding-top: 10px"> 
<h5>Formato de descarga de merma</h5> 
</div>
</div>
</div>
</div>

<?php } ?>

 
</div>