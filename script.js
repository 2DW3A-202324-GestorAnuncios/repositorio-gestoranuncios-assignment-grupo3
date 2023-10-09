
$('#input').keydown(function(e) {
  if (e.shiftKey && e.which == 51) {
    e.preventDefault();
    alert('Disallowed');
  }
});

function validarContraseña() {
  var p = document.getElementById('validar_contraseña').value,
      errors = ["Tu contraseña debe tener al menos 6 caracteres","Tu contraseña debe tener al menos una letra",
      "Tu contraseña debe tener al menos un digito","Tu contraseña debe tener al menos una letra en mayuscula"];

  
  if(p.length == 0){

  }else{
    if (p.length < 6 ) {
      const node = document.createElement("span");
      const line = document.createElement("br");
      node.setAttribute('class','error');
      const textnode = document.createTextNode(errors[0]);
      node.appendChild(textnode);
      document.getElementById("expresiones").appendChild(node);
      document.getElementById("expresiones").appendChild(line);
    }
    if (p.search(/[a-z]/i) < 0) {
      const node = document.createElement("span");
      const line = document.createElement("br");
      node.setAttribute('class','error');
      const textnode = document.createTextNode(errors[1]);
      node.appendChild(textnode);
      document.getElementById("expresiones").appendChild(node);
      document.getElementById("expresiones").appendChild(line);
    }
    if (p.search(/[0-9]/) < 0) {
      const node = document.createElement("span");
      const line = document.createElement("br");
      node.setAttribute('class','error');
      const textnode = document.createTextNode(errors[2]);
      node.appendChild(textnode);
      document.getElementById("expresiones").appendChild(node);
      document.getElementById("expresiones").appendChild(line);
    }
    if (p.search(/[A-Z]/) < 0) {                         
      const node = document.createElement("span");
      const line = document.createElement("br");
      node.setAttribute('class','error');
      const textnode = document.createTextNode(errors[3]);
      node.appendChild(textnode);
      document.getElementById("expresiones").appendChild(node);
      document.getElementById("expresiones").appendChild(line);
    }
  }
}