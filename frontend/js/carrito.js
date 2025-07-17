// Mostrar/ocultar el dropdown del carrito
const cartToggle = document.getElementById('cart-dropdown-toggle');
const cartDropdown = document.getElementById('cart-dropdown');

if (cartToggle && cartDropdown) {
  cartToggle.addEventListener('click', function(e) {
    e.stopPropagation();
    const isVisible = cartDropdown.style.display === 'block';
    cartDropdown.style.display = isVisible ? 'none' : 'block';
    if (!isVisible) {
      cargarResumenCarrito();
    }
  });

  document.addEventListener('click', function(e) {
    if (!cartToggle.contains(e.target) && !cartDropdown.contains(e.target)) {
      cartDropdown.style.display = 'none';
    }
  });
}

// Función simple para cargar el resumen del carrito
function cargarResumenCarrito() {
  fetch('php/carrito_resumen.php')
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById('cart-items-container');
      if (data.items && data.items.length > 0) {
        container.innerHTML = data.items.map(item => `
          <div class="cart-dropdown__item" data-id="${item.id}">
            <span class="cart-dropdown__nombre">${item.nombre}</span>
            <input type="number" class="cart-dropdown__cantidad-input" min="1" value="${item.cantidad}" style="width:40px; margin:0 6px;">
            <span class="cart-dropdown__precio">$${item.precio.toLocaleString()}</span>
            <button class="cart-dropdown__eliminar" title="Eliminar">&times;</button>
          </div>
        `).join('');
      } else {
        container.innerHTML = '<p class="cart-dropdown__empty">Tu carrito está vacío.</p>';
      }
      // Agregar listeners para eliminar y cambiar cantidad
      agregarListenersResumenCarrito();
    })
    .catch(error => console.error('Error:', error));
}

function agregarListenersResumenCarrito() {
  const container = document.getElementById('cart-items-container');
  if (!container) return;
  // Eliminar producto
  container.querySelectorAll('.cart-dropdown__eliminar').forEach(btn => {
    btn.addEventListener('click', function() {
      const itemDiv = this.closest('.cart-dropdown__item');
      const id = itemDiv.getAttribute('data-id');
      eliminarProductoCarrito(id);
    });
  });
  // Cambiar cantidad
  container.querySelectorAll('.cart-dropdown__cantidad-input').forEach(input => {
    input.addEventListener('change', function() {
      const itemDiv = this.closest('.cart-dropdown__item');
      const id = itemDiv.getAttribute('data-id');
      let nuevaCantidad = parseInt(this.value);
      if (isNaN(nuevaCantidad) || nuevaCantidad < 1) nuevaCantidad = 1;
      this.value = nuevaCantidad;
      cambiarCantidadCarrito(id, nuevaCantidad);
    });
  });
}

function eliminarProductoCarrito(id) {
  fetch('php/carrito.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id, eliminar: true })
  })
  .then(res => res.json())
  .then(data => {
    // Actualizar localStorage
    let carritoLS = JSON.parse(localStorage.getItem('carrito')) || {};
    delete carritoLS[id];
    localStorage.setItem('carrito', JSON.stringify(carritoLS));
    cargarResumenCarrito();
    actualizarCarritoUI(data.total_items || 0);
    showToast('Producto eliminado', 'success');
  });
}

function cambiarCantidadCarrito(id, cantidad) {
  fetch('php/carrito.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id, cantidad, actualizar: true })
  })
  .then(res => res.json())
  .then(data => {
    // Actualizar localStorage
    let carritoLS = JSON.parse(localStorage.getItem('carrito')) || {};
    if (carritoLS[id]) carritoLS[id].cantidad = cantidad;
    localStorage.setItem('carrito', JSON.stringify(carritoLS));
    cargarResumenCarrito();
    actualizarCarritoUI(data.total_items || 0);
    showToast('Cantidad actualizada', 'success');
  });
}

