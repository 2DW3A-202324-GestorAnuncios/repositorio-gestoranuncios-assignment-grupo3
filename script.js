document.addEventListener("DOMContentLoaded", function () {
  const noticias = document.querySelectorAll(".noticia");
  const anteriorBtn = document.getElementById("anterior");
  const siguienteBtn = document.getElementById("siguiente");
  let indiceActual = 0;

  function mostrarNoticia(indice) {
      noticias.forEach((noticia, index) => {
          if (index === indice) {
              noticia.style.display = "block";
          } else {
              noticia.style.display = "none";
          }
      });
      
  }

  function avanzarNoticia() {
      indiceActual++;
      if (indiceActual >= noticias.length) {
          indiceActual = 0;
      }
      mostrarNoticia(indiceActual);
  }

  function retrocederNoticia() {
      indiceActual--;
      if (indiceActual < 0) {
          indiceActual = noticias.length - 1;
      }
      mostrarNoticia(indiceActual);
  }

  mostrarNoticia(indiceActual);

  siguienteBtn.addEventListener("click", avanzarNoticia);
  anteriorBtn.addEventListener("click", retrocederNoticia);

  // Cambiar automáticamente de noticia cada 10 segundos
  setInterval(avanzarNoticia, 10000);
});
