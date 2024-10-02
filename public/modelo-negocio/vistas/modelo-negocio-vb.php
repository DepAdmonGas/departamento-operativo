<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

function ValidaUsuario($idReporte, $idUsuario, $con)
{
  $sql = "SELECT * FROM op_modelo_negocio_firma WHERE id_modelo_negocio = '" . $idReporte . "' AND id_usuario= '" . $idUsuario . "' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  return $numero;
}

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

$ValidaUsuario = ValidaUsuario($idReporte, $Session_IDUsuarioBD, $con);
?>

<?php
$sql = "SELECT * FROM op_modelo_negocio_firma WHERE id_modelo_negocio = '" . $idReporte . "' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
  echo '<span class="badge bg-success p-2 mr-3 mb-2" style="font-size: .9em;">' . Responsable($row['id_usuario'], $con) . '</span>';
}

if ($ValidaUsuario == 0) { ?>

  <div class="col-12">
    <div class="table-responsive">
      <table class="custom-table" width="100%">
        <thead class="tables-bg">
          <tr>
            <th class="align-middle text-center">FIRMA</th>
          </tr>
        </thead>
        <tbody class="bg-light">

          <tr>
            <th class="align-middle text-center no-hover2">
              <h4 class="text-primary text-center">Token Móvil</h4>
              <small class="text-secondary" style="font-size: .75em;">Agregue el token enviado a su
                número de teléfono o de clic en el siguiente botón para crear uno:</small>
              <br>
              <button id="btn-sms" type="button" class="btn btn-labeled2 btn-success text-white mt-2"
                onclick="CrearToken(<?= $idReporte; ?>,1)" style="font-size: .85em;">
                <span class="btn-label2"><i class="fa-solid fa-comment-sms"></i></span>Crear nuevo token
                SMS</button>

              <button id="btn-whatsapp" type="button" class="btn btn-labeled2 btn-success text-white mt-2"
                onclick="CrearToken(<?= $idReporte; ?>,2)" style="font-size: .85em;">
                <span class="btn-label2"><i class="fa-brands fa-whatsapp"></i></span>Crear nuevo token
                Whatsapp</button>

                <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" 
                onclick="CrearTokenEmail(<?=$idReporte;?>)" style="font-size: .85em;">
              <span class="btn-label2"><i class="fa-regular fa-envelope"></i></span> Crear nuevo token vía e-mail</button>
              
            </th>
          </tr>
          <tr>
            <th class="align-middle text-center no-hover2">
              <small class="text-danger" style="font-size: .75em;">Nota: En caso de no recibir el token de
                WhatsApp, agrega el número <b>+1 555-617-9367</b><br>
                a tus contactos y envía un mensaje por WhatsApp a ese número con la palabra "OK".
              </small>
            </th>
          </tr>
          <tr>
            <th class="align-middle text-center p-0 no-hover2">
              <div class="input-group">
                <input type="text" class="form-control border-0" placeholder="Token de seguridad"
                  aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
                <div class="input-group-append">
                  <button class="btn btn-outline-success border-0" type="button"
                    onclick="Firmar(<?= $idReporte; ?>)">Firmar solicitud</button>
                </div>
              </div>
            </th>

            
          </tr>
        </tbody>
      </table>

    </div>
  </div>


<?php } ?>