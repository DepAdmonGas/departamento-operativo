
  function CoreteDiarioM(year, mes) {
    window.location.href = year + "/" + mes;
  }

  function ventas(year, mes, idDias) {
    window.location.href = "../../corte-ventas/" + year + "/" + mes + "/" + idDias;
  }

  function cierrelote(year, mes, idDias) {
    window.location.href = "../../cierre-lote/" + year + "/" + mes + "/" + idDias;
  }

  function monedero(year, mes, idDias) {
    window.location.href = "../../monedero/" + year + "/" + mes + "/" + idDias;
  }

  function Aceites(year, mes) {
    window.location.href = "../../aceites-mes/" + year + "/" + mes;
  }

  function impuestos(year, mes, idDias) {
    window.location.href = "../../impuestos-mes/" + year + "/" + mes + "/" + idDias;
  }

  function clientes(year, mes, idDias) {

    window.location.href = "../../clientes/" + year + "/" + mes + "/" + idDias;

  }

  function ResumenImpuestos(year, mes) {

    window.location.href = "../../resumen-impuestos/" + year + "/" + mes;
  }

  function ResumenMonedero(year, mes) {
    window.location.href = "../../resumen-monedero/" + year + "/" + mes;
  }

  function Clientes(year, mes) {
    window.location.href = "../../clientes-mes/" + year + "/" + mes;
  }

  function Embarques(year, mes) {
    window.location.href = "../../embarques-mes/" + year + "/" + mes;
  }

  function ControlVolumetrico(estacion, year, mes) {


    window.location.href = "../../administracion/control-volumetrico/" + estacion + "/" + year + "/" + mes;

  }

  function ConcentradoVentas(estacion, year, mes) {
    var scrollTop = window.scrollY;
    sessionStorage.setItem('scrollTop', 0);
    window.location.href = "../../administracion/concentrado-ventas/" + estacion + "/" + year + "/" + mes;

  }