document.querySelectorAll('.productoss__acciones input[type="number"]').forEach(input => {
  input.addEventListener('input', function () {
    const max = parseInt(this.max);
    const value = parseInt(this.value);

    if (value > max) {
      alert(`Solo hay ${max} unidades disponibles de este producto.`);
      this.value = max;
    }
  });
});