


function validarContraseña() {
  
  var p = document.getElementById('validar_contraseña').value;
  var box = document.getElementById("expresiones");
  
  if (p.length < 6 ) {
    var field = document.createElement('span');
    var salto = document.createElement('br')
    field.appendChild(document.createTextNode("Tu contraseña debe tener al menos 6 caracteres"));
    field.setAttribute('class','error');
    box.appendChild(field);
    field.appendChild(salto);
  }
  if (p.search(/[a-z]/i) < 0) {
    var field = document.createElement('span');
    var salto = document.createElement('br')
    field.appendChild(document.createTextNode("Tu contraseña debe tener al menos una letra minuscula"));
    field.setAttribute('class','error');
    box.appendChild(field);
    field.appendChild(salto);
  }
  if (p.search(/[0-9]/) < 0) {
    var field = document.createElement('span');
    var salto = document.createElement('br')
    field.appendChild(document.createTextNode("Tu contraseña debe tener al menos un digito"));
    field.setAttribute('class','error');
    box.appendChild(field);
    field.appendChild(salto);
  }
  if (p.search(/[A-Z]/) < 0) {                         
    var field = document.createElement('span');
    var salto = document.createElement('br')
    field.appendChild(document.createTextNode("Tu contraseña debe tener al menos una letra mayuscula"));
    field.setAttribute('class','error');
    box.appendChild(field);
    field.appendChild(salto);
  }
  if(p.length > 6 && p.search(/[a-z]/i) > 0 && p.search(/[0-9]/) > 0 && p.search(/[A-Z]/) > 0){
    var field = document.createElement('span');
    var salto = document.createElement('br')
    field.appendChild(document.createTextNode("Tu contraseña es adecuada"));
    box.appendChild(field);
    field.appendChild(salto);
  }
}