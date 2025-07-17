let categoriaSeleccionada = null;

// Manejar clic en categorías
const categoriasNav = document.querySelector('.categorias-nav__lista');
if (categoriasNav) {
  categoriasNav.addEventListener('click', function(e) {
    if (e.target.tagName === 'A') {
      e.preventDefault();
      const categoria = e.target.textContent.trim().toLowerCase();
      categoriaSeleccionada = categoria === 'todas' ? null : categoria;
      filtrarProductos();
      // Resaltar categoría activa
      categoriasNav.querySelectorAll('a').forEach(a => a.classList.remove('active'));
      e.target.classList.add('active');
    }
  });
}

function filtrarProductos() {
  const input = document.getElementById('buscador-global');
  const filtro = input.value.toLowerCase();
  const productos = document.querySelectorAll('.productoss__cards');
  const loader = document.getElementById('loader');
  const mensajeVacio = document.getElementById('no-result');

  let encontrados = 0;

  loader.style.display = 'flex';
  mensajeVacio.style.display = 'none';
  productos.forEach(producto => {
    producto.style.opacity = 0;
    producto.style.pointerEvents = 'none';
    setTimeout(() => {
      producto.style.display = 'none';
    }, 200);
  });

  setTimeout(() => {
    productos.forEach(producto => {
      const nombre = producto.querySelector('.productoss__nombre').textContent.toLowerCase();
      const descripcion = producto.querySelector('.productoss__descripcion').textContent.toLowerCase();
      const precio = producto.querySelector('.productoss__precio').getAttribute('data-precio');
      const categoria = producto.getAttribute('data-categoria').toLowerCase();

      const coincideCategoria = !categoriaSeleccionada || categoria === categoriaSeleccionada;
      const coincideFiltro = nombre.includes(filtro) || descripcion.includes(filtro) || precio.includes(filtro);

      if (coincideCategoria && coincideFiltro) {
        producto.style.display = 'block';
        setTimeout(() => {
          producto.style.opacity = 1;
          producto.style.pointerEvents = '';
        }, 10);
        encontrados++;
      } else {
        producto.style.display = 'none';
      }
    });
    loader.style.display = 'none';
    mensajeVacio.style.display = (encontrados === 0) ? 'flex' : 'none';
  }, 300);
}

// Animaciones CSS
const style = document.createElement('style');
style.innerHTML = `
.productoss__cards {
  transition: opacity 0.2s;
}
.categorias-nav__lista a.active {
  font-weight: bold;
  text-decoration: underline;
}
`;
document.head.appendChild(style);
