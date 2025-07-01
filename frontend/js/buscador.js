function filtrarProductos() {
  const input = document.getElementById('buscador-global');
  const filtro = input.value.toLowerCase();
  const productos = document.querySelectorAll('.productoss__cards');
  const loader = document.getElementById('loader');
  const mensajeVacio = document.getElementById('no-result');

  let encontrados = 0;

  // Mostrar loader y ocultar productos y mensaje vacío
  loader.style.display = 'flex';
  mensajeVacio.style.display = 'none';
  productos.forEach(producto => {
    producto.style.display = 'none';
  });

  // Simular "tiempo de carga"
  setTimeout(() => {
    productos.forEach(producto => {
      const nombre = producto.querySelector('.productoss__nombre').textContent.toLowerCase();
      const descripcion = producto.querySelector('.productoss__descripcion').textContent.toLowerCase();

      if (nombre.includes(filtro) || descripcion.includes(filtro)) {
        producto.style.display = 'block';
        encontrados++;
      } else {
        producto.style.display = 'none';
      }
    });

    // Ocultar loader
    loader.style.display = 'none';

    // Mostrar mensaje si no hay resultados
    mensajeVacio.style.display = (encontrados === 0) ? 'flex' : 'none';

  }, 300); // 300ms para darle suavidad
}
