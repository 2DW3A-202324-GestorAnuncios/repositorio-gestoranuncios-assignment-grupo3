


function validarContraseña() {
  
  var p = document.getElementById('validar_contraseña').value;
  var box = document.getElementById("expresiones");
  var cont = 0;
  var field = document.createElement('span');
  
  if (p.length < 6 ) {
    
    var salto = document.createElement('br');
    field.appendChild(document.createTextNode("Tu contraseña debe tener al menos 6 caracteres"));
    field.setAttribute('class','error');
    box.appendChild(field);
    field.appendChild(salto);
    cont = cont + 1;
  }
  if (p.search(/[a-z]/i) < 0) {
   
    var salto = document.createElement('br');
    field.appendChild(document.createTextNode("Tu contraseña debe tener al menos una letra minuscula"));
    field.setAttribute('class','error');
    box.appendChild(field);
    field.appendChild(salto);
    cont = cont + 1;
  }
  if (p.search(/[0-9]/) < 0) {
    
    var salto = document.createElement('br');
    field.appendChild(document.createTextNode("Tu contraseña debe tener al menos un digito"));
    field.setAttribute('class','error');
    box.appendChild(field);
    field.appendChild(salto);
    cont = cont + 1;
  }
  if (p.search(/[A-Z]/) < 0) { 
    
    var salto = document.createElement('br');                
    field.appendChild(document.createTextNode("Tu contraseña debe tener al menos una letra mayuscula"));
    field.setAttribute('class','error');
    box.appendChild(field);
    field.appendChild(salto);
    cont = cont + 1;
  }
  if(cont==0){
    
    var salto = document.createElement('br');
    field.appendChild(document.createTextNode("Tu contraseña es adecuada"));
    field.setAttribute('class','correcto');
    box.appendChild(field);
    field.appendChild(salto);
    cont = 0;
  }
}