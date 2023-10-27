var num = 0;

function validarCampos() { 
  num = 0;
  //comprueba nombre
  var nombre = document.getElementById('nombre').value;
  const error6 = document.getElementById("error6");
  if (nombre.length == 0) {
    error6.innerText = "Introduce un nombre";
    num=num+1;

  } else{
    error6.innerText = "";

  }
  //comprueba apellido
  var apellido = document.getElementById('apellido').value;
  const error7 = document.getElementById("error7");
  if (apellido.length == 0) {
    error7.innerText = "Introduce un apellido";
    num=num+1;

  }else{
    error7.innerText = "";

  } 
  //validar contraseña 
  var c = document.getElementById('validar-contraseña').value;
  var box = document.getElementById("expresiones");
  var field = document.createElement('span');
  const boton = document.getElementById("boton");
  const error3 = document.getElementById("error3");
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
  }
//confirmar contraseña
  var c = document.getElementById('validar-contraseña').value;
  var c2 = document.getElementById('validar-contraseña2').value;
  const error4 = document.getElementById("error4");
  if (c === c2) {
    error4.innerText = "";

  }else{
    error4.innerText = "Las contraseñas tienen que ser identicas";
    num=num+1;

  }
//validar usuario
  const usuario = document.getElementById("usuario").value;
  const error1 = document.getElementById("error1");
  if (usuario.length < 3) {
    error1.innerText = "El usuario debe tener 4 o mas caracteres";
    num=num+1;

  }else{
    error1.innerText = "";

  }
//validar email
  var email = document.getElementById('email');
  const error2 = document.getElementById("error2");
  var emailRE =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
	if( emailRE.test(email.value) ){
    error2.innerText = "";

	}else{
    error2.innerText = "El email no es valido";
    num=num+1;

	}

    if (nombre.length == 0) {
        error6.innerText = "Introduce un nombre";
        num = num + 1;
    } else {
        error6.innerText = "";
    }

  if(!fechaNac){
    error8.innerText = "Introduce una fecha";
    num=num+1;

  }else{
    error8.innerText = "";

  }
  //validar genero
  const error9 = document.getElementById("error9");
  var masc = document.getElementById('masculino');
  var fem = document.getElementById('femenino');
  var otros = document.getElementById('otros');

    if (apellido.length == 0) {
        error7.innerText = "Introduce un apellido";
        num = num + 1;
    } else {
        error7.innerText = "";
    }

    var c = document.getElementById('validar-contraseña').value;
    var box = document.getElementById("expresiones");
    var field = document.createElement('span');
    var cont = 0;

    if (c.length < 6 ) {
        document.getElementById("expresiones").innerHTML = "";         
        var salto = document.createElement('br');
        field.appendChild(document.createTextNode("Tu contraseña debe tener al menos 6 caracteres"));
        field.setAttribute('class','error');
        box.appendChild(field);
        field.appendChild(salto);
        cont = cont + 1;
        num = num + 1;
    }
    if (c.search(/[a-z]/i) < 0) {
        document.getElementById("expresiones").innerHTML = "";   
        var salto = document.createElement('br');
        field.appendChild(document.createTextNode("Tu contraseña debe tener al menos una letra minuscula"));
        field.setAttribute('class','error');
        box.appendChild(field);
        field.appendChild(salto);
        cont = cont + 1;
        num = num + 1;
    }
    if (c.search(/[0-9]/) < 0) {
        document.getElementById("expresiones").innerHTML = "";   
        var salto = document.createElement('br');
        field.appendChild(document.createTextNode("Tu contraseña debe tener al menos un digito"));
        field.setAttribute('class','error');
        box.appendChild(field);
        field.appendChild(salto);
        cont = cont + 1;
        num = num + 1;
    }
    if (c.search(/[A-Z]/) < 0) { 
        document.getElementById("expresiones").innerHTML = "";   
        var salto = document.createElement('br');                
        field.appendChild(document.createTextNode("Tu contraseña debe tener al menos una letra mayuscula"));
        field.setAttribute('class','error');
        box.appendChild(field);
        field.appendChild(salto);
        cont = cont + 1;
        num = num + 1;
    }
    if (cont == 0) {
        document.getElementById("expresiones").innerHTML = "";   
        var salto = document.createElement('br');
        field.appendChild(document.createTextNode("Tu contraseña es adecuada"));
        field.setAttribute('class','correcto');
        box.appendChild(field);
        field.appendChild(salto);
    }

    // Confirmar contraseña

    if (usuario.length < 3) {
        error1.innerText = "El usuario debe tener 3 o mas caracteres";
        num = num + 1;
    } else {
        error1.innerText = "";
    }

    // Validar email
    var email = document.getElementById('email');
    var emailRE =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;

    if (emailRE.test(email.value)) {
        error2.innerText = "";
    } else {
        error2.innerText = "El email no es valido";
        num = num + 1;
    }

    // Validar fechaNacimiento
    var fechaNac = document.getElementById('fecha').value;
    const error8 = document.getElementById("error8");

    if (!fechaNac) {
        error8.innerText = "Introduce una fecha";
        num = num + 1;
    } else {
        error8.innerText = "";
    }

    // Validar genero
    var masc = document.getElementById('masculino');
    var fem = document.getElementById('femenino');
    var otros = document.getElementById('otros');

    if (masc.checked || fem.checked || otros.checked) {
        error9.innerText = "";
    } else {
        error9.innerText = "Seleccione su genero";
        num = num + 1;
    }

    //comprobar terminos
    const error5 = document.getElementById("error5");
    
    if (document.getElementById('terminos').checked == false) {
        error5.innerText = "Debe aceptar los terminos";
        num = num + 1;
    } else {
        error5.innerText = "";
    }

    const btn = document.getElementById('botonSubmit');

    if (num!=0) {
        btn.removeAttribute("type","submit")
        btn.setAttribute("type","button")
    } else if (num === 0) {
        btn.removeAttribute("type","submit")
        btn.setAttribute("type","submit")
    }
}

// Funciones del Login
function toggleDropdown() {
    var formSesion = document.getElementById("form-inicio-sesion");

    if (formSesion.style.display === "none" || formSesion.style.display === "") {
        formSesion.style.display = "block";
    } else {
        formSesion.style.display = "none";
    }
}

function anadirCarritoAndToggleDropdown() {
    // Llama a la función toggleDropdown() directamente
    toggleDropdown();

    // Desplázate hacia la parte superior de la página
    window.scrollTo(0, 0);
}

function mostrarError(mensaje) {
    var mensajeError = document.getElementById("mensaje-error");

    mensajeError.textContent = mensaje;
    mensajeError.style.display = "block";
  if(masc.checked || fem.checked || otros.checked) {
    error9.innerText = "";

  }else{
    error9.innerText = "Seleccione su genero";
    num=num+1;

  }
  const error5 = document.getElementById("error5");
  //comprobar terminos
  if (document.getElementById('terminos').checked == false) {
    error5.innerText = "Debe aceptar los terminos";
    num=num+1;

  }else{
    error5.innerText = "";

  }


  const btn = document.getElementById('botonSubmit');
  if (num!=0) {
    btn.removeAttribute("type","submit")
    btn.setAttribute("type","button")
  }else if(num === 0){
    
    btn.removeAttribute("type","submit")
    btn.setAttribute("type","submit")
  }
}
