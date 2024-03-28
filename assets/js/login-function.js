 // ---------- INICIO DE SESION ---------- //
function inicioSesion(){
   
  var ruta = window.location;
  var valorusuario = $('#valorusuario').val();
  var valorpassword = $('#valorpassword').val();


  if (valorusuario.trim() === ''){
  $('#valorusuario').css('border','2px solid #B83737');
  }else if (valorpassword.trim() === '') {
  $('#valorpassword').css('border','2px solid #B83737');
 
  }else{

  var parametros = {
  "valor_usuario" : valorusuario,
  "valor_password" : valorpassword
  };
    
   
  $.ajax({
  data:  parametros,
  url:   ruta + 'app/modelo/acceso/login-usuarios.php',
  type:  'POST',

  beforeSend: function() {
  $("#resultadoDiv").html('<div class="text-center pt-2"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
  },
  complete: function(){


  },
  success:  function (response) {

  var tokensessionAG = response.token;
  var estado = response.estado;
  var server = window.location.hostname;

  if(estado == 0){
  $("#resultadoDiv").html('<div class="alert alert-danger text-center" role="alert">Los campos de correo electronico y contraseña son obligatorios.</div>');
  
  }else if(estado == 1){
  localStorage.setItem("TOKENSESSIONAG", tokensessionAG);
  setCookie("TOKENSESSIONAG", tokensessionAG, 365);
  window.location.href = "home"; 

  }else if(estado == 2){
  localStorage.setItem("TOKENSESSIONAG", tokensessionAG);
  setCookie("TOKENSESSIONAG", tokensessionAG, 365);
  window.location.href = "cursos";

  //----- Usuario: Gerente - Estacion: Comodin 
  }else if(estado == 3){
  localStorage.setItem("TOKENSESSIONAG", tokensessionAG);
  setCookie("TOKENSESSIONAG", tokensessionAG, 365);
  window.location.href = "comodines"; 
 
  //----- Portal Sasisopa -------
  }else if(estado == 4){
  localStorage.setItem("TOKENSESSIONAG", tokensessionAG);
  setCookie("TOKENSESSIONAG", tokensessionAG, 365);
  window.location.href = "http://" + server + "/portal-sasisopa"; 

  //----- Departamento Operativo (Administrador) -------
  }else if(estado == 5){
  localStorage.setItem("TOKENSESSIONAG", tokensessionAG);
  setCookie("TOKENSESSIONAG", tokensessionAG, 365);
  window.location.href = "http://" + server + "/departamento-operativo/administracion"; 

  //----- Departamento Operativo (Administrador) - Solicitud de Cheques -------
  }else if(estado == 6){
  localStorage.setItem("TOKENSESSIONAG", tokensessionAG);
  setCookie("TOKENSESSIONAG", tokensessionAG, 365);
  window.location.href = "http://" + server + "/departamento-operativo/administracion/solicitud-cheque"; 
  
  //----- Departamento Operativo (Administrador) - Miscelanea 30, 31 -------
  }else if(estado == 7){
  localStorage.setItem("TOKENSESSIONAG", tokensessionAG);
  setCookie("TOKENSESSIONAG", tokensessionAG, 365);
  window.location.href = "http://" + server + "/departamento-operativo/miselanea-30-31"; 
  
  //----- Departamento Operativo (Administrador) - Formato de Descarga TAD-Tuxpan -------
  }else if(estado == 8){
  localStorage.setItem("TOKENSESSIONAG", tokensessionAG);
  setCookie("TOKENSESSIONAG", tokensessionAG, 365);
  window.location.href = "http://" + server + "/departamento-operativo/departamento-operativo/descarga-tuxpan"; 

  }


  }

  });

 
  } 
   
} 

 
// ---------- ENVIO DE LA COOKIE ---------- //
function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
} 




