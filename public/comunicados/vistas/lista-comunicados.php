<?php
require '../../../app/help.php';

$sql_listComunicados = "SELECT * FROM tb_comunicados_do ORDER BY fecha DESC";
$result_listComunicados = mysqli_query($con, $sql_listComunicados);
$numero_listComunicados = mysqli_num_rows($result_listComunicados);


?>
<div class="col-12">


  <div class="row">

    <?php

    if ($numero_listComunicados > 0) {

      while ($row_listComunicados = mysqli_fetch_array($result_listComunicados, MYSQLI_ASSOC)) {
        $GET_idComunicado = $row_listComunicados['id_comunicado'];

        $titulo = $row_listComunicados['titulo'];
        $archivo = $row_listComunicados['archivo'];

        $explode = explode(' ', $row_listComunicados['fecha']);
        $fecha_dia = FormatoFecha($explode[0]);

        ?>



        <?php
        $sql_lista = "SELECT * FROM tb_comunicados_grte WHERE id_comunicado = " . $GET_idComunicado . " AND id_gerente = " . $Session_IDUsuarioBD . "";

        $result_lista = mysqli_query($con, $sql_lista);
        $numero_lista = mysqli_num_rows($result_lista);

        if ($numero_lista > 0) {

          $bgAlert = "green";
          $bgAlertImg = '<i class="fa-solid fa-circle-check"></i>';
          $bgAlertCard = "card-menuB";

        } else {

          $bgAlert = "red";
          $bgAlertImg = '<i class="fa-solid fa-xmark"></i>';
          $bgAlertCard = "card-menuB-disabled";


        }
        ?>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-1 mb-2"
          onclick="gerenteComunicado(<?= $GET_idComunicado; ?>,<?= $Session_IDUsuarioBD; ?>)">
          <section class="card3 plan2 shadow-lg">
            <div class="inner2">
              
              <div class="product-image"><img src="<?= RUTA_IMG_ICONOS; ?>comunicado.png" draggable="false" /></div>

              <div class="product-info">
                <p class="mb-0 pb-0"><?= $fecha_dia; ?></p>
                <h6><?= $titulo; ?></h6>
              </div>
              <div class="badge" style="position: absolute; top: 10px; right: 10px; background-color: <?=$bgAlert?>; color: white; padding: 5px 10px; border-radius: 50%;"><?=$bgAlertImg?></div>
            </div>
          </section>
        </div>
        <?php
      }

    } else {
      echo '<header class="bg-light py-5">
      <div class="container px-5">
      <div class="row gx-5 align-items-center justify-content-center">
    
      <div class="col-xl-5 col-xxl-6 d-xl-block text-center">
      <img class="my-2" style="width: 100%" src="' . RUTA_IMG_ICONOS . 'no-busqueda.png" width="50%">
      </div>
     
      <div class="col-lg-8 col-xl-7 col-xxl-6">
      <div class="my-2 text-center"> <h1 class="display-3 fw-bolder text-dark">No se encontró la información</h1> </div>
      </div>
      
      </div>
      </div>
      </header>';
    }
    ?>
  </div>
</div>