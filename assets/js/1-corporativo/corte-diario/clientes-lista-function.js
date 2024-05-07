function ListaClientes(idestacion) {
  $('#ListaClientes').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/lista-clientes.php?idEstacion=' + idestacion);  
  //$('#ListaClientes').load('../../../public/corte-diario/vistas/lista-clientes.php?idEstacion=' + idestacion);
  }

  function Agregar() {
    $('#Modal').modal('show');
  }

  function Guardar(sessionidEstacion) {

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
    data.append("idestacion", sessionidEstacion);
    data.append("accion", "agregar-cliente");
    var url = '../../../app/controlador/1-corporativo/controladorCorteDiario.php';
    //var url = '../../../public/corte-diario/modelo/agregar-cliente.php';

    if (Tipo != "") {
      $('#Tipo').css('border', '');

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
        console.log(response);
        if (response == 1) {
          $('#Modal').modal('hide');
          ListaClientes(sessionidEstacion);
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

  }

  function Editar(id) {
    $('#ModalEditar').modal('show');
    $('#ModalEditarCliente').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/modal-editar-cliente.php?idCliente=' + id);
    //$('#ModalEditarCliente').load('../../../public/corte-diario/vistas/modal-editar-cliente.php?idCliente=' + id);
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