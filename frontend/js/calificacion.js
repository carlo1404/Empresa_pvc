document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.estrellas').forEach(estrellas => {
        const stars = estrellas.querySelectorAll('i');

        stars.forEach(star => {
        star.addEventListener('mouseover', () => {
            const val = parseInt(star.getAttribute('data-value'));
            stars.forEach((s, i) => {
            s.classList.toggle('hover', i < val);
            });
        });

        star.addEventListener('mouseout', () => {
            stars.forEach(s => s.classList.remove('hover'));
        });

        star.addEventListener('click', () => {
            const val = parseInt(star.getAttribute('data-value'));
            estrellas.setAttribute('data-rating', val);
            stars.forEach((s, i) => {
            s.classList.toggle('selected', i < val);
            });

            console.log("Calificación seleccionada:", val);
          // Aquí puedes usar fetch o AJAX para enviar la calificación al servidor si lo necesitas
            });
        });
    });
});
