// Filtrado de productos por categoría
document.addEventListener('DOMContentLoaded', function() {
    const categoriaLinks = document.querySelectorAll('.categoria-link');
    const productosGrid = document.querySelector('.productoss__grid');
    const loader = document.getElementById('loader');
    const noResult = document.getElementById('no-result');

    // Establecer "Todas" como categoría activa por defecto
    const todasLink = document.querySelector('[data-categoria-id="todas"]');
    if (todasLink) {
        todasLink.classList.add('categoria-activa');
    }

    categoriaLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remover clase activa de todos los links
            categoriaLinks.forEach(l => l.classList.remove('categoria-activa'));
            
            // Agregar clase activa al link clickeado
            this.classList.add('categoria-activa');
            
            const categoriaId = this.getAttribute('data-categoria-id');
            console.log('Filtrando por categoría:', categoriaId);
            
            // Mostrar loader
            if (loader) loader.style.display = 'block';
            if (noResult) noResult.style.display = 'none';
            
            // Ocultar productos actuales
            productosGrid.style.display = 'none';
            
            // Hacer petición AJAX para filtrar productos
            fetch(`php/filtrar_por_categoria.php?categoria_id=${categoriaId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(data => {
                    console.log('Respuesta recibida:', data.substring(0, 200) + '...');
                    console.log('Longitud de respuesta:', data.length);
                    
                    // Ocultar loader
                    if (loader) loader.style.display = 'none';
                    
                    // Verificar si la respuesta contiene productos o mensaje de "no encontrados"
                    if (data.includes('no-result') || data.includes('Sin resultados')) {
                        console.log('No se encontraron productos para esta categoría');
                        productosGrid.innerHTML = data;
                        productosGrid.style.display = 'grid';
                    } else {
                        console.log('Productos encontrados, actualizando grid');
                        // Actualizar contenido de productos
                        productosGrid.innerHTML = data;
                        productosGrid.style.display = 'grid';
                        
                        // Reinicializar funcionalidades de productos
                        inicializarProductos();
                        
                        // Verificar si las imágenes se cargan correctamente
                        const imagenes = productosGrid.querySelectorAll('img');
                        imagenes.forEach(img => {
                            img.addEventListener('error', function() {
                                console.error('Error cargando imagen:', this.src);
                                this.src = 'img/imagen3.jpg'; // Imagen de respaldo
                            });
                            img.addEventListener('load', function() {
                                console.log('Imagen cargada correctamente:', this.src);
                            });
                        });
                    }
                })
                .catch(error => {
                    console.error('Error al filtrar productos:', error);
                    if (loader) loader.style.display = 'none';
                    productosGrid.style.display = 'grid';
                    
                    // Mostrar mensaje de error
                    productosGrid.innerHTML = `
                        <div class="no-result">
                            <img src="img/imagen3.jpg" alt="Error">
                            <p>Error al cargar productos<br>Intenta de nuevo</p>
                        </div>
                    `;
                });
        });
    });
});

// Función para reinicializar funcionalidades de productos
function inicializarProductos() {
    console.log('Inicializando productos...');
    
    // Reinicializar calificaciones
    const estrellas = document.querySelectorAll('.calificar_estrellas');
    estrellas.forEach(contenedor => {
        const estrellas = contenedor.querySelectorAll('i');
        estrellas.forEach(estrella => {
            estrella.addEventListener('click', function() {
                const valor = this.getAttribute('data-value');
                contenedor.setAttribute('data-rating', valor);
                
                // Actualizar estrellas
                estrellas.forEach((e, index) => {
                    if (index < valor) {
                        e.classList.remove('bx-star');
                        e.classList.add('bxs-star');
                    } else {
                        e.classList.remove('bxs-star');
                        e.classList.add('bx-star');
                    }
                });
            });
        });
    });
    
    // Reinicializar botones de carrito
    const botonesCarrito = document.querySelectorAll('.productoss_btn-carrito');
    console.log('Botones de carrito encontrados:', botonesCarrito.length);
    
    botonesCarrito.forEach(boton => {
        boton.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Botón de carrito clickeado');
            
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const precio = parseInt(this.getAttribute('data-precio'));
            
            // Buscar el input de cantidad correspondiente
            const cantidadInput = document.getElementById(`cantidad_${id}`);
            const cantidad = cantidadInput ? parseInt(cantidadInput.value) : 1;
            
            console.log('Datos del producto:', { id, nombre, precio, cantidad });
            
            // Verificar si existe la función agregarAlCarrito
            if (typeof agregarAlCarrito === 'function') {
                agregarAlCarrito(id, nombre, precio, cantidad);
                console.log('Producto agregado al carrito');
            } else {
                console.error('Función agregarAlCarrito no está disponible');
                // Mostrar mensaje de éxito temporal
                mostrarNotificacion('Producto agregado al carrito', 'exito');
            }
        });
    });
    
    // Reinicializar botones de carrito de la sección de descuento
    const botonesCarritoDescuento = document.querySelectorAll('.productos .productoss_btn-carrito');
    console.log('Botones de carrito descuento encontrados:', botonesCarritoDescuento.length);
    
    botonesCarritoDescuento.forEach(boton => {
        boton.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Botón de carrito descuento clickeado');
            
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const precio = parseInt(this.getAttribute('data-precio'));
            
            // Buscar el input de cantidad correspondiente
            const cantidadInput = document.getElementById(`cantidad_descuento_${id}`);
            const cantidad = cantidadInput ? parseInt(cantidadInput.value) : 1;
            
            console.log('Datos del producto descuento:', { id, nombre, precio, cantidad });
            
            // Verificar si existe la función agregarAlCarrito
            if (typeof agregarAlCarrito === 'function') {
                agregarAlCarrito(id, nombre, precio, cantidad);
                console.log('Producto de descuento agregado al carrito');
            } else {
                console.error('Función agregarAlCarrito no está disponible');
                // Mostrar mensaje de éxito temporal
                mostrarNotificacion('Producto agregado al carrito', 'exito');
            }
        });
    });
}

// Función para mostrar notificaciones
function mostrarNotificacion(mensaje, tipo = 'info') {
    const notificacion = document.createElement('div');
    notificacion.className = `notificacion notificacion-${tipo}`;
    notificacion.innerHTML = `
        <span>${mensaje}</span>
        <button onclick="this.parentElement.remove()" class="cerrar-notificacion">
            <i class='bx bx-x'></i>
        </button>
    `;
    
    document.body.appendChild(notificacion);
    
    // Auto-ocultar después de 3 segundos
    setTimeout(() => {
        if (notificacion.parentElement) {
            notificacion.remove();
        }
    }, 3000);
} 