document.addEventListener("DOMContentLoaded", () => {
    const estrellasContainers = document.querySelectorAll(".calificar_estrellas");

    estrellasContainers.forEach(container => {
      const estrellas = container.querySelectorAll("i");

      estrellas.forEach((estrella, index) => {
        estrella.addEventListener("click", () => {
          // Guardar el valor
          const valor = index + 1;
          container.setAttribute("data-rating", valor);

          // Quitar selección anterior
          estrellas.forEach(e => e.classList.remove("selected"));

          // Marcar las estrellas seleccionadas
          for (let i = 0; i <= index; i++) {
            estrellas[i].classList.add("selected");
          }
        });

        estrella.addEventListener("mouseenter", () => {
          for (let i = 0; i <= index; i++) {
            estrellas[i].classList.add("hover");
          }
        });

        estrella.addEventListener("mouseleave", () => {
          estrellas.forEach(e => e.classList.remove("hover"));
        });
      });
    });
});

