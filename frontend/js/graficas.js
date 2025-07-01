// Función helper para formatear a COP
const formatCOP = value => 
    new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', maximumFractionDigits: 0 })
      .format(value);
  
  // 1. Ganancia Mensual
  new Chart(document.getElementById("gananciaChart"), {
    type: 'line',
    data: {
      labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun"],
      datasets: [{
        label: "Ganancia",
        data: [1200000, 1500000, 1800000, 1300000, 1700000, 2100000],
        borderColor: "#4CAF50",
        backgroundColor: "rgba(76, 175, 80, 0.2)",
        fill: true,
        tension: 0.4
      }]
    },
    options: {
      responsive: true,
      interaction: { mode: 'index', intersect: false },
      plugins: {
        title: { display: true, text: 'Ganancia mensual', font: { size: 18 } },
        tooltip: {
          enabled: true,
          callbacks: {
            label: ctx => ` ${formatCOP(ctx.raw)}`
          }
        },
        legend: {
          display: true,
          position: 'bottom',
          labels: { usePointStyle: true, padding: 20 },
          onClick: (e, item, legend) => {
            const ci = legend.chart;
            const meta = ci.getDatasetMeta(item.datasetIndex);
            meta.hidden = !meta.hidden;
            ci.update();
          }
        }
      },
      scales: {
        x: { grid: { display: false }, ticks: { color: '#ccc' } },
        y: { beginAtZero: true, ticks: { callback: val => formatCOP(val), color: '#ccc' } }
      },
      animations: {
        tension: { duration: 1000, easing: 'easeInOutQuad', from: 0.4, to: 0, loop: true }
      }
    }
  });
  
  // 2. Inversión Total
  new Chart(document.getElementById("inversionChart"), {
    type: 'bar',
    data: {
      labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun"],
      datasets: [{
        label: "Inversión",
        data: [800000, 900000, 1100000, 1000000, 1200000, 1150000],
        backgroundColor: "#2196F3"
      }]
    },
    options: {
      responsive: true,
      interaction: { mode: 'index', intersect: false },
      plugins: {
        title: { display: true, text: 'Inversión total', font: { size: 18 } },
        tooltip: {
          enabled: true,
          callbacks: {
            label: ctx => ` ${formatCOP(ctx.raw)}`
          }
        },
        legend: { display: false }
      },
      scales: {
        x: { grid: { display: false }, ticks: { color: '#ccc' } },
        y: { beginAtZero: true, ticks: { callback: val => formatCOP(val), color: '#ccc' } }
      },
      animations: {
        y: { duration: 800, easing: 'easeOutBounce' }
      }
    }
  });
  
  // 3. Total de productos
  new Chart(document.getElementById("totalProductosChart"), {
    type: 'doughnut',
    data: {
      labels: ["Activos", "Agotados", "En descuento"],
      datasets: [{
        data: [120, 40, 30],
        backgroundColor: ["#FF9800", "#F44336", "#9C27B0"]
      }]
    },
    options: {
      responsive: true,
      plugins: {
        title: { display: true, text: 'Distribución de productos', font: { size: 18 } },
        tooltip: {
          enabled: true,
          callbacks: {
            label: ctx => `${ctx.label}: ${ctx.raw}`
          }
        },
        legend: {
          display: true,
          position: 'bottom',
          labels: { usePointStyle: true, padding: 16 }
        }
      },
      animations: {
        scale: { duration: 1000, easing: 'easeOutBack' }
      }
    }
  });
  
  // 4. Posibles ganancias vs pérdidas
  new Chart(document.getElementById("posiblesChart"), {
    type: 'bar',
    data: {
      labels: ["Ganancias esperadas", "Pérdidas esperadas"],
      datasets: [{
        label: "Proyección",
        data: [2000000, 400000],
        backgroundColor: ["#4CAF50", "#E91E63"]
      }]
    },
    options: {
      responsive: true,
      interaction: { mode: 'index', intersect: false },
      plugins: {
        title: { display: true, text: 'Proyección de ganancias y pérdidas', font: { size: 18 } },
        tooltip: {
          enabled: true,
          callbacks: {
            label: ctx => ` ${formatCOP(ctx.raw)}`
          }
        },
        legend: { display: false }
      },
      scales: {
        x: { grid: { display: false }, ticks: { color: '#ccc' } },
        y: { beginAtZero: true, ticks: { callback: val => formatCOP(val), color: '#ccc' } }
      },
      animations: {
        y: { duration: 800, easing: 'easeOutElastic' }
      }
    }
  });
  