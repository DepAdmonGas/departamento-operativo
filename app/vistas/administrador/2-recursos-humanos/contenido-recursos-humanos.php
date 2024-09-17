<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"> 
<div class="row">

<!---------- DIRECCION DE OPERACIONES ---------->
<div class="col-12 mb-3"> 
<div class="row">
    
<!----- 1. Organigrama ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="Organigrama()">    
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>organigrama.png" draggable="false"/></div>
  
<div class="product-info">
<p class="mb-0 pb-0">Dirección de Operaciones</p>
<h2>Organigrama</h2>
</div>

</div>
</section>
</div>
 
<!----- 2. Control de documentos del personal ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="Personal()">    
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>personal.png" draggable="false"/></div>
  
<div class="product-info">
<p class="mb-0 pb-0">Dirección de Operaciones</p>
<h2>Control de Documentos del Personal</h2>
</div>

</div>
</section>
</div>

<!----- 3. Formatos (V3)----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="Formatos()">    
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>formatos.png" draggable="false"/></div>
  
<div class="product-info">
<p class="mb-0 pb-0">Dirección de Operaciones</p>
<h2>Formatos</h2>
</div>

</div>
</section>
</div>


<!----- 3. Formatos (V2)
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="ListaFormatos()">    
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>formatos.png" draggable="false"/></div>
  
<div class="product-info">
<p class="mb-0 pb-0">Dirección de Operaciones</p>
<h2>Lista Formatos</h2>

</div>

</div>
</section>
</div>

<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">

<div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="Formatos()">  
<?php
$ToSolicitud = ToSolicitud($con);
?>

<div class="row mx-1">
<div class="col-12 mt-3">
<span class="badge rounded-pill tables-bg float-end"> <?=$ToSolicitud?></span>
</div>
</div>

<div class="col-12 text-center text-secondary mb-3">
<h5>Formatos</h5>
<img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>formatos.png">
</div>
</div>
</div> 
-->

</div>
</div>


<!---------- ESTACIONES ---------->
<div class="col-12 mb-3"> 
<div class="row">

<!----- 1. Horario personal ----->
<?php if($Session_IDUsuarioBD != 354){ ?>

<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="HorarioPersonal()">    
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>calendario.png" draggable="false"/></div>
  
<div class="product-info">
<p class="mb-0 pb-0">Estación</p>
<h2>Horario del personal </h2>
</div>

</div>
</section>
</div>


<!----- 2. Biometricos (Asistencia) ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="Asistencia()">    
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>asistencia.png" draggable="false"/></div>
  
<div class="product-info">
<p class="mb-0 pb-0">Estación</p>
<h2>Biometricos </h2>
</div>

</div>
</section>
</div>

<?php } ?>

<!----- 3. Recibos de nomina ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="NominaV2()">    
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>nomina.png" draggable="false"/></div>
  
<div class="product-info">
<p class="mb-0 pb-0">Estación</p>
<h2>Recibos de nomina</h2>
</div>

</div>
</section>
</div>

<?php 
if($Session_IDUsuarioBD == 354){
?> 

<!----- 4. Rol de Comodines  ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="RolComodines()">    
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>calendario.png" draggable="false"/></div>
  
<div class="product-info">
<p class="mb-0 pb-0">Estación</p>
<h2>Rol de Comodines</h2>
</div>

</div>
</section>
</div>

<?php
}

if($Session_IDUsuarioBD != 354){ ?>

<!----- 5. Permisos ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="Permisos()">
<section class="card3 plan2 shadow-lg">
<div class="inner2">
<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>permisos.png" draggable="false"/></div>
<div class="product-info">
<p class="mb-0 pb-0">Estación</p>
<h2>Permisos</h2>
</div>
<!-- Badge aquí con estilos en línea -->
<div class="badge" style="position: absolute; top: 10px; right: 10px; background-color: red; color: white; padding: 5px 10px; border-radius: 50%;"><?=ToSolicitudPermisos($con)?></div>
</div>
</section>
</div>

<?php 
}

if($session_nompuesto == "Dirección de operaciones " || $Session_IDUsuarioBD != 354){
?>

<!----- 6. Incidencias de nomina ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="IncidenciasNomina()">    
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>incidente-nomina.png" draggable="false"/></div>
  
<div class="product-info">
<p class="mb-0 pb-0">Estación</p>
<h2>Incidencias de nomina</h2>
</div>

</div>
</section>
</div>

<?php } ?>

<!----- 7. Baja de Personal ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="BajaPersonal()">
<section class="card3 plan2 shadow-lg">
<div class="inner2">
<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>baja-personal.png" draggable="false"/></div>
<div class="product-info">
<p class="mb-0 pb-0">Estación</p>
<h2>Baja personal</h2>
</div>
<!-- Badge aquí con estilos en línea -->
<div class="badge" style="position: absolute; top: 10px; right: 10px; background-color: red; color: white; padding: 5px 10px; border-radius: 50%;"><?=ToSolicitudBaja($con)?></div>
</div>
</section>
</div>

<!----- 8. Lista Negra ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="ListaNegra()">
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>lista-negra.png" draggable="false"/></div>
  
<div class="product-info">
<p class="mb-0 pb-0">Estación</p>
<h2>Lista negra</h2>
</div>

</div>
</section>
</div>

<!----- 9. Vacaciones ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="Vacaciones()">
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>vacaciones.png" draggable="false"/></div>
  
<div class="product-info">
<p class="mb-0 pb-0">Estación</p>
<h2>Vacaciones</h2>
</div>

</div>
</section>
</div>

  <!-- Apartados externos
  <?php if($Session_IDUsuarioBD != 354){ ?>
  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="Configuracion()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Configuración</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>configuracion.png">
  </div>
  </div>
  </div>    
  <?php } ?>



  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="Vacaciones()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Incidencias</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>vacaciones.png">
  </div>
  </div>
  </div> 


    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="ManualesProcedimientos()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Manuales de procedimientos</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>formatos.png">
  </div>
  </div>
  </div> 
  -->

</div>
</div>



</div>
</div>