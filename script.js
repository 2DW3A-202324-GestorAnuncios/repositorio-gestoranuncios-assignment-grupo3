var num = 1;

function deshabilitarBoton(){
  var button = document.getElementById("boton");
  button.setAttribute("disabled","");

}

function validarContraseña() {  
  var c = document.getElementById('validar_contraseña').value;
  var box = document.getElementById("expresiones");
  var field = document.createElement('span');
  const boton = document.getElementById("boton");
  const error = document.getElementById("error3");
  var cont = 0; 
  if (c.length < 6 ) {
    document.getElementById("expresiones").innerHTML = "";         
    var salto = document.createElement('br');
    field.appendChild(document.createTextNode("Tu contraseña debe tener al menos 6 caracteres"));
    field.setAttribute('class','error');
    box.appendChild(field);
    field.appendChild(salto);
    cont = cont + 1;
    num=num+1;


  }
  if (c.search(/[a-z]/i) < 0) {
    document.getElementById("expresiones").innerHTML = "";   
    var salto = document.createElement('br');
    field.appendChild(document.createTextNode("Tu contraseña debe tener al menos una letra minuscula"));
    field.setAttribute('class','error');
    box.appendChild(field);
    field.appendChild(salto);
    cont = cont + 1;
    num=num+1;


  }
  if (c.search(/[0-9]/) < 0) {
    document.getElementById("expresiones").innerHTML = "";   
    var salto = document.createElement('br');
    field.appendChild(document.createTextNode("Tu contraseña debe tener al menos un digito"));
    field.setAttribute('class','error');
    box.appendChild(field);
    field.appendChild(salto);
    cont = cont + 1;
    num=num+1;


  }
  if (c.search(/[A-Z]/) < 0) { 
    document.getElementById("expresiones").innerHTML = "";   
    var salto = document.createElement('br');                
    field.appendChild(document.createTextNode("Tu contraseña debe tener al menos una letra mayuscula"));
    field.setAttribute('class','error');
    box.appendChild(field);
    field.appendChild(salto);
    cont = cont + 1;
    num=num+1;


  }
  if(cont==0){
    document.getElementById("expresiones").innerHTML = "";   
    var salto = document.createElement('br');
    field.appendChild(document.createTextNode("Tu contraseña es adecuada"));
    field.setAttribute('class','correcto');
    box.appendChild(field);
    field.appendChild(salto);
    num = 0;

  }
}
function confirmarContraseña() {
  var c = document.getElementById('validar_contraseña').value;
  var c2 = document.getElementById('validar_contraseña2').value;
  const error = document.getElementById("error4");
  if (c === c2) {
    error.innerText = "";
    num = 0;

  }else{
    error.innerText = "Las contraseñas tienen que ser identicas";
    num=num+1;

  }
}
function validarUsuario() {
  const usuario = document.getElementById("usuario").value;
  const error = document.getElementById("error1");
  if (usuario.length < 3) {
    error.innerText = "El usuario debe tener 4 o mas caracteres";
    num=num+1;
  }else{
    error.innerText = "";
    num = 0;

  }
}
function validarEmail(){
  var email = document.getElementById('email');
  const error = document.getElementById("error2");
  var emailRE =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
	if( emailRE.test(email.value) ){
    error.innerText = "";
    num = 0;

		return true;
	}else{
    error.innerText = "El email no es valido";
    num=num+1;
		return false;
	}
} 
function confirmarTerminos(){
  var x = document.getElementById('terminos');
  if (x.checked) {
    num = num -1;
    if (num == 0) {
      var button = document.getElementById("boton");
      button.removeAttribute("disabled","");
    }
  } 
  
}





