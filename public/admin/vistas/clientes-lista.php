<?php
require ('app/help.php');

if ($Session_IDUsuarioBD == "") {
  header("Location:" . PORTAL . "");
}

$sql_dia = "SELECT fecha FROM op_corte_dia WHERE id = '" . $GET_idReporte . "' ";
$result_dia = mysqli_query($con, $sql_dia);
while ($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)) {
  $dia = $row_dia['fecha'];
}
?>

<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?= RUTA_CSS2 ?>alertify.css">
  <link rel="stylesheet" href="<?= RUTA_CSS2 ?>themes/default.rtl.css">
  <link href="<?= RUTA_CSS2; ?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?= RUTA_CSS2; ?>navbar-general.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">


  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");

      ListaClientes(<?= $GET_idReporte; ?>);
    });

    function Regresar() {
      window.history.back();
    }


    function ListaClientes(idReporte) {
      let targetsCredito = [3,4,5,6,7];
      
      $('#ListaClientes').load('../../../../public/admin/vistas/lista-clientes.php?idReporte=' + idReporte, function () {
        $('#tabla_credito').DataTable({
          "language": {
            "url": "<?=RUTA_JS2?>/es-ES.json"
          },
          "order": [[0, "desc"]],
          "lengthMenu": [25, 50, 75, 100],
          "columnDefs": [
            { "orderable": false, "targets": targetsCredito },
            { "searchable": false, "targets": targetsCredito }
          ]
        });
        $('#tabla_debito').DataTable({
          "language": {
          "url": "<?=RUTA_JS2?>/es-ES.json"
          }, 
          "order": [[0, "desc"]],
          "lengthMenu": [25, 50, 75, 100],
          "columnDefs": [
            { "orderable": false},
            { "searchable": false}
          ]
        });
      });

    } 
    function Agregar() {
      $('#Modal').modal('show');
    }

    function Guardar(idReporte) {

      var Cuenta = $('#Cuenta').val();
      var Cliente = $('#Cliente').val();
      var Tipo = $('#Tipo').val();
      var RFC = $('#RFC').val();

      CartaCredito = document.getElementById("CartaCredito");
      CartaCredito_file = CartaCredito.files[0];
      CartaCredito_filePath = CartaCredito.value;

      ActaConstitutiva = document.getElementById("ActaConstitutiva");
      ActaConstitutiva_file = ActaConstitutiva.files[0];
      ActaConstitutiva_filePath = ActaConstitutiva.value;

      ComprobanteDom = document.getElementById("ComprobanteDom");
      ComprobanteDom_file = ComprobanteDom.files[0];
      ComprobanteDom_filePath = ComprobanteDom.value;

      Identificacion = document.getElementById("Identificacion");
      Identificacion_file = Identificacion.files[0];
      Identificacion_filePath = Identificacion.value;

      var data = new FormData(); 
      var url = '../../../../public/admin/modelo/agregar-cliente.php';

      if (Cuenta != "") {
      $('#Cuenta').css('border', '');

      if (Cliente != "") {
        $('#Cliente').css('border', '');

      if (Tipo != "") {
        $('#Tipo').css('border', '');

        data.append('idReporte', idReporte);
        data.append('Cuenta', Cuenta);
        data.append('Cliente', Cliente);
        data.append('Tipo', Tipo);
        data.append('RFC', RFC);
        data.append('CartaCredito_file', CartaCredito_file);
        data.append('ActaConstitutiva_file', ActaConstitutiva_file);
        data.append('ComprobanteDom_file', ComprobanteDom_file);
        data.append('Identificacion_file', Identificacion_file);

        $.ajax({
          url: url,
          type: 'POST',
          contentType: false,
          data: data,
          processData: false,
          cache: false
        }).done(function (response) {

          console.log(response)

          if (response == 1) {
            $('#Modal').modal('hide');
            ListaClientes(idReporte);
            alertify.success('Cliente agregado exitosamente.')
            $('#Cuenta').val('');
            $('#Cliente').val('');
            $('#Tipo').val('');

          } else {
            alertify.error('Error al agregar cliente')
          }

        });

      } else {
        $('#Tipo').css('border', '2px solid #A52525');
      }

    } else {
        $('#Cliente').css('border', '2px solid #A52525');
      }

    } else {
        $('#Cuenta').css('border', '2px solid #A52525');
      }

    }

    function Editar(id) {
      $('#ModalEditar').modal('show');
      $('#ModalEditarCliente').load('../../../../public/admin/vistas/modal-editar-cliente.php?idCliente=' + id);
    }

    function EditarCliente(idCliente) {

      var Cuenta = $('#EditCuenta').val();
      var Cliente = $('#EditCliente').val();
      var Tipo = $('#EditTipo').val();
      var RFC = $('#EditRFC').val();


      CartaCredito = document.getElementById("EditCartaCredito");
      CartaCredito_file = CartaCredito.files[0];
      CartaCredito_filePath = CartaCredito.value;

      ActaConstitutiva = document.getElementById("EditActaConstitutiva");
      ActaConstitutiva_file = ActaConstitutiva.files[0];
      ActaConstitutiva_filePath = ActaConstitutiva.value;

      ComprobanteDom = document.getElementById("EditComprobanteDom");
      ComprobanteDom_file = ComprobanteDom.files[0];
      ComprobanteDom_filePath = ComprobanteDom.value;

      Identificacion = document.getElementById("EditIdentificacion");
      Identificacion_file = Identificacion.files[0];
      Identificacion_filePath = Identificacion.value;


      if (Cuenta != "") {
      $('#EditCuenta').css('border', '');

      if (Cliente != "") {
      $('#EditCliente').css('border', '');

      if (Tipo != "") {
      $('#EditTipo').css('border', '');


      var data = new FormData();
      var url = '../../../../public/admin/modelo/editar-cliente.php';

      data.append('idCliente', idCliente);
      data.append('Cuenta', Cuenta);
      data.append('Cliente', Cliente);
      data.append('Tipo', Tipo);
      data.append('RFC', RFC);
      data.append('CartaCredito_file', CartaCredito_file);
      data.append('ActaConstitutiva_file', ActaConstitutiva_file);
      data.append('ComprobanteDom_file', ComprobanteDom_file);
      data.append('Identificacion_file', Identificacion_file);


      $.ajax({
        url: url,
        type: 'POST',
        contentType: false,
        data: data,
        processData: false,
        cache: false
      }).done(function (response) {

        
        if (response == 1) {
          $('#ModalEditar').modal('hide');
          ListaClientes(<?= $GET_idReporte; ?>);
          alertify.success('Registro editado exitosamente.')

          $('#EditCuenta').val('');
          $('#EditCliente').val('');
          $('#EditTipo').val('');
          $('#EditRFC').val('');

        } else {
          alertify.error('Error al editar cliente')
        }

      });

      
    } else {
        $('#EditTipo').css('border', '2px solid #A52525');
      }

    } else {
        $('#EditCliente').css('border', '2px solid #A52525');
      }

    } else {
        $('#EditCuenta').css('border', '2px solid #A52525');
      }


    }

    function SelCredito(valor) {

      var valor = valor.value;
      var SelCredito = document.getElementById("SelCredito");

      if (valor == "Crédito") {
        SelCredito.style.display = "block";
      } else {
        SelCredito.style.display = "none";
      }

    }
  </script>
  <!---------- LIBRERIAS DEL DATATABLE ---------->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
