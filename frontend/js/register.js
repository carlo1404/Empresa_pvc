// register.js

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.form');
    const inputs = form.querySelectorAll('input[required]');
  
    // Añade un span para mensajes de error en cada input-wrapper
    inputs.forEach(input => {
      const wrapper = input.closest('.input-wrapper');
      const error = document.createElement('span');
      error.classList.add('error-message');
      wrapper.appendChild(error);
  
      // Añadir icono de validación
      const validIcon = document.createElement('i');
      validIcon.classList.add('bx', 'bx-check-circle', 'validation-icon');
      wrapper.appendChild(validIcon);
    });
  
    form.addEventListener('submit', e => {
      e.preventDefault();
      let valid = true;
  
      inputs.forEach(input => {
        const error = input.closest('.input-wrapper').querySelector('.error-message');
        const validIcon = input.closest('.input-wrapper').querySelector('.validation-icon');
        error.textContent = '';
        validIcon.style.opacity = 0;
  
        // Validación básica
        if (!input.value.trim()) {
          error.textContent = 'Este campo es obligatorio';
          valid = false;
          shake(input);
        }
  
        // Validar email
        if (input.type === 'email' && input.value) {
          const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!pattern.test(input.value)) {
            error.textContent = 'Email no válido';
            valid = false;
            shake(input);
          }
        }
  
        // Confirmar contraseña
        if (input.id === 'confirm_password') {
          const pwd = form.querySelector('#password').value;
          if (input.value !== pwd) {
            error.textContent = 'Contraseñas no coinciden';
            valid = false;
            shake(input);
          }
        }
  
        // Longitud mínima de contraseña
        if (input.id === 'password' && input.value) {
          if (input.value.length < 6) {
            error.textContent = 'Mínimo 6 caracteres';
            valid = false;
            shake(input);
          }
        }
  
        // Si no hay error, mostrar ícono de éxito
        if (!error.textContent) {
          validIcon.style.opacity = 1;
        }
      });
  
      if (valid) {
        // Animación de éxito
        form.classList.add('success');
        setTimeout(() => form.submit(), 800);
      }
    });
  
    // Función para efecto shake
    function shake(element) {
      element.classList.add('shake');
      setTimeout(() => element.classList.remove('shake'), 500);
    }
  });