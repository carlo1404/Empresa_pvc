<div align="center">
  <img src="https://img.icons8.com/color/96/000000/pvc-pipe.png" alt="PVC Logo" width="120"/>
  
  <h1>PVC Project</h1>
  <p><b>Plataforma elegante y moderna para la gestión y venta de productos de PVC</b></p>
  
  <p>
    <img src="https://img.shields.io/badge/Frontend-HTML%2FCSS%2FJS-blue?style=for-the-badge"/>
    <img src="https://img.shields.io/badge/Backend-PHP-green?style=for-the-badge"/>
    <img src="https://img.shields.io/badge/Auth-Google%20OAuth2-red?style=for-the-badge"/>
    <img src="https://img.shields.io/badge/By-Carlos%20Reyes-black?style=for-the-badge"/>
  </p>
</div>

---

## ✨ Descripción

PVC Project es una plataforma web responsiva y visualmente atractiva para la gestión, visualización y venta de productos de PVC. Incluye autenticación segura, panel de administración, carrito de compras y un frontend moderno.

---

## 🚀 Características principales

- **Frontend atractivo y responsivo** (HTML5, CSS3, JS)
- **Catálogo de productos** con imágenes, descripciones y categorías
- **Buscador global** instantáneo
- **Carrito de compras** interactivo
- **Descuentos destacados**
- **Login seguro** (tradicional y Google OAuth 2.0)
- **Panel de administración** para gestión avanzada

---

## 🖼️ Interfaz de usuario

<div align="center">
  <img src="img/Designer.png" alt="Vista principal" width="60%"/>
</div>

<div align="center">
  <table>
    <tr>
      <td align="center"><img src="img/imagen1.jpg" alt="Producto 1" width="180"/></td>
      <td align="center"><img src="img/imagen2.jpg" alt="Producto 2" width="180"/></td>
      <td align="center"><img src="img/imagen3.jpg" alt="Producto 3" width="180"/></td>
    </tr>
  </table>
</div>

> El diseño utiliza **Boxicons**, **Google Fonts** (Bebas Neue, Gidole, Poppins) y animaciones suaves para una experiencia premium.

---

## 🎬 Demo interactivo

<div align="center">
  <img src="https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExb2J2d3F2b2Z2d3F2b2Z2d3F2b2Z2d3F2b2Z2d3F2b2Z2d3F2/giphy.gif" alt="Demo" width="60%"/>
</div>

---

## 📹 Video demo

<div align="center">
  <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">
    <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/0.jpg" alt="Demo YouTube" width="400"/>
    <br>
    <b>Ver video en YouTube</b>
  </a>
</div>

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

```text
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
- **Composer** para dependencias

---

## 📦 Instalación rápida

1. Clona el repositorio en tu servidor local (XAMPP recomendado).
2. Ejecuta `composer install` para instalar dependencias PHP.
3. Configura tu base de datos y ajusta los datos de conexión en `conexion.php`.
4. Registra tu URI de redirección en Google Cloud Console para el login con Google.
5. Accede a `http://localhost/pvc_project/` en tu navegador.

---

## 🔒 Seguridad y buenas prácticas

- **Nunca subas tus secrets (Client ID/Secret) al repositorio.** Usa archivos ignorados como `config_oauth.php`.
- **Utiliza HTTPS** en producción para proteger los datos de tus usuarios.
- **Actualiza dependencias** regularmente con Composer.
- **Haz backup de tu base de datos** periódicamente.

---

## 📸 Vista previa adicional

<div align="center">
  <img src="img/fondo.jpg" alt="Fondo elegante" width="300"/>
  <img src="img/hombre.jpeg" alt="Ejemplo de usuario" width="300"/>
</div>

---

<div align="center">
  <b>© 2024 Carlos Reyes</b><br>
  Este proyecto es de uso personal y educativo. Todos los derechos reservados.<br><br>
  <b>¡Gracias por usar y contribuir a PVC Project!</b>
  <br><br>
  <a href="https://www.linkedin.com/in/tu-perfil" target="_blank"><img src="https://img.shields.io/badge/LinkedIn-blue?logo=linkedin&style=for-the-badge"/></a>
  <a href="https://github.com/carlo1404" target="_blank"><img src="https://img.shields.io/badge/GitHub-black?logo=github&style=for-the-badge"/></a>
  <a href="mailto:brunoreyes150@gmail.com" target="_blank"><img src="https://img.shields.io/badge/Email-red?logo=gmail&style=for-the-badge"/></a>
</div> 