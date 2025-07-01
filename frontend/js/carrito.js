document.addEventListener("DOMContentLoaded", () => {
    const botonesCarrito = document.querySelectorAll(".productoss_btn-carrito");

    botonesCarrito.forEach(boton => {
        boton.addEventListener("click", () => {
            const id = boton.getAttribute("data-id");
            const nombre = boton.getAttribute("data-nombre");
            const precio = boton.getAttribute("data-precio");
            const cantidad = document.querySelector(`#cantidad_${id}`).value;

            fetch('php/carrito.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id, nombre, precio, cantidad })
            })
            .then(res => res.json())
            .then(data => {
                if (data.ok) {
                    alert(`✅ ${nombre} añadido al carrito.`);
                    document.querySelector("#contador-carrito").textContent = data.total_items;
                } else {
                    alert("❌ Error al añadir al carrito");
                }
            });
        });
    });
});