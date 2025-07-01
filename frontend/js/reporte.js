document.addEventListener("DOMContentLoaded", function () {
  const botonDescargar = document.querySelector('.btn-descargar-reporte');

  if (botonDescargar) {
    botonDescargar.addEventListener('click', () => {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();

      // Título del documento
      doc.setFontSize(16);
      doc.text("Reporte de Productos", 14, 15);

      // Encabezados de la tabla
      const headers = [["Nombre", "Categoría", "Precio (COP)", "Stock", "Fecha de creación"]];

      // Recoger datos de cada tarjeta de producto
      const productos = document.querySelectorAll(".admin-producto-card");

      const rows = [];

      productos.forEach(producto => {
        const nombre = producto.querySelector("h4")?.innerText || "";
        const categoria = producto.querySelector("p:nth-of-type(1)")?.innerText.replace("Categoría: ", "") || "";
        const precio = producto.querySelector("p:nth-of-type(3)")?.innerText.replace("Precio: COP $", "") || "";
        const stock = producto.querySelector("p:nth-of-type(4)")?.innerText.replace("Stock: ", "") || "";
        const fecha = producto.querySelector("p:nth-of-type(5)")?.innerText.replace("Fecha creación: ", "") || "";

        rows.push([nombre, categoria, precio, stock, fecha]);
      });

      // Crear la tabla con autoTable
      doc.autoTable({
        startY: 25,
        head: headers,
        body: rows,
        styles: {
          fontSize: 10,
          cellPadding: 3,
        },
        headStyles: {
          fillColor: [41, 128, 185], // Azul
          textColor: 255,
          halign: 'center',
        },
        bodyStyles: {
          textColor: 50,
        },
        alternateRowStyles: {
          fillColor: [240, 240, 240],
        },
      });

      // Guardar el PDF
      doc.save("reporte_productos.pdf");
    });
  }
});
