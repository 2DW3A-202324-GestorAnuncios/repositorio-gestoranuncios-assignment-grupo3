const noticias = document.querySelectorAll('.noticia');

let currentIndex = 0;

function mostrarNoticia(index) {
  noticias.forEach((noticia, i) => {
    if (i === index) {
      noticia.style.display = 'block';
    } else {
      noticia.style.display = 'none';
    }
  });
}

function avanzarNoticia() {
  currentIndex++;
  if (currentIndex >= noticias.length) {
    currentIndex = 0;
  }
  mostrarNoticia(currentIndex);
}

// Mostrar la primera noticia al cargar la página
mostrarNoticia(currentIndex);

// Cambiar de noticia automáticamente cada 5 segundos (5000 milisegundos)
setInterval(avanzarNoticia, 5000);
