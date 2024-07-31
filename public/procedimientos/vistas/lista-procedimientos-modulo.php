<?php
require ('../../../app/help.php');

$idModulo = $_GET["idModulo"];

$sql_listProcedimiento = "SELECT * FROM op_procedimientos_modulos WHERE modulo = '" . $idModulo . "' ORDER BY fecha DESC";
$result_listProcedimiento = mysqli_query($con, $sql_listProcedimiento);
$numero_listProcedimiento = mysqli_num_rows($result_listProcedimiento);

?>




    <?php

    if ($numero_listProcedimiento > 0) {
echo '<div class="col-12">
  <div class="row">';
      while ($row_listProcedimiento = mysqli_fetch_array($result_listProcedimiento, MYSQLI_ASSOC)) {
        $GET_idProcedimiento = $row_listProcedimiento['id'];

        $titulo = $row_listProcedimiento['titulo'];
        $archivo = $row_listProcedimiento['archivo'];

        $explode = explode(' ', $row_listProcedimiento['fecha']);
        $fecha_dia = FormatoFecha($explode[0]);

        ?>

        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-1 mb-2"
          onclick="detalleProcedimiento(<?= $GET_idProcedimiento; ?>)">
          <section class="card3 plan2 shadow-lg">
            <div class="inner2">

              <div class="product-image"><img src="<?= RUTA_IMG_ICONOS; ?>procedimiento.png" draggable="false" /></div>

              <div class="product-info">
                <p class="mb-0 pb-0"><?= $fecha_dia; ?></p>
                <h6><?= $titulo; ?></h6>
              </div>

            </div>
          </section>
        </div>


        <?php
      }
echo '
  </div>
</div>';
    } else {

      echo '<header class="bg-light py-5">
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
      </header>';
  

    }

    ?>
