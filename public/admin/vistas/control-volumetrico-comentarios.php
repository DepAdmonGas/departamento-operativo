<?php
require ('../../../app/help.php');

$IdReporte = $_GET['IdReporte'];
$idEstacion = $_GET['idEstacion'];

function Responsable($id, $con)
{

    $sql_resp = "SELECT * FROM tb_usuarios WHERE id = '" . $id . "'  ";
    $result_resp = mysqli_query($con, $sql_resp);
    $numero_resp = mysqli_num_rows($result_resp);
    while ($row_resp = mysqli_fetch_array($result_resp, MYSQLI_ASSOC)) {
        $Usuario = $row_resp['nombre'];

    }
    return $Usuario;

}

$sql_comen = "SELECT * FROM op_control_volumetrico_comentario WHERE id_mes = '" . $IdReporte . "' ORDER BY id DESC ";
$result_comen = mysqli_query($con, $sql_comen);
$numero_comen = mysqli_num_rows($result_comen);

?>

<div class="table-responsive mt-3">
    <table class="custom-table " style="font-size: .8em;" width="100%">
        <thead class="navbar-bg">
            <tr>
                <th class="align-middle text-center">Comentarios</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php
            if ($numero_comen > 0):
                while ($row_comen = mysqli_fetch_array($result_comen, MYSQLI_ASSOC)) {
                    $idUsuario = $row_comen['id_usuario'];
                    $comentario = $row_comen['comentario'];

                    $NomUsuario = Responsable($idUsuario, $con);

                    if ($Session_IDUsuarioBD == $idUsuario) {
                        $margin = "margin-left: 30px;margin-right: 5px;";
                    } else {
                        $margin = "margin-right: 30px;margin-left: 5px;";
                    }

                    $fechaExplode = explode(" ", $row_comen['fecha_hora']);
                    $FechaFormato = FormatoFecha($fechaExplode[0]);
                    $HoraFormato = date("g:i a", strtotime($fechaExplode[1]));
                    ?>

                    <tr>
                        <th class="text-end">
                        
                            <span class="text-success"><?=$NomUsuario?>:  <?=$FechaFormato?> <?=$HoraFormato?></span>
                            <br>
                            <span class="text-primary"><?=$comentario?></span>
                        
                        </th>
                        
                    </tr>

                    <?php
                }
            else:
                echo "<tr><th class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
            endif;
            ?>
            <tr>
                

                
                <th class="text-start no-hover">Comentario:
                
                    <textarea class="form-control rounded-0 mt-2" id="Comentario"></textarea>
                    <br>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success"
                            onclick="GuardarComentario(<?= $IdReporte; ?>,<?= $idEstacion; ?>)">
                            Guardar
                        </button>
                    </div>    
                </th>
                
            </tr>
        </tbody>
    </table>
</div>
