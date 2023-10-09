$('#form1').submit(function() {

  if($('#email').val().length == 0)
    return false;
 else 
    return true;
});
$("form").submit(function(a){
  a.preventDefault();
});
function validarContraseña() {
  var p = document.getElementById('validar_contraseña').value,
      errors = [];


  if(p.length == 0){

  }else{

    if (p.length < 6 ) {
      errors.push("Tu contraseña debe tener al menos 6 caracteres"); 
    }
    if (p.search(/[a-z]/i) < 0) {
        errors.push("Tu contraseña debe tener al menos una letra");
    }
    if (p.search(/[0-9]/) < 0) {
        errors.push("Tu contraseña debe tener al menos un digito"); 
    }
    if (p.search(/[A-Z]/) < 0) {                         
      errors.push("Tu contraseña debe tener al menos una letra en mayuscula")                     
    }
    if (errors.length > 0) {
        alert(errors.join("\n"));
        return false;
    }
      

  }
}