document.addEventListener("DOMContentLoaded", () => {
  const track = document.querySelector('.carousel__track');
  const slides = Array.from(track.children);
  const nextButton = document.querySelector('.carousel__button--right');
  const prevButton = document.querySelector('.carousel__button--left');
  const nav = document.querySelector('.carousel__nav');
  const indicators = Array.from(nav.children); // Obtener los indicadores

  // Establecer el ancho de cada slide
  const slideWidth = slides[0].getBoundingClientRect().width;
  slides.forEach((slide, index) => { 
      slide.style.left = slideWidth * index + 'px'; // Establecer la posición de cada slide
  });

  // Función para mover el track a la posición del slide
  const moveToSlide = (track, currentSlide, targetSlide) => {
      track.style.transform = 'translateX(-' + targetSlide.style.left + ')'; // Mover el track
      currentSlide.classList.remove('current-slide'); // Eliminar la clase current-slide del slide actual
      targetSlide.classList.add('current-slide'); // Agregar la clase current-slide al slide destino
  };

  // Función para ir al siguiente slide
  const goToNextSlide = () => {
      const currentSlide = track.querySelector('.current-slide');
      const nextSlide = currentSlide.nextElementSibling || slides[0]; // Obtener el siguiente slide o el primero
      const currentIndicator = nav.querySelector('.current-slide');
      const nextIndicator = currentIndicator.nextElementSibling || indicators[0]; // Obtener el siguiente indicador
      moveToSlide(track, currentSlide, nextSlide); // Mover el track al siguiente slide
      updateIndicators(currentIndicator, nextIndicator); // Actualizar los indicadores
  };

  // Función para ir al slide anterior
  const goToPrevSlide = () => {
      const currentSlide = track.querySelector('.current-slide');
      const prevSlide = currentSlide.previousElementSibling || slides[slides.length - 1]; // Obtener el slide anterior o el último
      const currentIndicator = nav.querySelector('.current-slide');
      const prevIndicator = currentIndicator.previousElementSibling || indicators[indicators.length - 1]; // Obtener el indicador anterior
      moveToSlide(track, currentSlide, prevSlide); // Mover el track al slide anterior
      updateIndicators(currentIndicator, prevIndicator); // Actualizar los indicadores
  };

  // Función para actualizar los indicadores
  const updateIndicators = (currentIndicator, targetIndicator) => {
      currentIndicator.classList.remove('current-slide');
      targetIndicator.classList.add('current-slide');
  };

  // Eventos para los botones de navegación
  nextButton.addEventListener('click', () => {
      goToNextSlide();
      resetInterval(); // Reiniciar el intervalo cuando se hace clic en el botón de siguiente
  });

  prevButton.addEventListener('click', () => {
      goToPrevSlide();
      resetInterval(); // Reiniciar el intervalo cuando se hace clic en el botón de anterior
  });

  // Navegación mediante indicadores
  nav.addEventListener('click', e => {
      const targetIndicator = e.target.closest('button');
      if (!targetIndicator) return;
      const currentSlide = track.querySelector('.current-slide');
      const currentIndicator = nav.querySelector('.current-slide');
      const targetIndex = indicators.findIndex(indicator => indicator === targetIndicator);
      const targetSlide = slides[targetIndex];
      moveToSlide(track, currentSlide, targetSlide); // Mover el track al slide correspondiente al indicador
      updateIndicators(currentIndicator, targetIndicator); // Actualizar los indicadores
      resetInterval();
  });

  // Auto-slide cada 4 segundos
  let slideInterval = setInterval(goToNextSlide, 4000);

  // Reiniciar el intervalo cuando se interactúa
  const resetInterval = () => {
      clearInterval(slideInterval);
      slideInterval = setInterval(goToNextSlide, 4000);
  };

  // Actualizar la posición de los slides al cambiar el tamaño de la ventana
  window.addEventListener('resize', () => {
      const newSlideWidth = slides[0].getBoundingClientRect().width;
      slides.forEach((slide, index) => {
          slide.style.left = newSlideWidth * index + 'px';
      });
      const currentSlide = track.querySelector('.current-slide');
      track.style.transform = 'translateX(-' + currentSlide.style.left + ')';
  });
});
