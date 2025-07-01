# PVC Project

<p align="center">
  <img src="https://img.icons8.com/color/96/000000/pvc-pipe.png" alt="PVC Logo" width="120"/>
</p>

<p align="center">
  <b>Una plataforma moderna y elegante para la gestión y venta de productos de PVC</b>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Frontend-HTML%2FCSS%2FJS-blue?style=for-the-badge"/>
  <img src="https://img.shields.io/badge/Backend-PHP-green?style=for-the-badge"/>
  <img src="https://img.shields.io/badge/Auth-Google%20OAuth2-red?style=for-the-badge"/>
  <img src="https://img.shields.io/badge/By-Carlos%20Reyes-black?style=for-the-badge"/>
</p>

---

## 🚀 Características principales

- **Frontend atractivo y responsivo**: desarrollado con HTML5, CSS3 y JavaScript moderno.
- **Catálogo de productos**: visualización de productos con imágenes, descripciones, precios y categorías.
- **Buscador global**: búsqueda instantánea de productos por nombre o categoría.
- **Carrito de compras**: añade productos y gestiona cantidades fácilmente.
- **Descuentos destacados**: sección especial para productos en promoción.
- **Login seguro**: autenticación tradicional y con Google OAuth 2.0.
- **Panel de administración**: gestión de productos y categorías (solo para administradores).

---

## 🖼️ Interfaz de usuario

<p align="center">
  <img src="img/Designer.png" alt="Vista principal" width="600"/>
</p>

<p align="center">
  <img src="img/fondo.jpg" alt="Fondo elegante" width="300"/>
  <img src="img/hombre.jpeg" alt="Ejemplo de usuario" width="300"/>
</p>

> El frontend está diseñado para ser intuitivo y visualmente atractivo, utilizando:
> - **Boxicons** para iconografía moderna.
> - **Google Fonts** (Bebas Neue, Gidole, Poppins) para una tipografía elegante.
> - **Animaciones y transiciones suaves** para una experiencia de usuario premium.

---

## 🎬 Demo interactivo

![Demo de la plataforma](https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExb2J2d3F2b2Z2d3F2b2Z2d3F2b2Z2d3F2b2Z2d3F2b2Z2d3F2/giphy.gif)

---

## 💡 Ejemplo de interactividad con JavaScript

```js
// Buscador interactivo de productos
const input = document.getElementById('buscador-global');
input.addEventListener('input', function() {
  const query = this.value.toLowerCase();
  document.querySelectorAll('.productoss__cards').forEach(card => {
    const nombre = card.querySelector('.productoss__nombre').textContent.toLowerCase();
    card.style.display = nombre.includes(query) ? '' : 'none';
  });
});
```

---

## 📁 Estructura del proyecto

```
pvc_project/
├── frontend/
│   ├── index.css
│   ├── header.css
│   ├── component/
│   │   ├── main.css
│   │   └── variables.css
│   └── js/
│       ├── buscador.js
│       ├── carousel.js
│       └── ...
├── img/
├── php/
│   ├── components/
│   │   └── header.php
│   ├── google_oauth.php
│   └── ...
├── admin/
├── uploads/
└── index.php
```

---

## 🛠️ Tecnologías utilizadas
- **HTML5, CSS3, JavaScript**
- **PHP 8+**
- **Google OAuth 2.0**
- **MySQL** (vía PDO)
- **Composer** para gestión de dependencias

---

## 📦 Instalación rápida
1. Clona el repositorio en tu servidor local (XAMPP recomendado).
2. Ejecuta `composer install` para instalar dependencias PHP.
3. Configura tu base de datos y ajusta los datos de conexión en `conexion.php`.
4. Registra tu URI de redirección en Google Cloud Console para el login con Google.
5. Accede a `http://localhost/pvc_project/` en tu navegador.

---

## 📸 Vista previa

<p align="center">
  <img src="img/imagen1.jpg" alt="Producto destacado" width="250"/>
  <img src="img/imagen2.jpg" alt="Producto destacado" width="250"/>
  <img src="img/imagen3.jpg" alt="Producto destacado" width="250"/>
</p>

---

## 📝 Licencia y derechos de autor

<p align="center">
  <b>© 2024 Carlos Reyes</b><br>
  Este proyecto es de uso personal y educativo. Todos los derechos reservados.
</p>

---

<p align="center">
  <b>¡Gracias por usar y contribuir a PVC Project!</b>
</p> 