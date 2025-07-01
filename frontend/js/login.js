// login.js

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.form');
    if (!form) return;
    const inputs = form.querySelectorAll('input[required]');
  
    // Añadir contenedores para errores e íconos
    inputs.forEach(input => {
      const wrapper = input.closest('.input-wrapper');
      if (!wrapper.querySelector('.error-message')) {
        const error = document.createElement('span');
        error.classList.add('error-message');
        wrapper.appendChild(error);
      }
      if (!wrapper.querySelector('.validation-icon')) {
        const validIcon = document.createElement('i');
        validIcon.classList.add('bx', 'bx-check-circle', 'validation-icon');
        wrapper.appendChild(validIcon);
      }
    });
  
    form.addEventListener('submit', event => {
      event.preventDefault();
      let formValid = true;
  
      inputs.forEach(input => {
        const errorEl = input.closest('.input-wrapper').querySelector('.error-message');
        const iconEl = input.closest('.input-wrapper').querySelector('.validation-icon');
        errorEl.textContent = '';
        iconEl.style.opacity = 0;
  
        // Validación general
        if (!input.value.trim()) {
          showError(input, 'Campo obligatorio');
          formValid = false;
          return;
        }
  
        // Validación de email
        if (input.type === 'email') {
          const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!regex.test(input.value)) {
            showError(input, 'Email inválido');
            formValid = false;
            return;
          }
        }
  
        // Resto de validaciones específicas si existieran
        // (confirm_password no existe en login)
  
        // Si válido: mostrar icono
        iconEl.style.opacity = 1;
      });
  
      if (formValid) {
        form.classList.add('success');
        setTimeout(() => form.submit(), 600);
      }
    });
  
    function showError(input, message) {
      const wrapper = input.closest('.input-wrapper');
      const errorEl = wrapper.querySelector('.error-message');
      errorEl.textContent = message;
      shake(input);
    }
  
    function shake(el) {
      el.classList.add('shake');
      setTimeout(() => el.classList.remove('shake'), 400);
    }
  });