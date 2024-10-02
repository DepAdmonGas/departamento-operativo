<?php
require '../../help.php';
$idUsuario = $_GET['idUsuario'];

$mensaje = "TOKEN GENERADO";
$token = bin2hex(random_bytes(3));
$sql = "SELECT token FROM op_token_telegram WHERE id_usuario = '" . $idUsuario . "' ";
$result = mysqli_query($con, $sql);
$numero_lista = mysqli_num_rows($result);
if ($numero_lista > 0) {
  $mensaje = "TOKEN REGISTRADO";
  while ($row_lista = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $token = $row_lista['token'];
  }
} else {
  // Se agrega el nuevo token an caso que no haber generado uno anteriormente
  // estatus 0=activo, 1= inactivo
  $sql = "INSERT INTO op_token_telegram (id_usuario,token,estatus) VALUES ('$idUsuario','$token',0)";
  $result = mysqli_query($con, $sql);
}


?>
<style>
    .modal-box {
      font-family: 'Montserrat', sans-serif;
    }

    .modal-box .show-modal {
      color: #31D7AF;
      background-color: #fff;
      font-size: 16px;
      font-weight: 600;
      text-transform: capitalize;
      padding: 10px 18px;
      margin: 80px auto 0;
      border: none;
      border-radius: 20px;
      outline: none;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      display: block;
      transition: all 0.3s ease 0s;
    }

    .modal-box .show-modal:hover,
    .modal-box .show-modal:focus {
      color: #31D7AF;
      border: none;
      outline: none;
      text-decoration: none;
    }

    .modal-backdrop.show {
      opacity: 0;
    }

    .modal-box .modal-dialog {
      width: 400px;
      margin: 50px auto 0;
    }

    .modal.fade .modal-dialog {
      transform: scale(0.6);
      transition: all 400ms cubic-bezier(.47, 1.64, .41, .8);
    }

    .modal.show .modal-dialog {
      transform: scale(1);
    }

    .modal-box .modal-dialog .modal-content {
      background: #fff;
      text-align: center;
      border: none;
    }

    .modal-box .modal-dialog .modal-content .modal-body {
      padding: 30px !important;
    }

    .modal-box .modal-dialog .modal-content .modal-body .modal-icon {
      color: #000;
      font-size: 80px;
      line-height: 80px;
      margin: 0 auto 30px;
      display: inline-block;
      position: relative;
    }

    .modal-box .modal-dialog .modal-content .modal-body .modal-icon:after {
      color: #fff;
      background: #52FF2C;
      content: "\f00c";
      font-family: "Font Awesome 5 Free";
      font-size: 18px;
      font-weight: 900;
      line-height: 30px;
      width: 30px;
      height: 30px;
      border-radius: 50px;
      position: absolute;
      bottom: 15px;
      right: -15px;
    }

    .modal-box .modal-dialog .modal-content .modal-body .title {
      color: #000;
      font-size: 20px;
      font-weight: 700;
      text-transform: capitalize;
      margin: 0 0 8px;
    }

    .modal-box .modal-dialog .modal-content .modal-body .description {
      color: #555;
      font-size: 15px;
      font-weight: 500;
      margin: 0 0 20px;
    }

    .modal-box .modal-dialog .modal-content .modal-body .code-number {
      padding: 0;
      margin: 0 0 30px;
      list-style: none;
    }

    .modal-box .modal-dialog .modal-content .modal-body .code-number li {
      color: #000;
      background: #F2F2F2;
      font-size: 22px;
      font-weight: 600;
      line-height: 60px;
      width: 60px;
      height: 60px;
      margin: 0 10px;
      border-radius: 50%;
      display: inline-block;
    }

    .modal-box .modal-dialog .modal-content .modal-body .btn {
      color: #fff;
      background: #31D7AF;
      font-size: 16px;
      font-weight: 600;
      text-transform: capitalize;
      padding: 12px 35px 10px;
      margin: 0 auto 10px;
      border-radius: 50px;
      border: none;
      display: block;
      transition: all 0.3s ease 0s;
    }

    .modal-box .modal-dialog .modal-content .modal-body .btn:hover {
      color: #fff;
      text-shadow: 0 0 4px rgba(0, 0, 0, 0.6);
    }

    .modal-box .modal-dialog .modal-content .modal-body .cancel {
      color: #31D7AF;
      font-size: 14px;
      font-weight: 500;
      text-transform: capitalize;
      display: inline-block;
      transition: all 0.3s ease 0s;
    }

    .modal-box .modal-dialog .modal-content .modal-body .cancel:hover {
      text-shadow: 0 2px #ddd;
    }

    @media only screen and (max-width: 767px) {
      .modal-box .modal-dialog {
        width: 95% !important;
      }
    }

    @media only screen and (max-width: 476px) {
      .modal-box .modal-dialog .modal-content .modal-body .code-number li {
        font-size: 18px;
        line-height: 40px;
        height: 40px;
        width: 40px;
        margin: 0 7px;
      }
    }
  </style>
<div class="row">
  <div class="col-md-12">
    <div class="modal-box">
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary btn-lg show-modal" data-bs-toggle="modal" data-bs-target="#myModal">
        View Modal
      </button>

      <!-- Modal -->
      <div class="modal fade" id="myModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <div class="modal-icon"><i class="fas fa-mobile-alt"></i></div>
              <h3 class="title">Verification Code</h3>
              <p class="description">Enter the verification code on your other device to complete sign in.</p>
              <ul class="code-number">
                <li>1</li>
                <li>0</li>
                <li>5</li>
                <li>9</li>
              </ul>
              <button class="btn">Continue</button>
              <a href="#" class="cancel">Already got an account? Sign in</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>