</head>

<body>
 
  <div class="LoaderPage"></div>

  <!---------- DIV - CONTENIDO ---------->
  <div id="content">
    <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
    <?php include_once "public/navbar/navbar-perfil.php"; ?>
    <!---------- CONTENIDO PAGINA WEB---------->
    <div class="contendAG">
      <div class="row">
        <div class="col-12">

          <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
            <ol class="breadcrumb breadcrumb-caret">
              <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-chevron-left"></i> Clientes,
                  <?= $ClassHerramientasDptoOperativo->nombreMes($GET_mes) ?> <?= $GET_year ?></a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">Lista de Clientes</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Lista de Clientes
              </h3>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
              <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Agregar()">
                <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
            </div>
          </div>
          <hr>
        </div>

        <div id="ListaClientes"></div>


      </div>
    </div>

  </div>


  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Crear Cliente</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <label class="text-secondary">* Cuenta</label>
          <textarea class="form-control rounded-0" id="Cuenta"></textarea>

          <label class="text-secondary mt-2 mb-1">* Cliente</label>
          <textarea class="form-control rounded-0" id="Cliente"></textarea>

          <label class="text-secondary mt-2 mb-1">* Tipo</label>
          <select class="form-select rounded-0" id="Tipo" onchange="SelCredito(this)">
            <option value="">Selecciona una opción...</option>
            <option value="Crédito">Crédito</option>
            <option value="Débito">Débito</option>
          </select>

          <div id="SelCredito" style="display: none;">
            <hr>
            
            <label class="text-secondary mb-1">RFC</label>
            <input class="form-control" type="text" class="form-control rounded-0" id="RFC">

            <label class="text-secondary mt-3 mb-1">Carta de crédito</label>
            <input class="form-control" type="file" id="CartaCredito">

            <label class="text-secondary mt-3 mb-1">Acta constitutiva</label>
            <div><input class="form-control" type="file" id="ActaConstitutiva"></div>

            <label class="text-secondary mt-3 mb-1">Comprobante de domicilio</label>
            <div><input class="form-control" type="file" id="ComprobanteDom"></div>

            <label class="text-secondary mt-3 mb-1">Identificación</label>
            <div><input class="form-control" type="file" id="Identificacion"></div>
          </div>

        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-labeled2 btn-success" onclick="Guardar(<?= $GET_idReporte; ?>)">
        <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <!---------- MODAL COVID (RIGHT)---------->  
  <div class="modal right fade" id="ModalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
  <div class="modal-content" id="ModalEditarCliente"></div>
  </div>
  </div>
  
  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>
  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

  </body>
  </html>