// Actualizar badge inmediatamente
function actualizarCarritoUI(totalItems) {
  const badge = document.querySelector('.cart-badge');
  if (badge) {
    badge.textContent = totalItems;
    badge.style.transform = 'scale(1.2)';
    setTimeout(() => badge.style.transform = '', 200);
  }
}

// Toast simple y rápido
function showToast(message, type = 'success') {
  const existingToasts = document.querySelectorAll('.custom-toast');
  existingToasts.forEach(toast => toast.remove());
  
  const toast = document.createElement('div');
  toast.className = `custom-toast ${type}`;
  toast.textContent = message;
  document.body.appendChild(toast);
  
  // Mostrar inmediatamente
  toast.classList.add('show');
  
  // Ocultar después de 1.5 segundos
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 200);
  }, 1500);
}

// Sistema de carrito automático - VERSIÓN LIGERA
class AutoCart {
  constructor() {
    this.timers = new Map();
    this.processingButtons = new Set();
    this.init();
  }

  init() {
    const buttons = document.querySelectorAll('.productoss_btn-carrito');
    buttons.forEach(btn => this.setupAutoAdd(btn));
    this.addStyles();
  }

  setupAutoAdd(btn) {
    const id = btn.getAttribute('data-id');
    const nombre = btn.getAttribute('data-nombre');
    const precio = parseFloat(btn.getAttribute('data-precio'));
    
    // Indicador MUY SIMPLE
    const indicatorContainer = document.createElement('div');
    indicatorContainer.className = 'auto-cart-indicator';
    indicatorContainer.innerHTML = `
      <div class="auto-cart-text">Añadiendo en <span class="auto-cart-timer">4</span>s</div>
      <button class="auto-cart-cancel">×</button>
    `;
    
    document.body.appendChild(indicatorContainer);
    indicatorContainer.style.display = 'none';
    
    let countdown = 4;
    let timer = null;
    
    // Posicionamiento simple
    const positionIndicator = () => {
      const btnRect = btn.getBoundingClientRect();
      indicatorContainer.style.position = 'fixed';
      indicatorContainer.style.top = (btnRect.top - 50) + 'px';
      indicatorContainer.style.left = btnRect.left + 'px';
      indicatorContainer.style.zIndex = '9999';
    };
    
    const startCountdown = () => {
      if (this.timers.has(id)) return;
      
      positionIndicator();
      indicatorContainer.style.display = 'flex';
      countdown = 4;
      
      const countdownEl = indicatorContainer.querySelector('.auto-cart-timer');
      
      timer = setInterval(() => {
        countdown--;
        countdownEl.textContent = countdown;
        
        if (countdown <= 0) {
          clearInterval(timer);
          this.addToCart(btn, id, nombre, precio);
          indicatorContainer.style.display = 'none';
        }
      }, 1000);
      
      this.timers.set(id, timer);
    };
    
    const cancelAutoAdd = () => {
      if (timer) {
        clearInterval(timer);
        this.timers.delete(id);
      }
      indicatorContainer.style.display = 'none';
    };
    
    // Event listeners
    btn.addEventListener('mouseenter', startCountdown);
    btn.addEventListener('focus', startCountdown);
    btn.addEventListener('mouseleave', cancelAutoAdd);
    btn.addEventListener('blur', cancelAutoAdd);
    
    const cancelBtn = indicatorContainer.querySelector('.auto-cart-cancel');
    cancelBtn.addEventListener('click', cancelAutoAdd);
    
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      cancelAutoAdd();
      this.addToCart(btn, id, nombre, precio);
    });
    
    // Solo reposicionar si es necesario
    let scrollTimeout;
    window.addEventListener('scroll', () => {
      if (indicatorContainer.style.display === 'flex') {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(positionIndicator, 10);
      }
    });
  }

  addToCart(btn, id, nombre, precio) {
    if (this.processingButtons.has(id)) return;
    this.processingButtons.add(id);
    
    const cantidadInput = document.getElementById('cantidad_' + id);
    const cantidad = cantidadInput ? parseInt(cantidadInput.value) : 1;
    const maxStock = cantidadInput ? parseInt(cantidadInput.max) : 999999;

    // Obtener carrito de localStorage
    let carritoLS = JSON.parse(localStorage.getItem('carrito')) || {};
    let cantidadEnCarrito = carritoLS[id] ? carritoLS[id].cantidad : 0;
    
    if (cantidadEnCarrito + cantidad > maxStock) {
      showToast('Cantidad máxima alcanzada', 'error');
      btn.disabled = false;
      btn.innerHTML = '<i class="bx bxs-cart"></i> <span>Añadir al carrito</span>';
      this.processingButtons.delete(id);
      return;
    }

    btn.disabled = true;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span class="spinner-mini"></span>';
    
    const badge = document.querySelector('.cart-badge');
    const currentTotal = parseInt(badge.textContent || '0');
    actualizarCarritoUI(currentTotal + cantidad);
    
    fetch('php/carrito.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id, nombre, precio, cantidad })
    })
    .then(res => res.json())
    .then(data => {
      if (data.ok) {
        // Actualizar localStorage
        carritoLS[id] = carritoLS[id] || { nombre, precio, cantidad: 0 };
        carritoLS[id].cantidad += cantidad;
        localStorage.setItem('carrito', JSON.stringify(carritoLS));
        showToast('Producto añadido al carrito', 'success');
        if (cartDropdown && cartDropdown.style.display === 'block') {
          cargarResumenCarrito();
        }
      } else if (data.error === 'stock') {
        showToast('Cantidad máxima alcanzada', 'error');
      } else {
        actualizarCarritoUI(currentTotal);
        showToast('Error al añadir al carrito', 'error');
      }
      btn.disabled = false;
      btn.innerHTML = originalText;
      this.processingButtons.delete(id);
    })
    .catch(() => {
      actualizarCarritoUI(currentTotal);
      showToast('Error al añadir al carrito', 'error');
      btn.disabled = false;
      btn.innerHTML = originalText;
      this.processingButtons.delete(id);
    });
  }

  addStyles() {
    const style = document.createElement('style');
    style.innerHTML = `
      .auto-cart-indicator {
        display: none;
        background: #333;
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 13px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        position: fixed;
        z-index: 9999;
        min-width: 140px;
        max-width: 200px;
      }
      
      .auto-cart-text {
        margin-right: 8px;
      }
      
      .auto-cart-timer {
        font-weight: bold;
        color: #4CAF50;
      }
      
      .auto-cart-cancel {
        background: none;
        border: none;
        color: #ccc;
        cursor: pointer;
        font-size: 16px;
        padding: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      
      .auto-cart-cancel:hover {
        background: #555;
        color: white;
      }
      
      .custom-toast {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: #333;
        color: white;
        padding: 10px 16px;
        border-radius: 4px;
        font-size: 14px;
        opacity: 0;
        z-index: 10000;
        transition: opacity 0.2s;
      }
      
      .custom-toast.show { opacity: 1; }
      .custom-toast.error { background: #e74c3c; }
      .custom-toast.success { background: #27ae60; }

      .spinner-mini {
        display: inline-block;
        width: 14px;
        height: 14px;
        border: 2px solid #fff;
        border-top: 2px solid #27ae60;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
      }

      @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }

      .cart-badge {
        transition: transform 0.2s;
      }
      
      /* Móviles */
      @media (max-width: 768px) {
        .auto-cart-indicator {
          left: 50% !important;
          transform: translateX(-50%);
          min-width: 120px;
          font-size: 12px;
          padding: 6px 10px;
        }
        
        .auto-cart-cancel {
          font-size: 14px;
          width: 18px;
          height: 18px;
        }
      }
    `;
    document.head.appendChild(style);
  }
}

// Inicializar cuando el DOM esté listo
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    new AutoCart();
  });
} else {
  new AutoCart();
}