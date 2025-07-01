document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar el botón hamburguesa y el contenedor de acciones del header
    const hamburger = document.querySelector('.hamburger');
    const headerActions = document.querySelector('.header__actions');
    const header = document.querySelector('.header');

    // Añadir un listener al botón hamburguesa para alternar la visibilidad del menú
    hamburger.addEventListener('click', function(event) {
        event.stopPropagation(); // Evitar que el clic en el botón hamburguesa cierre el menú
        headerActions.classList.toggle('show');
    });

    // Añadir un listener para detectar clics fuera del menú
    document.addEventListener('click', function(event) {
        // Si el clic es fuera del header (y no en el botón hamburguesa)
        if (!header.contains(event.target)) {
            headerActions.classList.remove('show');
        }
    });
});
